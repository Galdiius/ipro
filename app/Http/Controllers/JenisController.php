<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\Jenis;
class JenisController extends Controller
{
    public function index(){
        $user = DB::table(session('level'))->where('id',session('id'))->first();
        if(session('level') == 'proyek'){
            $kategori = DB::table('kategori')->where('id',$user->id_kategori)->first();
            $jenis = DB::table('jenis')->select('jenis.*','kategori.nama','kategori.id as kategori_id')->join('kategori','jenis.id_kategori','=','kategori.id')->where('id_kategori',$user->id_kategori)->paginate(10);
        }else if(session('level') == 'mitra'){
            $proyek = DB::table('proyek')->where('id',$user->id_proyek)->first();
            $kategori = DB::table('kategori')->where('id',$proyek->id_kategori)->first();
            $jenis = DB::table('jenis')->select('jenis.*','kategori.nama','kategori.id as kategori_id')->join('kategori','jenis.id_kategori','=','kategori.id')->where('id_kategori',$kategori->id)->paginate(10);
        }

        return view('jenis/index',["user" => $user,"jenis" => $jenis,"kategori" => $kategori]);
    }
    public function tambah(){
        if(session('level') == 'proyek'){
            $id_kategori = DB::table('proyek')->where('id',session('id'))->first()->id_kategori;
        }else if(session('level') == 'mitra'){
            $user = DB::table('mitra')->where('id',session('id'))->first();
            $id_kategori = DB::table('proyek')->where('id',$user->id_proyek)->first()->id_kategori;
        }
        $validated = request()->validate([
            "nama" => [
                "required",
                Rule::unique('jenis',"nama_jenis")->where('id_kategori',$id_kategori)
            ],
        ],[
            "nama.unique" => "kategori sudah ada",
        ]);
        // $id_kategori = DB::table('proyek')->where('id',session('id'))->first();
        $kategori = DB::table('kategori')->where('id',$id_kategori)->first();
        $data = new Jenis;
        $data->nama_jenis = strtolower($validated["nama"]);
        $data->id_kategori = $kategori->id;
        $data->save();
        DB::table('peningkatan')->insert([
            "id_jenis" => $data->id,
            "target" => 0,
            "aktual" => 0,
            "growth" => "0" 
        ]);
        return redirect()->back()->with("message","Jenis berhasil ditambahkan");
    }
    public function hapus(){
        DB::table('jenis')->where('id',request()->id)->delete();
        return redirect()->back()->with('message',"Jenis berhasil dihapus");
    }
    public function edit(){
        $validated = request()->validate([
            "nama" => [
                "required",
                Rule::unique("jenis","nama_jenis")->where('id_kategori',request()->id_kategori)->ignore(request()->id,"id")
            ],
        ],[
            "nama.unique" => "Jenis sudah ada"
        ]);
        DB::table('jenis')->where('id','=',request()->id)->update([
            "nama_jenis" => strtolower($validated['nama']),
        ]);
        return redirect()->back()->with("message","Jenis berhasil diedit");
    }

    public function getJenis(){
        $jenis = DB::table('jenis')->where('id_kategori',request()->id)->get();
        return json_encode([
            "data" => $jenis
        ]);
    }

    public function getDataJenis(){
        $jenis = DB::table('jenis')->get();
        $data_jenis = [];
        foreach($jenis as $key => $v){
            $data_jenis[$v->nama_jenis] = [];
        }
        $data_entry = DB::table('data_entry')->select('data_entry.id_entry_material','id')->where('id_user',session('id'))->get();
        for ($i=0; $i < count($data_entry); $i++) { 
            $material = DB::table('entry_material')->select('id_entry_barang','berat_kg')->where('id',$data_entry[$i]->id_entry_material)->get();
            for ($a=0; $a < count($material); $a++) { 
                $jenis = DB::table('entry_barang')->select('nama_jenis')->join('barang','entry_barang.id_barang','=','barang.id')->join('jenis','barang.id_jenis','=','jenis.id')->where('entry_barang.id',$material[$a]->id_entry_barang)->first();
                $data_jenis[$jenis->nama_jenis][] = $material[$a]->berat_kg;
            }
        }
        foreach ($data_jenis as $k => $v) {
            $jumlah = 0;
            for ($i=0; $i < count($v); $i++) {
                $jumlah += $v[$i];
            }
            $datajenis[$k] = $jumlah;
        }
        return json_encode([
            $datajenis
        ]);
    }
}
