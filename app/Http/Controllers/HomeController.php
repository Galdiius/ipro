<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Proyek;
use App\Models\Mitra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\Pengepul;
use Illuminate\Support\Arr;

class HomeController extends Controller
{
    public function index(){
        if(session('level') == 'pengepul'){
            if(request()->tahun){
                $pendapatanbulan = [];
                for($i=1;$i<=12;$i++){
                    $pendapatan = DB::table('data_entry')->select(DB::raw('SUM(total_harga_diterima) as total'),DB::raw('MONTH(tanggal_konfirmasi) as bulan'))->where([
                        ['id_user','=',session('id')],
                        [DB::raw('MONTH(tanggal_konfirmasi)'),'=',$i],
                        [DB::raw('YEAR(tanggal_konfirmasi)'),'=', request()->tahun],
                    ]
                    )->first();
                    $pendapatanbulan[$i] = $pendapatan;
                }
            }else{
                $pendapatanbulan = [];
                for($i=1;$i<=12;$i++){
                    $pendapatan = DB::table('data_entry')->select(DB::raw('SUM(total_harga_diterima) as total'),DB::raw('MONTH(tanggal_konfirmasi) as bulan'))->where([
                        ['id_user','=',session('id')],
                        [DB::raw('MONTH(tanggal_konfirmasi)'),'=',$i],
                        [DB::raw('YEAR(tanggal_konfirmasi)'),'=',date('Y',time())],
                    ]
                    )->first();
                    $pendapatanbulan[$i] = $pendapatan;
                }
                
            }
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

            $filtered = Arr::where($datajenis,function($value,$key){
                return $value;
            });
            $data_mitra = $this->getBeratPengiriman();

            $data_jenis_mitra = $this->getJenisPengiriman();

            $totalKg = DB::table('data_entry')->select(DB::raw('SUM(total_berat) as total_kg'))->where('id_user',session('id'))->get();
            $pengiriman = DB::table('data_entry')->select(DB::raw('COUNT(id) as pengiriman'))->where([['id_user','=',session('id')],['status','=','sedang dikirim']])->orWhere([['id_user','=',session('id')],['status','=','terkirim']])->get();
            $totalPengiriman = DB::table('data_entry')->select(DB::raw('COUNT(id) as total_pengiriman'))->where('id_user',session('id'))->get();
            $material = DB::table('data_entry')->select(DB::raw('COUNT(entry_material.id) as material'))->join('entry_material','data_entry.id_entry_material','=','entry_material.id')->where('id_user',session('id'))->get();
            $barang = DB::table('data_entry')->select(DB::raw('COUNT(entry_barang.id) as barang'))->join('entry_material','data_entry.id_entry_material','=','entry_material.id')->join('entry_barang','entry_material.id_entry_barang','=','entry_barang.id')->where('data_entry.id_user',session('id'))->get();
            
            $data = [
                "total_kg" => $totalKg,
                "pengiriman" => $pengiriman,
                "material" => $material,
                "barang" => $barang,
                "total_pengiriman" => $totalPengiriman,
                "pendapatan" => $pendapatanbulan,
                "data_jenis" => $filtered,
                "data_berat_mitra" => $data_mitra,
                "data_jenis_mitra" => $data_jenis_mitra
            ];
            $user = DB::table(session('level'))->select('pengepul.*','nama_petugas as nama')->where('id',session('id'))->first();


        }else if(session('level') == 'mitra'){

            // mitra
            $user = DB::table(session('level'))->where('id',session('id'))->first();
            $totalKg = DB::table('data_entry')->select(DB::raw('SUM(total_berat) as total_kg'))->where('id_destination',session('id'))->get();
            $totalPengepul = DB::table('pengepul')->select(DB::raw('COUNT(id) as total_pengepul'))->where('id_mitra',session('id'))->get();
            $totalPengiriman = DB::table('data_entry')->select(DB::raw('COUNT(data_entry.id) as total_pengiriman'),'pengepul.nama_perusahaan','pengepul.nama_petugas')->join('pengepul','data_entry.id_user','=','pengepul.id')->where('id_destination',session('id'))->get();
            $datajenis = $this->dataJenis('id_destination');
            $dataPengepul = $this->dataPengepul();
            $totalKgperbulan = [];
            for($i=1;$i<=12;$i++){
                $pendapatan = DB::table('data_entry')->select(DB::raw('SUM(total_berat) as total'),DB::raw('MONTH(tanggal_konfirmasi) as bulan'))->where([
                    ['id_destination','=',session('id')],
                    [DB::raw('MONTH(tanggal_konfirmasi)'),'=',$i],
                    [DB::raw('YEAR(tanggal_konfirmasi)'),'=',date('Y',time())],
                ]
                )->first();
                $totalKgperbulan[$i] = $pendapatan;
            }

            if(request()->pengepul){
                if(request()->pengepul == 'all'){
                    if(request()->date != null){
                        $date = explode('-',request()->date);
                        $user = DB::table(session('level'))->where('id',session('id'))->first();
                        $totalKg = DB::table('data_entry')->select(DB::raw('SUM(total_berat) as total_kg'))->where([
                            ['id_destination','=',session('id')],
                            [DB::raw('DAY(tanggal_konfirmasi)'),'=',$date[2]],
                            [DB::raw('MONTH(tanggal_konfirmasi)'),'=',$date[1]],
                            [DB::raw('YEAR(tanggal_konfirmasi)'),'=',$date[0]],
                        ])->get();
                        $totalPengiriman = DB::table('data_entry')->select(DB::raw('COUNT(data_entry.id) as total_pengiriman'),'pengepul.nama_perusahaan','pengepul.nama_petugas')->join('pengepul','data_entry.id_user','=','pengepul.id')->where([
                            ['id_destination','=',session('id')],
                            [DB::raw('DAY(tanggal_konfirmasi)'),'=',$date[2]],
                            [DB::raw('MONTH(tanggal_konfirmasi)'),'=',$date[1]],
                            [DB::raw('YEAR(tanggal_konfirmasi)'),'=',$date[0]],
                        ])->get();
                        $datajenis = $this->dataJenis('id_destination',$date);
                        $dataPengepul = $this->dataPengepul();
                        $totalKgperbulan = DB::table('data_entry')->select(DB::raw('SUM(total_berat) as total'),DB::raw('MONTH(tanggal_konfirmasi) as bulan'))->where([
                            ['id_destination','=',session('id')],
                            [DB::raw('DAY(tanggal_konfirmasi)'),'=',$date[2]],
                            [DB::raw('MONTH(tanggal_konfirmasi)'),'=',$date[1]],
                            [DB::raw('YEAR(tanggal_konfirmasi)'),'=',$date[0]],
                        ]
                        )->first();

                    }else{
                        return redirect('');
                    }
                }else{
                    if(request()->date != null){
                        $date = explode('-',request()->date);
                        $user = DB::table(session('level'))->where('id',session('id'))->first();
                        $totalKg = DB::table('data_entry')->select(DB::raw('SUM(total_berat) as total_kg'))->where([
                            ['id_destination','=',session('id')],
                            ['id_user','=',request()->pengepul],
                            [DB::raw('DAY(tanggal_konfirmasi)'),'=',$date[2]],
                            [DB::raw('MONTH(tanggal_konfirmasi)'),'=',$date[1]],
                            [DB::raw('YEAR(tanggal_konfirmasi)'),'=',$date[0]],
                        ])->get();
                        $totalPengiriman = DB::table('data_entry')->select(DB::raw('COUNT(data_entry.id) as total_pengiriman'),'pengepul.nama_perusahaan','pengepul.nama_petugas')->join('pengepul','data_entry.id_user','=','pengepul.id')->where([
                            ['id_destination','=',session('id')],
                            ['id_user','=',request()->pengepul],
                            [DB::raw('DAY(tanggal_konfirmasi)'),'=',$date[2]],
                            [DB::raw('MONTH(tanggal_konfirmasi)'),'=',$date[1]],
                            [DB::raw('YEAR(tanggal_konfirmasi)'),'=',$date[0]],
                        ])->get();
                        $datajenis = $this->dataJenis('id_destination',$date,request()->pengepul);
                        $dataPengepul = $this->dataPengepul();
                        $totalKgperbulan = DB::table('data_entry')->select(DB::raw('SUM(total_berat) as total'),DB::raw('MONTH(tanggal_konfirmasi) as bulan'))->where([
                                ['id_destination','=',session('id')],
                                ['id_user','=',request()->pengepul],
                                [DB::raw('DAY(tanggal_konfirmasi)'),'=',$date[2]],
                                [DB::raw('MONTH(tanggal_konfirmasi)'),'=',$date[1]],
                                [DB::raw('YEAR(tanggal_konfirmasi)'),'=',$date[0]],
                            ]
                        )->first();
                        
                    }else{
                        $user = DB::table(session('level'))->where('id',session('id'))->first();
                        $totalKg = DB::table('data_entry')->select(DB::raw('SUM(total_berat) as total_kg'))->where([
                            ['id_destination','=',session('id')],
                            ['id_user','=',request()->pengepul]
                        ])->get();
                        $totalPengepul = DB::table('pengepul')->select(DB::raw('COUNT(id) as total_pengepul'))->where('id_mitra',session('id'))->get();
                        $totalPengiriman = DB::table('data_entry')->select(DB::raw('COUNT(data_entry.id) as total_pengiriman'),'pengepul.nama_perusahaan','pengepul.nama_petugas')->join('pengepul','data_entry.id_user','=','pengepul.id')->where([
                            ['id_destination','=',session('id')],
                            ['id_user','=',request()->pengepul]
                        ])->get();
                        $datajenis = $this->dataJenis('id_destination',null,request()->pengepul);
                        $dataPengepul = $this->dataPengepul();
                        $totalKgperbulan = [];
                        for($i=1;$i<=12;$i++){
                            $pendapatan = DB::table('data_entry')->select(DB::raw('SUM(total_berat) as total'),DB::raw('MONTH(tanggal_konfirmasi) as bulan'))->where([
                                ['id_destination','=',session('id')],
                                ['id_user','=',request()->pengepul],
                                [DB::raw('MONTH(tanggal_konfirmasi)'),'=',$i],
                                [DB::raw('YEAR(tanggal_konfirmasi)'),'=',date('Y',time())],
                            ]
                            )->first();
                            $totalKgperbulan[$i] = $pendapatan;
                        }
                    }
                }
            }

            $data = [
                "total_kg" => $totalKg,
                "total_pengepul" => $totalPengepul,
                "total_pengiriman" => $totalPengiriman,
                "data_jenis" => $datajenis,
                "data_pengepul" => $dataPengepul,
                "total_kg_bulan" => $totalKgperbulan
            ];


        }else if(session('level') == 'proyek'){
            if(request()->proyek){
                $dataJenis = $this->dataJenisProyek(request()->proyek);
                $dataJenisRp = $this->dataJenisRp(request()->proyek);
                $data_user = DB::table(session('level'))->select('proyek.*','kategori.nama as nama_kategori')->where('proyek.id',request()->proyek)->join('kategori','proyek.id_kategori','=','kategori.id')->first();
                $user = DB::table(session('level'))->where('id',session('id'))->first();
                $jumlahProyek = DB::table('proyek')->select(DB::raw("COUNT(id) as jumlah_proyek"))->first();
                $jumlahMitra = DB::table('mitra')->select(DB::raw('COUNT(id) as jumlah_mitra'))->where('id_proyek',request()->proyek)->first();
                $jumlahPengepul = DB::table('pengepul')->select(DB::raw('COUNT(pengepul.id) as jumlah_pengepul'))->join('mitra','pengepul.id_mitra','=','mitra.id')->where('mitra.id_proyek',request()->proyek)->first();
                $pengepulNonMitra = DB::table('pengepul')->select(DB::raw('COUNT(id) as jumlah_pengepul'))->where('id_proyek',request()->proyek)->first();
                $jumlahPengepul = $jumlahPengepul->jumlah_pengepul + $pengepulNonMitra->jumlah_pengepul;
                $totalKg = $this->totalKg(request()->proyek);
            }else{
                // proyek
                $dataJenis = $this->dataJenisProyek();
                $dataJenisRp = $this->dataJenisRp();
                $data_user = DB::table(session('level'))->select('proyek.*','kategori.nama as nama_kategori')->where('proyek.id',request()->proyek)->join('kategori','proyek.id_kategori','=','kategori.id')->first();
                $user = DB::table(session('level'))->where('id',session('id'))->first();
                $jumlahProyek = DB::table('proyek')->select(DB::raw("COUNT(id) as jumlah_proyek"))->first();
                $jumlahMitra = DB::table('mitra')->select(DB::raw('COUNT(id) as jumlah_mitra'))->where('id_proyek',session('id'))->first();
                $jumlahPengepul = DB::table('pengepul')->select(DB::raw('COUNT(pengepul.id) as jumlah_pengepul'))->join('mitra','pengepul.id_mitra','=','mitra.id')->where('mitra.id_proyek',session('id'))->first();
                $pengepulNonMitra = DB::table('pengepul')->select(DB::raw('COUNT(id) as jumlah_pengepul'))->where('id_proyek',session('id'))->first();
                $jumlahPengepul = $jumlahPengepul->jumlah_pengepul + $pengepulNonMitra->jumlah_pengepul;
                $totalKg = $this->totalKg(session('id'));    
            }
            $dataProyek = DB::table('proyek')->get();

            $data = [
                "jumlah_proyek" => $jumlahProyek,
                "jumlah_mitra" => $jumlahMitra,
                "jumlah_pengepul" => $jumlahPengepul,
                "total_kg" => $totalKg,
                "data_jenis" => $dataJenis,
                "data_user" => $data_user,
                "data_jenis_rp" => $dataJenisRp,
                "proyek" => $dataProyek
            ];
        }else{
            $user = DB::table('admin')->where('id',session('id'))->first();
            $data = [];
        }
        return view('home/dashboard',["user" => $user,"data" => $data]);
    }

    public function totalKg($id_proyek){
        $totalKg = 0;
        $user = DB::table('proyek')->where('id',$id_proyek)->first();
        $data_entry = DB::table('data_entry')->get();
        for ($i=0; $i < count($data_entry); $i++) { 
            $material = DB::table('entry_material')->select('entry_material.berat_kg','jenis.nama_jenis','jenis.id_kategori')->join('entry_barang','entry_material.id_entry_barang','=','entry_barang.id')->join('barang','entry_barang.id_barang','=','barang.id')->join('jenis','barang.id_jenis','=','jenis.id')->where('entry_material.id',$data_entry[$i]->id_entry_material)->first();
            if($material->id_kategori == $user->id_kategori){
                $totalKg += $material->berat_kg;
            }
        }
        return $totalKg;
    }

    public function dataPengepul(){
        $pengepulDataEntry = DB::table('data_entry')->select('pengepul.id','pengepul.nama_perusahaan','pengepul.nama_petugas')->join('pengepul','data_entry.id_user','=','pengepul.id')->where('id_destination',session('id'))->get();
        $pengepulMitra = DB::table('pengepul')->select('pengepul.id','nama_perusahaan','nama_petugas')->where('id_mitra',session('id'))->get();
        // $pengepulDataEntry = json_decode(json_encode($pengepulDataEntry),true);
        foreach($pengepulDataEntry as $v){
            $pengepulMitra->add($v);
        }
        $pengepulMitra = json_decode(json_encode($pengepulMitra),true);
        $pengepulMitra = array_map("unserialize", array_unique(array_map("serialize", $pengepulMitra)));
        return $pengepulMitra;
    }

    public function dataJenisRp($query=null){
        if($query == null){
            $jenis = DB::table('jenis')->get();
            $data_jenis = [];
            $user = DB::table('proyek')->where('id',session('id'))->first();
            foreach($jenis as $key => $v){
                $data_jenis[$v->nama_jenis] = 0;
            }
            $data_entry = DB::table('data_entry')->get();
            for ($i=0; $i < count($data_entry); $i++) { 
                $material = DB::table('entry_material')->select('entry_material.total_harga','jenis.nama_jenis','jenis.id_kategori')->join('entry_barang','entry_material.id_entry_barang','=','entry_barang.id')->join('barang','entry_barang.id_barang','=','barang.id')->join('jenis','barang.id_jenis','=','jenis.id')->where('entry_material.id',$data_entry[$i]->id_entry_material)->first();
                if($material->id_kategori == $user->id_kategori){
                    $data_jenis[$material->nama_jenis] += $data_entry[$i]->total_harga_diterima;
                }
            }
            $filtered = array_filter($data_jenis,function($value){
                return $value;
            });
            return $filtered;
        }else{
            $jenis = DB::table('jenis')->get();
            $data_jenis = [];
            $user = DB::table('proyek')->where('id',$query)->first();
            foreach($jenis as $key => $v){
                $data_jenis[$v->nama_jenis] = 0;
            }
            $data_entry = DB::table('data_entry')->get();
            for ($i=0; $i < count($data_entry); $i++) { 
                $material = DB::table('entry_material')->select('entry_material.total_harga','jenis.nama_jenis','jenis.id_kategori')->join('entry_barang','entry_material.id_entry_barang','=','entry_barang.id')->join('barang','entry_barang.id_barang','=','barang.id')->join('jenis','barang.id_jenis','=','jenis.id')->where('entry_material.id',$data_entry[$i]->id_entry_material)->first();
                if($material->id_kategori == $user->id_kategori){
                    $data_jenis[$material->nama_jenis] += $data_entry[$i]->total_harga_diterima;
                }
            }
            $filtered = array_filter($data_jenis,function($value){
                return $value;
            });
            return $filtered;
        }
    }

    public function dataJenisProyek($query=null){
        if($query == null){
            $jenis = DB::table('jenis')->get();
            $data_jenis = [];
            $user = DB::table('proyek')->where('id',session('id'))->first();
            foreach($jenis as $key => $v){
                $data_jenis[$v->nama_jenis] = 0;
            }
            $data_entry = DB::table('data_entry')->get();
            for ($i=0; $i < count($data_entry); $i++) { 
                $material = DB::table('entry_material')->select('entry_material.berat_kg','jenis.nama_jenis','jenis.id_kategori')->join('entry_barang','entry_material.id_entry_barang','=','entry_barang.id')->join('barang','entry_barang.id_barang','=','barang.id')->join('jenis','barang.id_jenis','=','jenis.id')->where('entry_material.id',$data_entry[$i]->id_entry_material)->first();
                if($material->id_kategori == $user->id_kategori){
                    $data_jenis[$material->nama_jenis] += $material->berat_kg;
                }
            }
            $filtered = array_filter($data_jenis,function($value){
                return $value;
            });
            return $filtered;
        }else{
            $jenis = DB::table('jenis')->get();
            $data_jenis = [];
            $user = DB::table('proyek')->where('id',$query)->first();
            foreach($jenis as $key => $v){
                $data_jenis[$v->nama_jenis] = 0;
            }
            $data_entry = DB::table('data_entry')->get();
            for ($i=0; $i < count($data_entry); $i++) { 
                $material = DB::table('entry_material')->select('entry_material.berat_kg','jenis.nama_jenis','jenis.id_kategori')->join('entry_barang','entry_material.id_entry_barang','=','entry_barang.id')->join('barang','entry_barang.id_barang','=','barang.id')->join('jenis','barang.id_jenis','=','jenis.id')->where('entry_material.id',$data_entry[$i]->id_entry_material)->first();
                if($material->id_kategori == $user->id_kategori){
                    $data_jenis[$material->nama_jenis] += $material->berat_kg;
                }
            }
            $filtered = array_filter($data_jenis,function($value){
                return $value;
            });
            return $filtered;
        }

    }

    public function dataJenis($column,$date=null,$pengepul='all'){
            $jenis = DB::table('jenis')->get();
            $data_jenis = [];
            foreach($jenis as $key => $v){
                $data_jenis[$v->nama_jenis] = [];
            }
            if($pengepul == 'all'){
                if($date != null){
                    $datee = $date;
                    $data_entry = DB::table('data_entry')->select('data_entry.id_entry_material','id')->where([
                        [$column,'=',session('id')],
                        [DB::raw('DAY(tanggal)'),'=',$datee[2]],
                        [DB::raw('MONTH(tanggal)'),'=',$datee[1]],
                        [DB::raw('YEAR(tanggal)'),'=',$datee[0]],
                    ])->get();
                }else{
                    $data_entry = DB::table('data_entry')->select('data_entry.id_entry_material','id')->where($column,session('id'))->get();
                }
            }else{
                if($date != null){
                    $datee = $date;
                    $data_entry = DB::table('data_entry')->select('data_entry.id_entry_material','id')->where([
                        [$column,'=',session('id')],
                        ['id_user','=',$pengepul],
                        [DB::raw('DAY(tanggal)'),'=',$datee[2]],
                        [DB::raw('MONTH(tanggal)'),'=',$datee[1]],
                        [DB::raw('YEAR(tanggal)'),'=',$datee[0]],
                    ])->get();
                }else{
                    $data_entry = DB::table('data_entry')->select('data_entry.id_entry_material','id')->where([
                        [$column,'=',session('id')],
                        ['id_user','=',$pengepul]
                    ])->get();
                }
            }
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
                $data_jenis[$k] = $jumlah;
            }
            $filtered = Arr::where($data_jenis,function($value,$key){
                return $value;
            });
            return $filtered;
    }

    public function getBeratPengiriman(){
        $mitra = DB::table('data_entry')->select('mitra.nama')->join('mitra','data_entry.id_destination','=','mitra.id')->where('id_user',session('id'))->get();
        $data_mitra = [];
        foreach($mitra as $k => $v){
            $data_mitra[$v->nama] = 0;
        }
        $listMitra = DB::table('data_entry')->select('data_entry.total_berat','mitra.nama')->join('mitra','data_entry.id_destination','=','mitra.id')->where('data_entry.id_user',session('id'))->get();
        foreach($listMitra as $key => $value){
            $data_mitra[$value->nama] += $value->total_berat;
        }
        return $data_mitra;
    }

    public function getJenisPengiriman(){
        $jenis = DB::table('jenis')->get();
        $data_jenis = [];
        foreach($jenis as $k => $va){
            $data_jenis[$va->nama_jenis] = 0;
        }

        $mitra = DB::table('data_entry')->select('mitra.nama')->join('mitra','data_entry.id_destination','=','mitra.id')->where('id_user',session('id'))->get();
        $data_mitra = [];
        foreach($mitra as $k => $v){
            $data_mitra[$v->nama] = $data_jenis;
        }

        
        $dataE = DB::table('data_entry')->select('data_entry.*','mitra.nama')->join('mitra','data_entry.id_destination','=','mitra.id')->where('id_user',session('id'))->get();
        foreach($dataE as $key => $value){
            $dataM = DB::table('entry_material')->where('id',$value->id_entry_material)->get();
            $jumlah = 0;
            foreach($dataM as $key => $val){
                $dataB = DB::table('entry_barang')->select('jenis.nama_jenis')->join('barang','entry_barang.id_barang','=','barang.id')->join('jenis','barang.id_jenis','=','jenis.id')->where('entry_barang.id',$val->id_entry_barang)->first();
                $jumlah += $val->berat_kg;
                $data_mitra[$value->nama][$dataB->nama_jenis] = $jumlah;
            }
        }

        // foreach($data_mitra as $key => $value){
        //     foreach($value as $k => $v){
        //         if($v == 0){
        //             unset($data_mitra[$key][$k]);
        //         }
        //     }
        // }


        return $data_mitra;
    }


    public function profile(){
        if(session('level') != 'pengepul'){
            if(session('level') == 'proyek'){
                $user = DB::table('proyek')->select('proyek.*','kategori.nama as nama_kategori')->join('kategori','proyek.id_kategori','=','kategori.id')->where('proyek.id',session('id'))->first();
            }else{
                $user = DB::table(session('level'))->where('id',session('id'))->first();
            }
        }else{
            $user = DB::table(session('level'))->select('*','nama_petugas as nama')->where('id',session('id'))->first();
        }
        return view('home/profile',['user' => $user]);
    }
    public function editProfile($id){
        switch (session('level')) {
            case 'proyek':
                $user = Proyek::select('*','id as id_user')->where('id',$id)->firstOrFail();
                break;
            case 'mitra':
                $user = Mitra::select('*','id as id_user')->where('id',$id)->firstOrFail();    
                break;
            case 'pengepul':
                $user = Pengepul::select('*','id as id_user')->where('id',$id)->firstOrFail();    
                break;
            case 'admin':
                $user = Admin::select('*','id as id_user')->where('id',$id)->firstOrFail();    
                break;
        }
        if(session('id') != $user->id_user){
            abort(404);
        }else{
            return view('home/editProfile',["user" => $user]);
        }

    }
    public function _editProfile(){
        if(request()->newPassword != null){
            $validated = request()->validate([
                "nama" => [
                    'required',
                    Rule::unique(session('level'),'nama')->ignore(request()->id,'id')
                ],
                "email" => [
                    "required",
                    "email",
                    Rule::unique(session('level'),'email')->ignore(request()->id,'id')
                ],
                "alamat" => "required",
                "no_telepon" => [
                    "required",
                    "min:10",
                    Rule::unique(session('level'),'no_hp')->ignore(request()->id,'id')
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
                DB::table(session('level'))->where('id',request()->id)->update([
                    "nama" => $validated["nama"],
                    "email" => $validated["email"],
                    "alamat" => $validated["alamat"],
                    "no_hp" => $validated["no_telepon"],
                    "koordinat" => $validated["koordinat"],
                    "password" => password_hash($validated["newPassword"],PASSWORD_DEFAULT) 
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
                    Rule::unique(session('level'),'nama')->ignore(request()->id,'id')
                ],
                "email" => [
                    "required",
                    "email",
                    Rule::unique(session('level'),'email')->ignore(request()->id,'id')
                ],
                "alamat" => "required",
                "no_telepon" => [
                    "required",
                    "min:10",
                    Rule::unique(session('level'),'no_hp')->ignore(request()->id,'id')
                ],
                "koordinat" => "required",
            ]);
            DB::table(session('level'))->where('id',request()->id)->update([
                "nama" => $validated["nama"],
                "email" => $validated["email"],
                "alamat" => $validated["alamat"],
                "no_hp" => $validated["no_telepon"],
                "koordinat" => $validated["koordinat"],
            ]);
            return redirect()->back()->with("message",[
                "type" => "success",
                "message" => "Data berhasil di ubah"
            ]);
        }
    }

    public function editProfilePengepul(){
        if(request()->newPassword != null){
            $validated = request()->validate([
                "nama" => [
                    'required',
                    Rule::unique(session('level'),'nama_petugas')->ignore(request()->id,'id')
                ],
                "email" => [
                    "required",
                    "email",
                    Rule::unique(session('level'),'email')->ignore(request()->id,'id')
                ],
                "alamat" => "required",
                "no_telepon" => [
                    "required",
                    "min:12",
                    Rule::unique(session('level'),'no_hp')->ignore(request()->id,'id')
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
                DB::table(session('level'))->where('id',request()->id)->update([
                    "nama_petugas" => $validated["nama"],
                    "email" => $validated["email"],
                    "alamat" => $validated["alamat"],
                    "no_hp" => $validated["no_telepon"],
                    "koordinat" => $validated["koordinat"],
                    "password" => password_hash($validated["newPassword"],PASSWORD_DEFAULT) 
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
                    Rule::unique(session('level'),'nama_petugas')->ignore(request()->id,'id')
                ],
                "email" => [
                    "required",
                    "email",
                    Rule::unique(session('level'),'email')->ignore(request()->id,'id')
                ],
                "alamat" => "required",
                "no_telepon" => [
                    "required",
                    "min:12",
                    Rule::unique(session('level'),'no_hp')->ignore(request()->id,'id')
                ],
                "koordinat" => "required",
            ]);
            DB::table(session('level'))->where('id',request()->id)->update([
                "nama_petugas" => $validated["nama"],
                "email" => $validated["email"],
                "alamat" => $validated["alamat"],
                "no_hp" => $validated["no_telepon"],
                "koordinat" => $validated["koordinat"],
            ]);
            return redirect()->back()->with("message",[
                "type" => "success",
                "message" => "Data berhasil di ubah"
            ]);
        }
    }
}
