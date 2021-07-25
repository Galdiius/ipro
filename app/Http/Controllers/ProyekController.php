<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Proyek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
class ProyekController extends Controller
{

    public function index(){
        if(request()->search){
            $proyek = DB::table('proyek')->where([
                ['proyek.nama','LIKE',"%".request()->search."%"]
            ])
            ->paginate(20);
            
        }else{
            $proyek = DB::table('proyek')->paginate(20);
        }
        
        $user = DB::table(session('level'))->where('id',session('id'))->first();
        return view('proyek/index',[
            "user" => $user,
            "proyek" => $proyek
        ]);
    }


    public function profile(){

        $proyek = DB::table('proyek')->select('proyek.*','kategori.nama as nama_kategori')->join('kategori','proyek.id_kategori','=','kategori.id')->where([
            ['proyek.id','=',request()->id],
        ])
        ->first();
        $user = DB::table(session('level'))->where('id',session('id'))->first();
        return view('proyek/profile',[
            "user" => $user,
            "proyek" => $proyek
        ]);
    }

    public function delete($id){
        Db::table('proyek')->where('id',$id)->delete();
        return redirect()->back()->with('message',[
            'type' => 'success',
            'message' => 'Proyek berhasil dihapus'
        ]);
    }

    public function tambah(){
        $user = DB::table(session('level'))->where('id',session('id'))->first();
        return view('proyek/tambah',['user' => $user]);
    }
    public function _tambah(){
        $validate = request()->validate([
            "nama" => "required|unique:proyek,nama",
            "nama_pic" => "required|unique:proyek,nama_pic",
            "email" => "required|email|unique:proyek,email|unique:mitra,email|unique:pengepul,email",
            "alamat" => "required|min:4",
            "no_telepon" => "required|unique:proyek,no_hp|unique:mitra,no_hp|unique:pengepul,no_hp|min:10",
            "kategori" => "required",
            "material" => "required",
            "koordinat" => "required",
            "password" => "required",
            "konfirmasiPassword" => "required",
            "capex" => "required",
            "opex" => "required",
            "start" => "required",
            "end" => "required"
        ]
        // ,[
        //     'nama.required' => 'Nama tidak boleh kosong',
        //     'nama.unique' => "Nama sudah dipakai",
        //     'email.required' => 'Email tidak boleh kosong',
        //     'email.email' => 'Email tidak valid',
        //     'email.unique' => 'Email sudah dipakai',
        //     'alamat.required' => 'Alamat tidak boleh kosong',
        //     'alamat.min' => "Alamat harus memiliki minimal :min karakter",
        //     'no_telepon.required' => 'No telepon tidak boleh kosong',
        //     'koordinat.required' => 'Koordinat tidak boleh kosong',
        //     'password.required' => 'Password tidak boleh kosong',
        //     'konfirmasiPassword.required' => "Konfirmasi password tidak boleh kosong"  
        // ]
    );
        if($validate['konfirmasiPassword'] != $validate['password']){
            return redirect()->back()->with('message',[
                'type' => 'danger',
                'message' => 'Konfirmasi password tidak sesuai'
            ]);
        }else{
            DB::transaction(function() use($validate) {
                $kategori = new Kategori();
                $kategori->nama = $validate['kategori'];
                $kategori->save();
                $id = $kategori->id;
                DB::table('proyek')->insert([
                    "nama" => $validate['nama'],
                    "nama_pic" => $validate['nama_pic'],
                    "email" => $validate['email'],
                    "alamat" => $validate['alamat'],
                    "no_hp" => $validate['no_telepon'],
                    "koordinat" => $validate['koordinat'],
                    "capex" => $validate['capex'],
                    "opex" => $validate['opex'],
                    "start" => $validate['start'],
                    "end" => $validate['end'],
                    "id_kategori" => $id,
                    "material" => $validate['material'],
                    "password" => password_hash($validate['password'],PASSWORD_DEFAULT)
                ]);
            });
            return redirect()->back()->with('message',[
                'type' => 'success',
                'message' => 'Proyek berhasil ditambahkan'
            ]);
        }
    }

    public function edit($id){
        $proyek = DB::table('proyek')->select('proyek.*','kategori.nama as nama_kategori')->where('proyek.id',$id)->join('kategori','proyek.id_kategori','=','kategori.id')->first();
        $user = DB::table(session('level'))->where('id',session('id'))->first();
        $kategori = DB::table('kategori')->where('id',$proyek->id_kategori)->first();
        return view('proyek/edit',['proyek' => $proyek,'user' => $user,"kategori"=>$kategori]);
    }

    public function _edit(){
        if(request()->newPassword != null){
            $validated = request()->validate([
                "nama" => [
                    'required',
                    Rule::unique('proyek','nama')->ignore(request()->id,'id')
                ],
                "nama_pic" => "required",
                "email" => [
                    "required",
                    "email",
                    Rule::unique('proyek','email')->ignore(request()->id,'id')
                ],
                "alamat" => "required",
                "no_telepon" => [
                    "required",
                    "min:10",
                    Rule::unique('proyek','no_hp')->ignore(request()->id,'id')
                ],
                "koordinat" => "required",
                "newPassword" => "required",
                "confirmNewPassword" => "required",
                "capex" => "required",
                "opex" => "required" ,
                "start" => "required",
                "end" => "required",
                "material" => "required",
                "kategori" => "required"
                ]); 
            if($validated['confirmNewPassword'] != $validated['newPassword']){
                return redirect()->back()->with('message',[
                    "type" => "danger",
                    "message" => "Konfirmasi password tidak sesuai"
                ]);
            }else{
                DB::transaction(function() use($validated){
                    DB::table('proyek')->where('id',request()->id)->update([
                        "nama" => $validated["nama"],
                        "nama_pic" => $validated['nama_pic'],
                        "email" => $validated["email"],
                        "alamat" => $validated["alamat"],
                        "no_hp" => $validated["no_telepon"],
                        "koordinat" => $validated["koordinat"],
                        "password" => password_hash($validated["newPassword"],PASSWORD_DEFAULT),
                        "capex" => $validated['capex'],
                        "opex" => $validated['opex'],
                        "start" => $validated['start'],
                        "end" => $validated['end'],
                        "material" => $validated['material']
                    ]);

                    DB::table('kategori')->where('id',request()->id_kategori)->update([
                        "nama" => $validated['kategori']
                    ]);
                });
                return redirect()->back()->with("message",[
                    "type" => "success",
                    "message" => "Data berhasil di ubah"
                ]);

            }
        }else{
            $validated = request()->validate([
                "nama" => [
                    'required',
                    Rule::unique('proyek','nama')->ignore(request()->id,'id')
                ],
                "nama_pic" => "required",
                "email" => [
                    "required",
                    "email",
                    Rule::unique('proyek','email')->ignore(request()->id,'id')
                ],
                "alamat" => "required",
                "no_telepon" => [
                    "required",
                    "min:10",
                    Rule::unique('proyek','no_hp')->ignore(request()->id,'id')
                ],
                "koordinat" => "required",
                "capex" => "required",
                "opex" => "required",
                "start" => "required",
                "end" => "required",
                "material" => "required",
                "kategori" => "required"
            ]);
            DB::transaction(function() use($validated){
                DB::table('proyek')->where('id',request()->id)->update([
                    "nama" => $validated["nama"],
                    "nama_pic" => $validated['nama_pic'],
                    "email" => $validated["email"],
                    "alamat" => $validated["alamat"],
                    "no_hp" => $validated["no_telepon"],
                    "koordinat" => $validated["koordinat"],
                    "capex" => $validated['capex'],
                    "opex" => $validated['opex'],
                    "start" => $validated['start'],
                    "end" => $validated['end'],
                    "material" => $validated['material']
                ]);
                DB::table('kategori')->where('id',request()->id_kategori)->update([
                    "nama" => $validated["kategori"]
                ]);
            });
            return redirect()->back()->with("message",[
                "type" => "success",
                "message" => "Data berhasil di ubah"
            ]);
        }
    }

    public function peningkatan(){
        $user = DB::table('proyek')->where('id',session('id'))->first();
        $jenis = DB::table('jenis')->where('id_kategori',$user->id_kategori)->get();
        return view('proyek/peningkatan',['user'=>$user,'jenis'=>$jenis]);
    }
    public function _peningkatan(){
        $validate = request()->validate([
            "target" => "required",
            "aktual" => "required",
            "growth" => "required"
        ]);
        DB::table('peningkatan')->where('id',request()->id_p)->update([
            "target" => $validate['target'],
            "aktual" => $validate['aktual'],
            "growth" => $validate['growth']
        ]);
        return redirect()->back();
    }
}
