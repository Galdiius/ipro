<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
class UsersController extends Controller
{
    public function paginate($items, $perPage = 3, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
    public function index(){
        if(request()->q){
            $user = DB::table('admin')->where('id',session('id'))->first();
            $proyek = DB::table('proyek')->select('id','nama',DB::raw("'proyek' AS data"),DB::raw("'primary' AS color"))->where('nama','LIKE','%'.request()->q.'%')->get();
            $mitra = DB::table('mitra')->select('id','nama',DB::raw("'mitra' AS data"),DB::raw("'success' AS color"))->where([
                ['status','=','1'],
                ['nama','LIKE','%'.request()->q.'%']
            ])->get();
            $pengepul = DB::table('pengepul')->select('id',DB::raw("nama_petugas as nama"),DB::raw("'pengepul' AS data"),DB::raw("'warning' AS color"))->where([
                ['status','=','1'],
                ['nama_petugas','LIKE','%'.request()->q.'%']
            ])->get();
            foreach($mitra as $m){
                $proyek->add($m);
            }
            foreach($pengepul as $p){
                $proyek->add($p);
            }
            $data = $this->paginate($proyek,5,null,[
                "path" => "users"
            ]);
        }else{
            $user = DB::table('admin')->where('id',session('id'))->first();
            $proyek = DB::table('proyek')->select('id','nama',DB::raw("'proyek' AS data"),DB::raw("'primary' AS color"))->get();
            $mitra = DB::table('mitra')->select('id','nama',DB::raw("'mitra' AS data"),DB::raw("'success' AS color"))->where('status','=','1')->get();
            $pengepul = DB::table('pengepul')->select('id',DB::raw("nama_petugas as nama"),DB::raw("'pengepul' AS data"),DB::raw("'warning' AS color"))->where('status','=','1')->get();
            foreach($mitra as $m){
                $proyek->add($m);
            }
            foreach($pengepul as $p){
                $proyek->add($p);
            }
            $data = $this->paginate($proyek,5,null,[
                "path" => "users"
            ]);
        }
        return view('users/index',['user' => $user,"data" => $data]);
    }
}
