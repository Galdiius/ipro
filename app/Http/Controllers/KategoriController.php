<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class KategoriController extends Controller
{
    public function index(){
        $user = DB::table(session('level'))->where('id',session('id'))->first();
        $kategori = DB::table('kategori')->paginate(10);
        return view('kategori/index',['user'=>$user,"kategori" => $kategori]);
    }
    public function tambah(){
        $validated = request()->validate([
            "nama" => "required|unique:kategori,nama"
        ],[
            "nama.unique" => "kategori sudah ada"
        ]);
        DB::table('kategori')->insert([
            "nama" => strtolower($validated["nama"])
        ]);
        return redirect()->back()->with("message","Kategori berhasil ditambahkan");
    }
    public function hapus(){
        DB::table('kategori')->where('id',request()->id)->delete();
        return redirect()->back()->with('message',"Kategori berhasil dihapus");
    }
    public function edit(){
        $validated = request()->validate([
            "nama" => [
                "required",
                Rule::unique("kategori","nama")->ignore(request()->id,"id")
            ]
        ],[
            "nama.unique" => "Kategori sudah ada"
        ]);
        DB::table('kategori')->where('id','=',request()->id)->update([
            "nama" => $validated['nama']
        ]);
        return redirect()->back()->with("message","Kategori berhasil diedit");
    }
}
