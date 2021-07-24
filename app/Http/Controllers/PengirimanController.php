<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class PengirimanController extends Controller
{
    public function index(){
        if(session('level') == 'pengepul'){
            $user = DB::table(session('level'))->select('*','nama_petugas as nama')->where('id',session('id'))->first();
            $data_entry = DB::table('data_entry')->select('data_entry.*','mitra.id as id_mitra','mitra.nama as nama_mitra','mitra.koordinat')->join('mitra','data_entry.id_destination','=','mitra.id')
                ->where(
                [
                    ['data_entry.id_user','=',session('id')],
                    ['data_entry.status','=','sedang dikirim'],
                ]
                )
                ->orWhere([
                    ['data_entry.id_user','=',session('id')],
                    ['data_entry.status','=','terkirim'],
                ])
                ->get()->all();
                $data = json_decode(json_encode($data_entry),true);
                foreach($data_entry as $key => $v){
                    $d = DB::table('entry_material')->where('id',$v->id_entry_material)->get()->all();
                    $material = json_decode(json_encode($d),true);
                    foreach($d as $k => $value){
                        $b = DB::table('entry_barang')->select('barang.nama_barang')->join('barang','entry_barang.id_barang','=','barang.id')->where('entry_barang.id',$value->id_entry_barang)->get()->all();
                        $material[$k]["barang"] = $b;
                    }
                    $data[$key]["material"] = $material;
                }
        }else if(session('level') == 'mitra'){
            $user = DB::table(session('level'))->where('id',session('id'))->first();
            $data_entry = DB::table('data_entry')
                ->select('data_entry.*','mitra.id as id_mitra','mitra.nama as nama_mitra','mitra.koordinat','pengepul.nama_petugas','pengepul.nama_perusahaan')
                ->join('mitra','data_entry.id_destination','=','mitra.id')
                ->join('pengepul','data_entry.id_user','=','pengepul.id')
                ->where(
                [
                    ['data_entry.id_destination','=',session('id')],
                    ['data_entry.status','=','sedang dikirim'],
                ]
                )
                ->orWhere([
                    ['data_entry.id_destination','=',session('id')],
                    ['data_entry.status','=','terkirim'],
                ])
                ->get()->all();
                $data = json_decode(json_encode($data_entry),true);
                foreach($data_entry as $key => $v){
                    $d = DB::table('entry_material')->where('id',$v->id_entry_material)->get()->all();
                    $material = json_decode(json_encode($d),true);
                    // dd($material);
                    foreach($d as $k => $value){
                        $b = DB::table('entry_barang')->select('barang.nama_barang')->join('barang','entry_barang.id_barang','=','barang.id')->where('entry_barang.id',$value->id_entry_barang)->get()->all();
                        $material[$k]["barang"] = $b;
                    }
                    $data[$key]["material"] = $material;
                }
        }else if(session('level') == 'proyek'){
            $user = DB::table(session('level'))->where('id',session('id'))->first();
            $data_entry = DB::table('data_entry')
                ->select('data_entry.*','mitra.id as id_mitra','mitra.nama as nama_mitra','mitra.koordinat','pengepul.nama_petugas','pengepul.nama_perusahaan')
                ->join('mitra','data_entry.id_destination','=','mitra.id')
                ->join('pengepul','data_entry.id_user','=','pengepul.id')
                ->where(
                [
                    ['mitra.id_proyek','=',session('id')],
                    ['data_entry.status','=','sedang dikirim'],
                ]
                )
                ->orWhere([
                    ['mitra.id_proyek','=',session('id')],
                    ['data_entry.status','=','terkirim'],
                ])
                ->get()->all();
                $data = json_decode(json_encode($data_entry),true);
                foreach($data_entry as $key => $v){
                    $d = DB::table('entry_material')->where('id',$v->id_entry_material)->get()->all();
                    $material = json_decode(json_encode($d),true);
                    // dd($material);
                    foreach($d as $k => $value){
                        $b = DB::table('entry_barang')->select('barang.nama_barang')->join('barang','entry_barang.id_barang','=','barang.id')->where('entry_barang.id',$value->id_entry_barang)->get()->all();
                        $material[$k]["barang"] = $b;
                    }
                    $data[$key]["material"] = $material;
                }
        }
        return view('pengiriman/index',[
            "user" => $user,
            "data" => $data
        ]);
    }

    public function konfirmasi(){
        DB::table('data_entry')->where('id',request()->id)->update([
            'tanggal_konfirmasi' => DB::raw('now()'),
            "status" => request()->konfirmasi
        ]);
        return redirect()->back();
    }

    public function print($id){
            $data_entry = DB::table('data_entry')
            ->select('data_entry.*','data_entry.id as id_data','data_entry.status as status_data','mitra.id as id_mitra','mitra.nama as nama_mitra','mitra.koordinat','pengepul.*')
            ->join('mitra','data_entry.id_destination','=','mitra.id')
            ->join('pengepul','data_entry.id_user','=','pengepul.id')
            ->where(
            [
                ['data_entry.id','=',$id],
            ]
            )->get()->all();
            $data = json_decode(json_encode($data_entry),true);
            foreach($data_entry as $key => $v){
                $d = DB::table('entry_material')->where('id',$v->id_entry_material)->get()->all();
                $material = json_decode(json_encode($d),true);
                // dd($material);
                foreach($d as $k => $value){
                    $b = DB::table('entry_barang')->select('barang.nama_barang')->join('barang','entry_barang.id_barang','=','barang.id')->where('entry_barang.id',$value->id_entry_barang)->get()->all();
                    $material[$k]["barang"] = $b;
                }
                $data[$key]["material"] = $material;
            }
            // dd($data[0]);
            $pdf = PDF::loadview('print/pengiriman',["data" => $data[0]]);
            return $pdf->download('laporan.pdf');
            return view('print/pengiriman',["data" => $data[0]]);
    }

    public function riwayat(){
        if(session('level') == 'pengepul'){
            $user = DB::table(session('level'))->select('*','nama_petugas as nama')->where('id',session('id'))->first();
            $data_entry = DB::table('data_entry')
            ->select('data_entry.*','mitra.id as id_mitra','mitra.nama as nama_mitra','mitra.koordinat')
            ->join('mitra','data_entry.id_destination','=','mitra.id')
                ->where(
                [
                    ['data_entry.id_user','=',session('id')],
                    ['data_entry.status','=','diterima'],
                ]
                )
                ->orWhere([
                    ['data_entry.id_user','=',session('id')],
                    ['data_entry.status','=','ditolak'],
                ])
                ->get()->all();
                $data = json_decode(json_encode($data_entry),true);
                foreach($data_entry as $key => $v){
                    $d = DB::table('entry_material')->where('id',$v->id_entry_material)->get()->all();
                    $material = json_decode(json_encode($d),true);
                    foreach($d as $k => $value){
                        $b = DB::table('entry_barang')->select('barang.nama_barang')->join('barang','entry_barang.id_barang','=','barang.id')->where('entry_barang.id',$value->id_entry_barang)->get()->all();
                        $material[$k]["barang"] = $b;
                    }
                    $data[$key]["material"] = $material;
                }
        }else if(session('level') == 'mitra'){
            $user = DB::table(session('level'))->where('id',session('id'))->first();
            $data_entry = DB::table('data_entry')
                ->select('data_entry.*','mitra.id as id_mitra','mitra.nama as nama_mitra','mitra.koordinat','pengepul.nama_petugas','pengepul.nama_perusahaan')
                ->join('mitra','data_entry.id_destination','=','mitra.id')
                ->join('pengepul','data_entry.id_user','=','pengepul.id')
                ->where(
                [
                    ['data_entry.id_destination','=',session('id')],
                    ['data_entry.status','=','diterima'],
                ]
                )
                ->orWhere([
                    ['data_entry.id_destination','=',session('id')],
                    ['data_entry.status','=','ditolak'],
                ])
                ->get()->all();
                $data = json_decode(json_encode($data_entry),true);
                foreach($data_entry as $key => $v){
                    $d = DB::table('entry_material')->where('id',$v->id_entry_material)->get()->all();
                    $material = json_decode(json_encode($d),true);
                    // dd($material);
                    foreach($d as $k => $value){
                        $b = DB::table('entry_barang')->select('barang.nama_barang')->join('barang','entry_barang.id_barang','=','barang.id')->where('entry_barang.id',$value->id_entry_barang)->get()->all();
                        $material[$k]["barang"] = $b;
                    }
                    $data[$key]["material"] = $material;
                }
        }else if(session('level') == 'proyek'){
            $user = DB::table(session('level'))->where('id',session('id'))->first();
            $data_entry = DB::table('data_entry')
                ->select('data_entry.*','mitra.id as id_mitra','mitra.nama as nama_mitra','mitra.koordinat','pengepul.nama_petugas','pengepul.nama_perusahaan')
                ->join('mitra','data_entry.id_destination','=','mitra.id')
                ->join('pengepul','data_entry.id_user','=','pengepul.id')
                ->where(
                [
                    ['mitra.id_proyek','=',session('id')],
                    ['data_entry.status','=','diterima'],
                ]
                )
                ->orWhere([
                    ['mitra.id_proyek','=',session('id')],
                    ['data_entry.status','=','ditolak'],
                ])
                ->get()->all();
                $data = json_decode(json_encode($data_entry),true);
                foreach($data_entry as $key => $v){
                    $d = DB::table('entry_material')->where('id',$v->id_entry_material)->get()->all();
                    $material = json_decode(json_encode($d),true);
                    // dd($material);
                    foreach($d as $k => $value){
                        $b = DB::table('entry_barang')->select('barang.nama_barang')->join('barang','entry_barang.id_barang','=','barang.id')->where('entry_barang.id',$value->id_entry_barang)->get()->all();
                        $material[$k]["barang"] = $b;
                    }
                    $data[$key]["material"] = $material;
                }
        }
        return view('pengiriman/riwayat',[
            "user" => $user,
            "data" => $data
        ]);
    }
}
