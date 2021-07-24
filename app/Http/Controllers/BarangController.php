<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class BarangController extends Controller
{
    public function index(){
        $user = DB::table(session('level'))->where('id',session('id'))->first();
        if(session('level') == 'proyek'){
            $barang = DB::table('barang')->select('barang.*','jenis.nama_jenis','jenis.id as jenis_id',"kategori.nama")->join('jenis','barang.id_jenis','=','jenis.id')->join('kategori','barang.id_kategori','=','kategori.id')->where('barang.id_kategori',$user->id_kategori)->paginate(10);
            $jenis = DB::table('jenis')->select('jenis.*','kategori.id as kategori_id')->join('kategori','jenis.id_kategori','=','kategori.id')->where('jenis.id_kategori',$user->id_kategori)->get();
        }else if(session('level') == 'mitra'){
            $proyek = DB::table('proyek')->where('id',$user->id_proyek)->first();
            $barang = DB::table('barang')->select('barang.*','jenis.nama_jenis','jenis.id as jenis_id',"kategori.nama")->join('jenis','barang.id_jenis','=','jenis.id')->join('kategori','barang.id_kategori','=','kategori.id')->where('barang.id_kategori',$proyek->id_kategori)->paginate(10);
            $jenis = DB::table('jenis')->select('jenis.*','kategori.id as kategori_id')->join('kategori','jenis.id_kategori','=','kategori.id')->where('jenis.id_kategori',$proyek->id_kategori)->get();
        }
        return view('barang/index',["user" => $user,"barang" => $barang,"jenis" => $jenis]);
    }
    public function tambah(){
        $validated = request()->validate([
            "nama" => [
                "required",
                Rule::unique('barang','nama_barang')
            ],
            "kategori" => "required"
        ]);
        $array = explode(',',$validated['kategori']);
        DB::table('barang')->insert([
            "nama_barang" => strtolower($validated['nama']),
            "id_jenis" => $array[0],
            "id_kategori" => $array[1],
        ]);
        return redirect()->back()->with("message","Barang berhasil ditambahkan");
    }

    public function edit(){
        $validated = request()->validate([
            "nama" => [
                "required",
                Rule::unique('barang','nama_barang')->ignore(request()->id,'id')
            ],
            "jenis" => "required"
        ]);
        $array = explode(',',$validated['jenis']);
        DB::table('barang')->where('id',request()->id)->update([
            "nama_barang" => strtolower($validated['nama']),
            "id_jenis" => $array[0],
            "id_kategori" => $array[1],
        ]);
        return redirect()->back()->with('message',"Barang berhasil diedit");
    }
    public function hapus(){
        DB::table('barang')->where('id',request()->id)->delete();
        return redirect()->back()->with('Barang berhasil dihapus');
    }

    public function getBarang(){
        $barang = DB::table('barang')->where('id_jenis',request()->id)->get();
        return json_encode([
            "data" => $barang
        ]);
    }
}
