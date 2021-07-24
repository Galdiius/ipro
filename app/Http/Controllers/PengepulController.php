<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Http\Controllers\VerifyController;
use App\Models\Pengepul;
use Illuminate\Validation\Rule;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PengepulController extends Controller
{
    public function paginate($items, $perPage = 3, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function index(){
        $user = DB::table(session('level'))->where('id',session('id'))->first();
        if(request()->search){
            if(session('level') == 'mitra'){
                $pengepul = DB::table('pengepul')->where([
                    ['id_mitra','=',session('id')],
                    ["nama_perusahaan",'LIKE','%'.request()->search.'%']
                    ])->paginate(3);
            }else if(session('level') == 'proyek'){
                $pengepu = DB::table('pengepul')
                    ->select('pengepul.*','mitra.nama as nama_mitra')
                    ->join('mitra','pengepul.id_mitra','=','mitra.id')
                    ->where([
                        ['mitra.id_proyek','=',session('id')],
                        ['pengepul.nama_perusahaan','LIKE','%'.request()->search.'%']
                        ])
                    ->get();
                $pengepulNoMitra = DB::table('pengepul')
                    ->where([
                        ['pengepul.id_proyek','=',session('id')],
                        ['pengepul.nama_perusahaan','LIKE','%'.request()->search.'%']
                    ])
                    ->get();
                foreach($pengepulNoMitra as $p){
                    $pengepu->add($p);
                }

                $pengepul = $this->paginate($pengepu,3,null,[
                    "path" => "pengepul"
                ]);
            }
        }else{
            if(session('level') == 'mitra'){
                $pengepul = DB::table('pengepul')->where('id_mitra',session('id'))->paginate(3);
            }else if(session('level') == 'proyek'){
                $pengepu = DB::table('pengepul')
                    ->select('pengepul.*','mitra.nama as nama_mitra')
                    ->join('mitra','pengepul.id_mitra','=','mitra.id')
                    ->where('mitra.id_proyek','=',session('id'))
                    ->get();
                $pengepulNoMitra = DB::table('pengepul')
                    ->where('id_proyek','=',session('id'))
                    ->get();
                foreach($pengepulNoMitra as $p){
                    $pengepu->add($p);
                }

                $pengepul = $this->paginate($pengepu,3,null,[
                    "path" => "pengepul"
                ]);
            }

        }
        return view('pengepul/index',[
            "user" => $user,
            "pengepul" => $pengepul
        ]);
    }
    public function tambah(){
        $user = DB::table(session('level'))->where('id',session('id'))->first();
        if(session('level') == 'proyek'){
            $mitra = DB::table('mitra')->where([
                ['status','=','1'],
                ['id_proyek','=',session('id')]
            ])->get();
            return view('pengepul/tambah',[
                "user" => $user,
                "mitra" => $mitra
            ]);
        }
        return view('pengepul/tambah',[
            "user" => $user
        ]);
    }
    public function _tambah(){
        // dd(request()->all());
        // if(request()->mitra){
        //     dd(request()->mitra);
        // }else{
        //     dd('ko');
        // }
        $id = IdGenerator::generate(['table' => 'pengepul','length' => 8, 'prefix' => 'P-']);
        $validated = request()->validate([
            "namaPetugas" => "required|unique:pengepul,nama_petugas|min:2",
            "namaPerusahaan" => "required:min:2",
            "no_telepon" => "required|unique:pengepul,no_hp|unique:mitra,no_hp|unique:proyek,no_hp|min:10",
            "koordinat" => "required",
        ]);
        $token = Str::random(10);
        $verifikasi = new VerifyController();
        if(request()->verifikasi == 'sms'){
            $sendSms = $verifikasi->sendSms($validated['no_telepon'],"localhost:8000/verifikasi/$token");
            if($sendSms["status"] == 0){
                return redirect()->back()->with("message",[
                    "type" => "danger",
                    "message" => "No tujuan tidak valid"
                ]);
            }
        }else if(request()->verifikasi == "whatsapp"){
            $sendWa = $verifikasi->sendWa($validated['no_telepon'],"localhost:8000/verifikasi/$token");
            if($sendWa["status"] == 0){
                return redirect()->back()->with("message",[
                    "type" => "danger",
                    "message" => "No tujuan tidak valid"
                ]);
            }
        }
        if(session('level') == 'proyek'){
            DB::table('pengepul')->insert([
                "id" => $id,
                "token" => $token,
                "status" => "0",
                "nama_petugas" => $validated['namaPetugas'],
                "nama_perusahaan" => $validated['namaPerusahaan'],
                "no_hp" => $validated['no_telepon'],
                "koordinat" => $validated['koordinat'],
                "id_proyek" => session('id')
            ]);
        }else if(session('level') == 'mitra'){
            DB::table('pengepul')->insert([
                "id" => $id,
                "token" => $token,
                "status" => "0",
                "nama_petugas" => $validated['namaPetugas'],
                "nama_perusahaan" => $validated['namaPerusahaan'],
                "no_hp" => $validated['no_telepon'],
                "koordinat" => $validated['koordinat'],
                "id_mitra" => session('id')
            ]);
        }

        return redirect('/pengepul')->with("message",
            [
                "type" => "success",
                "message" => "Pengepul berhasil ditambahkan"
            ]);
    }
    public function hapus(){
        DB::table('pengepul')->where('id',request()->no_user)->delete();
        return redirect()->back()->with('message',[
            "type" => "success",
            "message" => "Pengepul berhasil dihapus"
        ]);
    }
    public function profile($id){
        $pengepul = Pengepul::where([
            "id" => $id
        ])->firstOrFail();
        $user = DB::table(session('level'))->where('id',session('id'))->first();
        return view('pengepul/profile',["pengepul" => $pengepul,"user" => $user]);
    }
    public function edit($id){
        if(session('level') == 'mitra'){
            $pengepul = Pengepul::select('*','id as id_user')->where([
                ["id",'=',$id],
                ["status",'=','1'],
                ['id_mitra','=',session('id')]
            ])->firstOrFail();
        }else if(session('level') == 'proyek'){
            $penge = Pengepul::select('*','id as id_user')->where([
                ["id",'=',$id],
                ["status",'=','1'],
            ])->firstOrFail();
            if($penge->id_proyek == null){
                $mitra = DB::table('mitra')->where('id',$penge->id_mitra)->first();
                if($mitra->id_proyek == session('id')){
                    $pengepul = $penge;
                }else{
                    abort(404);
                }
            }else{
                $pengepul = Pengepul::select('*','id as id_user')->where([
                    ["id",'=',$id],
                    ["status",'=','1'],
                    ['id_proyek','=',session('id')]
                ])->firstOrFail();
            }
        }else if( session('level') == 'admin'){
            $pengepul = Pengepul::select('*','id as id_user')->where([
                ["id",'=',$id],
                ["status",'=','1'],
            ])->firstOrFail();
        }
        $user = DB::table(session('level'))->where('id',session('id'))->first();
        return view('pengepul/edit',["pengepul" => $pengepul,"user" => $user]);
    }

    public function _edit(){
        if(request()->newPassword != null){
            $validated = request()->validate([
                "nama" => [
                    'required',
                    Rule::unique('mitra','nama')->ignore(request()->id,'id')
                ],
                "namaPerusahaan" => "required",
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
                
                DB::table('pengepul')->where('id',request()->id)->update([
                    "nama_petugas" => $validated['nama'],
                    "nama_perusahaan" => $validated['namaPerusahaan'],
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
                "namaPerusahaan" => "required",
                // "email" => [
                //     "required",
                //     "email",
                //     Rule::unique('mitra','email')->ignore(request()->id,'id')
                // ],
                // "alamat" => "required",
                "no_telepon" => [
                    "required",
                    "min:10",
                    Rule::unique('mitra','no_hp')->ignore(request()->id,'id')
                ],
                "koordinat" => "required",
            ]);
            
            DB::table('pengepul')->where('id',request()->id)->update([
                "nama_petugas" => $validated['nama'],
                "nama_perusahaan" => $validated['namaPerusahaan'],
                // "email" => $validated['email'],
                // 'alamat' => $validated['alamat'],
                'no_hp' => $validated['no_telepon'],
                "koordinat" => $validated['koordinat'],
            ]);

            return redirect()->back()->with("message",[
                "type" => "success",
                "message" => "Data berhasil di ubah"
            ]);
        }
    }
}
