<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mitra;
use Illuminate\Support\Facades\DB;

class VerifyController extends Controller
{

    public function index($token){
        $pengepul = DB::table('pengepul')->select('*','id as id_user','nama_petugas as nama')->where([
            "token" => $token,
            "status" => "0"
        ])->first();
        if($pengepul){
            return view('verifikasi/index',['user' => $pengepul,"table" => "pengepul"]);
        }else{
            $mitra = Mitra::select('*','id as id_user')->where([
                'token' => $token,
                'status' => '0'
            ])->firstOrFail();
            return view('verifikasi/index',['user' => $mitra,"table" => "mitra"]);
        }
    }

    public function _verify($token){
        $table = request()->table;
        $validated = request()->validate([
            "email" => "required|email|unique:mitra,email|unique:proyek,email|unique:pengepul,email",
            "alamat" => "required|min:4",
        ]);
        if(request()->konfirmasiPassword != request()->password){
            return redirect()->back()->with('message','Konfirmasi password tidak sesuai');
        }
        DB::table($table)->where('id',request()->id)->update([
            "email" => $validated["email"],
            "alamat" => $validated["alamat"],
            "password" => password_hash(request()->password,PASSWORD_DEFAULT),
            "status" => "1",
            "tanggal_verifikasi" => time()
        ]);
        if($table == "pengepul"){
            return redirect('/login')->with("message","Akun anda berhasil diaktivasi");
        }else{
            return redirect('/login/admin')->with('message','Akun anda berhasil diaktivasi');
        }
    }

    public function sendSms($no,$link){
        $url = 'https://console.zenziva.net/reguler/api/sendsms/';
        $userkey = '19e631cc82f6';
        $passkey = '1c756de8f0b35413714d0431';
        $telepon = $no;
        $message = "link referral anda : $link klik link tersebut untuk mengaktivasi profile anda";
        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $url);
        curl_setopt($curlHandle, CURLOPT_HEADER, 0);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curlHandle, CURLOPT_TIMEOUT,30);
        curl_setopt($curlHandle, CURLOPT_POST, 1);
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, array(
            'userkey' => $userkey,
            'passkey' => $passkey,
            'to' => $telepon,
            'message' => $message
        ));
        $results = json_decode(curl_exec($curlHandle), true);
        curl_close($curlHandle);
        return $results;
    }
    public function sendWa($no,$urlImage){
        $userkey = '19e631cc82f6';
        $passkey = '1c756de8f0b35413714d0431';
        $telepon = $no;
        // $image_link = $this->getUrlqrCode($urlImage);   
        $message  = "Link referral anda : $urlImage klik link tersebut untuk mengaktivasi akun anda";
        $url = 'https://console.zenziva.net/wareguler/api/sendWA/';
        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $url);
        curl_setopt($curlHandle, CURLOPT_HEADER, 0);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curlHandle, CURLOPT_TIMEOUT,30);
        curl_setopt($curlHandle, CURLOPT_POST, 1);
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, array(
            'userkey' => $userkey,
            'passkey' => $passkey,
            'to' => $telepon,
            'message' => $message
        ));
        $results = json_decode(curl_exec($curlHandle), true);
        curl_close($curlHandle);
        return $results;
    }
    
    public function getUrlqrCode($url){
        $ch = curl_init(); 
        $qrCode = "https://api.qrserver.com/v1/create-qr-code/?data=$url";
        curl_setopt($ch, CURLOPT_URL, "https://api.imgbb.com/1/upload?key=1d699ec4b717d2ad6788cfebf3afcb24&image=$qrCode"); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $results = json_decode(curl_exec($ch),true);
        dd($results);
        return $results["data"]["url"];

    }

    public function getQrCode($token,$nama){
        $url = $this->getUrlqrCode('indonesiapro.live/verifikasi/'.$token);
        $filename = $nama.'.png';
        $tempfile = tempnam(sys_get_temp_dir(),$filename);
        copy($url,$tempfile);
        return response()->download($tempfile, $filename);
    }

    public function sendVerifikasi($via,$table,$id){
        $data = DB::table($table)->where('id',$id)->first();
        if($via == "wa"){
            $sendWa = $this->sendWa($data->no_hp,env('URL')."/verifikasi/$data->token");
            if($sendWa["status"] == 1){
                return redirect()->back()->with("message",[
                    "type" => "success",
                    "message" => "Link verifikasi berhasil dikirim"
                ]);
            }else if($sendWa['status'] == 0){
                return redirect()->back()->with("message",[
                    "type" => "danger",
                    "message" => $sendWa['text']
                ]);
            }
        }else if($via == "sms"){
            $sendSms = $this->sendSms($data->no_hp,env('URL')."/verifikasi/$data->token");
            if($sendSms["status"] == 1){
                return redirect()->back()->with("message",[
                    "type" => "success",
                    "message" => "Link verifikasi berhasil dikirim"
                ]);
            }else if($sendSms['status'] == 0){
                return redirect()->back()->with("message",[
                    "type" => "danger",
                    "message" => $sendSms['text']
                ]);
            }
        }
    }

}
