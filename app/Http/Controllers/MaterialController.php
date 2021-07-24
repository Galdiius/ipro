<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class MaterialController extends Controller
{
    public function index(){
        $user = DB::table(session('level'))->where('id',session('id'))->first();
        if(session('level') == "pengepul"){
            $user = DB::table(session('level'))->select('pengepul.*','pengepul.nama_petugas as nama')->where('id',session('id'))->first();
        }
        $id_proyek = DB::table('pengepul')->select('mitra.id_proyek')->join('mitra','pengepul.id_mitra','=','mitra.id')->where('pengepul.id',session('id'))->first();
        $mitra = DB::table('mitra')->where([
            ['id_proyek','=',$id_proyek->id_proyek],
            ['status','=','1']
        ])->get();
        $kategori = DB::table('kategori')->get();

        return view('material/index',["user" => $user,"kategori"=>$kategori,"mitra"=>$mitra]);
    }
    public function submit(){
        $id_material = IdGenerator::generate(['table' => 'entry_material','length' => 8, 'prefix' => 'MT-']);
        $no_invoice = IdGenerator::generate(['table' => 'data_entry','length' => 9, 'prefix' => 'IVC-']);
        DB::transaction(function() use ($id_material,$no_invoice) {
            // dd(request()->all());
            foreach(request()->nama_barang as $key => $value){
                $id_barang = IdGenerator::generate(['table' => 'entry_barang','length' => 8, 'prefix' => 'BG-']);
                // dd(request()->berat['material-1'][0]);
                DB::table('entry_material')->insert([
                    "id" => $id_material,
                    "id_entry_barang" => $id_barang,
                    "nama_material" => $key,
                    "berat_kg" => request()->berat[$key][0],
                    "total_harga" => request()->harga[$key][0],
                    "harga/kg" => request()->hargaperkg[$key][0]
                ]);
                foreach($value as $i => $v){
                    DB::table('entry_barang')->insert([
                        "id" => $id_barang,
                        "id_barang" => $v
                    ]);
                }
            }
            DB::table('data_entry')->insert([
                "id" => $no_invoice,
                "id_user" => request()->id_pengepul,
                "tanggal" => DB::raw('now()'),
                "id_entry_material" => $id_material,
                "total_berat" => request()->totalBerat,
                "total_barang" => request()->totalBarang,
                "total_harga" => request()->totalHarga,
                "comment" => request()->comment,
                "id_destination" => request()->mitra,
                "destination" => request()->destinasi,
                "status" => "sedang dikirim"
            ]);

        });
        return redirect('/pengiriman');
    }
    public function terkirim(){
        $totalharga = explode('Rp.',request()->total_harga_diterima)[1];
        DB::table('data_entry')->where('id',request()->id)->update([
            "tanggal_terkirim" => DB::raw('now()'),
            "total_berat_terkirim" => request()->total_berat_terkirim,
            "total_harga_diterima" => $totalharga,
            "status" => "terkirim"
        ]);
        return redirect()->back()->with('message','Material sudah dikirim');
    }
}
