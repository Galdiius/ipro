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
                    ])->paginate(20);
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

                $pengepul = $this->paginate($pengepu,20,null,[
                    "path" => "pengepul"
                ]);
            }
        }else{
            if(session('level') == 'mitra'){
                $pengepul = DB::table('pengepul')->where('id_mitra',session('id'))->paginate(20);
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

                $pengepul = $this->paginate($pengepu,20,null,[
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
        $status = DB::table('status')->get();
        $kategori = DB::table('kategori_p')->get();
        if(session('level') == 'proyek'){
            $mitra = DB::table('mitra')->where([
                ['status','=','1'],
                ['id_proyek','=',session('id')]
            ])->get();
            return view('pengepul/tambah',[
                "user" => $user,
                "mitra" => $mitra,
                "status" => $status,
                "kategori" => $kategori
            ]);
        }
        return view('pengepul/tambah',[
            "user" => $user,
            "status" => $status,
            "kategori" => $kategori
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
        if(session('level') == 'mitra'){
            $validated = request()->validate([
                "namaPetugas" => "required|unique:pengepul,nama_petugas|min:2",
                "namaPerusahaan" => "required:min:2",
                "no_telepon" => "required|unique:pengepul,no_hp|unique:mitra,no_hp|unique:proyek,no_hp|min:10",
                "koordinat" => "required",
                "status" => "required",
                "kategori" => "required"
            ]);
        }else if(session('level') == 'proyek'){
            $validated = request()->validate([
                "namaPetugas" => "required|unique:pengepul,nama_petugas|min:2",
                "namaPerusahaan" => "required:min:2",
                "no_telepon" => "required|unique:pengepul,no_hp|unique:mitra,no_hp|unique:proyek,no_hp|min:10",
                "koordinat" => "required",
                "status" => "required",
                "kategori" => "required",
                "mitra" => "required"
            ]);
        }
        $token = Str::random(10);
        if(session('level') == 'proyek'){
            DB::table('pengepul')->insert([
                "id" => $id,
                "token" => $token,
                "status" => "0",
                "nama_petugas" => $validated['namaPetugas'],
                "nama_perusahaan" => $validated['namaPerusahaan'],
                "no_hp" => $validated['no_telepon'],
                "koordinat" => $validated['koordinat'],
                "id_mitra" => request()->mitra,
                "id_status" => $validated['status'],
                "id_kategori" => $validated['kategori']
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
                "id_status" => $validated['status'],
                "id_mitra" => session('id'),
                "id_kategori" => $validated['kategori']
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
        $kategori = DB::table('kategori_p')->where('id',$pengepul->id_kategori)->first();
        $status = DB::table('status')->where('id',$pengepul->id_status)->first();
        $user = DB::table(session('level'))->where('id',session('id'))->first();
        return view('pengepul/profile',["pengepul" => $pengepul,"user" => $user,"kategori" => $kategori,"status" => $status]);
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

    public function status(){
        $status = DB::table('status')->get();
        $user = DB::table(session('level'))->where('id',session('id'))->first();
        return view('pengepul/status',["user"=> $user,"status" => $status]);
    }
    public function _status(){
        $validated = request()->validate([
            "status" => "required"
        ]);
        DB::table('status')->insert([
            "nama" => $validated['status']
        ]);
        return redirect()->back()->with("message",[
            "type" => "success",
            "message" => "Status berhasil ditambahkan"
        ]);
    }
    public function hapusStatus($id){
        DB::table('status')->where('id',$id)->delete();
        return redirect()->back()->with('message',[
            "type" => "success",
            "message" => "Status berhasil dihapus"
        ]);
    }
    public function editStatus(){
        $validated = request()->validate([
            "edit_status" => "required"
        ]);
        DB::table('status')->where('id',request()->id)->update([
            "nama" => $validated['edit_status']
        ]);
        return redirect()->back()->with('message',[
            "type" => "success",
            "message" => "Status berhasil di edit"
        ]);
    }

    public function kategori(){
        $user = DB::table(session('level'))->where('id',session('id'))->first();
        $kategori = DB::table('kategori_p')->get();
        return view('pengepul/kategori',["user" => $user,"kategori" => $kategori]);
    }

    public function _kategori(){
        $validated = request()->validate([
            "kategori" => "required"
        ]);
        DB::table('kategori_p')->insert([
            "nama_kategori" => $validated['kategori']
        ]);
        return redirect()->back()->with("message",[
            "type" => "success",
            "message" => "Kategori berhasil ditambahkan"
        ]);
    }

    public function hapusKategori($id){
        DB::table('kategori_p')->where('id',$id)->delete();
        return redirect()->back()->with('message',[
            "type" => "success",
            "message" => "Kategori berhasil dihapus"
        ]);
    }

    public function editKategori(){
        $validated = request()->validate([
            "edit_kategori" => "required"
        ]);
        DB::table('kategori_p')->where('id',request()->id)->update([
            "nama_kategori" => $validated['edit_kategori']
        ]);
        return redirect()->back()->with('message',[
            'type' => "success",
            "message" => "Kategori berhasil di edit"
        ]);
    }

    public function editNoHp(){
        $validated = request()->validate([
            "no_hp" => "required"
        ]);
        DB::table('pengepul')->where('id',request()->id)->update([
            "no_hp" => $validated['no_hp']
        ]);
        return redirect()->back()->with('message',[
            'type' => 'success',
            "message" => "No hp berhasil diubah"
        ]);
    }
}
