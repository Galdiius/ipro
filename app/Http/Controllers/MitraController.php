<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Str;
use App\Http\Controllers\VerifyController;
use App\Models\Mitra;
use Illuminate\Validation\Rule;


class MitraController extends Controller
{
    public function index(){
        if(request()->search){
            $mitra = DB::table('mitra')->select(['mitra.*',DB::raw('COUNT(pengepul.nama_petugas) as jumlah_pengepul')])
            ->leftJoin('pengepul','mitra.id','=','pengepul.id_mitra')
            ->where([
                ['mitra.nama','LIKE',"%".request()->search."%"],
                ["mitra.id_proyek","=",session('id')]
            ])
            ->groupBy('mitra.id')
            ->paginate(3);
        }else{
            $mitra = DB::table('mitra')->select(['mitra.*',DB::raw('COUNT(pengepul.nama_petugas) as jumlah_pengepul')])
            ->leftJoin('pengepul','mitra.id','=','pengepul.id_mitra')
            ->where('mitra.id_proyek',session('id'))
            ->groupBy('mitra.id')
            ->paginate(3);
        }
        $user = DB::table(session('level'))->where('id',session('id'))->first();
        return view('mitra/index',[
            "user" => $user,
            "mitra" => $mitra
        ]);
    }
    public function profile($id){
        $mitra = Mitra::where([
            "id" => $id,
        ])->firstOrFail();
        $user = DB::table(session('level'))->where('id',session('id'))->first();
        return view('mitra/profile',["pengepul" => $mitra,"user" => $user]);
    }
    public function hapus(){
        DB::transaction(function(){
            DB::table('pengepul')->where('id_mitra',request()->no_user)->update([
                'id_mitra' => '',
                'id_proyek' => session('id')
            ]);
            DB::table('mitra')->where('id',request()->no_user)->delete();
        });
        return redirect()->back()->with('message',[
            "type" => "success",
            "message" => "mitra berhasil dihapus"
        ]);
    }
    public function tambah(){
        $user = DB::table(session('level'))->where('id',session('id'))->first();
        $proyek = DB::table('proyek')->get();
        return view('mitra/tambah',[
            "user" => $user,
            "proyek" => $proyek
        ]);
    }
    public function _tambah(){
        $id = IdGenerator::generate(['table' => 'mitra','length' => 8, 'prefix' => 'M-']);
        $validated = request()->validate([
            "nama" => "required|unique:mitra,nama|min:2",
            // "alamat" => "required",
            "no_telepon" => "required|unique:pengepul,no_hp|unique:mitra,no_hp|unique:proyek,no_hp|min:10",
            "koordinat" => "required",
        ]);
        $token = Str::random(10);
        // $verifikasi = new VerifyController();
        // kirim 
        // if(request()->verifikasi == "sms"){
        //     $sendSms = $verifikasi->sendSms($validated['no_telepon'],"localhost:8000/verifikasi/$token");
        //     if($sendSms["status"] == 0){
        //         return redirect()->back()->with("message",[
        //             "type" => "danger",
        //             "message" => "No tujuan tidak valid"
        //         ]);
        //     }
        // }else if(request()->verifikasi == "whatsapp"){
        //     $sendWa = $verifikasi->sendWa($validated['no_telepon'],"localhost:8000/verifikasi/$token");
        //     if($sendWa["status"] == 0){
        //         return redirect()->back()->with("message",[
        //             "type" => "danger",
        //             "message" => "No tujuan tidak valid"
        //         ]);
        //     }
        // }
        DB::table('mitra')->insert([
            "id" => $id,
            "nama" => $validated["nama"],
            // "alamat" => $validated["alamat"],
            "no_hp" => $validated["no_telepon"],
            "koordinat" => $validated["koordinat"],
            "status" => "0",
            "token" => $token,
            "id_proyek" => request()->proyek
        ]);
        return redirect('/mitra')->with("message",
            [
            "type" => "success",
            "message" => "mitra berhasil ditambahkan"
            ]);
    }


    public function edit($id){
        $mitra = Mitra::select('*','id as id_user')->where([
            ['id','=',$id],
            ['status','=','1'],
            ])->firstOrFail();
        $user = DB::table(session('level'))->where('id',session('id'))->first();
        return view('mitra/edit',["mitra" => $mitra,"user" => $user]);
    }

    public function _edit(){
        if(request()->newPassword != null){
            $validated = request()->validate([
                "nama" => [
                    'required',
                    Rule::unique('mitra','nama')->ignore(request()->id,'id')
                ],
                "email" => [
                    "required",
                    "email",
                    Rule::unique('mitra','email')->ignore(request()->id,'id')
                ],
                "alamat" => "required",
                "no_telepon" => [
                    "required",
                    "min:10",
                    Rule::unique('mitra','no_hp')->ignore(request()->id,'id')
                ],
                "koordinat" => "required",
                "newPassword" => "required",
                "confirmNewPassword" => "required"
                ]);
            if($validated['confirmNewPassword'] != $validated['newPassword']){
                return redirect()->back()->with('message',[
                    "type" => "danger",
                    "message" => "Konfirmasi password tidak sesuai"
                ]);
            }else{
                
                DB::table('mitra')->where('id',request()->id)->update([
                    "nama" => $validated['nama'],
                    "email" => $validated['email'],
                    'alamat' => $validated['alamat'],
                    'no_hp' => $validated['no_telepon'],
                    "koordinat" => $validated['koordinat'],
                    'password' => password_hash($validated['newPassword'],PASSWORD_DEFAULT)
                ]);

                return redirect()->back()->with("message",[
                    "type" => "success",
                    "message" => "Data berhasil di ubah"
                ]);

            }
        }else{
            $validated = request()->validate([
                "nama" => [
                    'required',
                    Rule::unique('mitra','nama')->ignore(request()->id,'id')
                ],
                "email" => [
                    "required",
                    "email",
                    Rule::unique('mitra','email')->ignore(request()->id,'id')
                ],
                "alamat" => "required",
                "no_telepon" => [
                    "required",
                    "min:10",
                    Rule::unique('mitra','no_hp')->ignore(request()->id,'id')
                ],
                "koordinat" => "required",
            ]);
            
            DB::table('mitra')->where('id',request()->id)->update([
                "nama" => $validated['nama'],
                "email" => $validated['email'],
                'alamat' => $validated['alamat'],
                'no_hp' => $validated['no_telepon'],
                "koordinat" => $validated['koordinat'],
            ]);

            return redirect()->back()->with("message",[
                "type" => "success",
                "message" => "Data berhasil di ubah"
            ]);
        }
    }

    public function getMitra(){
        $mitra = DB::table('mitra')->where('id',request()->id)->get();
        return json_encode([
            "data" => $mitra
        ]);
    }

    public function editNoHp(){
        $validated = request()->validate([
            "no_hp" => "required"
        ]);
        DB::table('mitra')->where('id',request()->id)->update([
            "no_hp" => $validated['no_hp']
        ]);
        return redirect()->back()->with('message',[
            'type' => 'success',
            "message" => "No hp berhasil diubah"
        ]);
    }
}
