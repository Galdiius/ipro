<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function admin(){
        return view('auth/admin'); 
    }
    // public function petugas(){
    //     return view('auth/petugas');
    // }
    public function _admin(){
        $validate = request()->validate([
            "email" => 'required|email',
            "password" => 'required'
        ]);
        $admin = DB::table('admin')->where('email',$validate['email'])->first();
        if($admin){
            if(password_verify($validate['password'],$admin->password)){
                Session::put([
                    "login" => true,
                    "id" => $admin->id,
                    "level" => "admin"
                ]);
                Session::save();
                return redirect('/');
            }else{
                return redirect()->back()->with('status','Email atau password salah!');
            }
        }else{
            $proyek = DB::table('proyek')->where('email',$validate['email'])->first();
                if($proyek){
                if(password_verify($validate['password'],$proyek->password)){
                    Session::put([
                        "login" => true,
                        "id" => $proyek->id,
                        "level" => "proyek"
                    ]);
                    Session::save();
                    return redirect('/');
                }else{
                    return redirect()->back()->with('status','Email atau password salah!');
                }
                }else{
                    $mitra = DB::table('mitra')->where('email',$validate['email'])->first();
                    if($mitra){
                        if(password_verify($validate['password'],$mitra->password)){
                            Session::put([
                                "login" => true,
                                "id" => $mitra->id,
                                "level" => "mitra"
                            ]);
                            Session::save();
                            return redirect('/');
                        }else{
                            return redirect()->back()->with('status','Email atau password salah!');
                        }
                    }else{
                        $pengepul = DB::table('pengepul')->where('email',$validate['email'])->first();
                        if($pengepul){
                            if(password_verify($validate['password'],$pengepul->password)){
                                Session::put([
                                    "login" => true,
                                    "id" => $pengepul->id,
                                    "level" => "pengepul"
                                ]);
                                Session::save();
                                return redirect('/');
                            }else{
                                return redirect()->back()->with('status','Email atau password salah!');
                            }
                        }else{
                            return redirect()->back()->with('status','Email atau password salah!');
                        }
                    }
                }
        }
        
    }
    
    // public function _petugas(){
    //     $validate = request()->validate([
    //         "email" => 'required|email',
    //         "password" => 'required'
    //     ]);
    //     $pengepul = DB::table('pengepul')->where('email',$validate['email'])->first();
    //     if($pengepul){
    //         if(password_verify($validate['password'],$pengepul->password)){
    //             Session::put([
    //                 "login" => true,
    //                 "id" => $pengepul->id,
    //                 "level" => "pengepul"
    //             ]);
    //             Session::save();
    //             return redirect('/');
    //         }else{
    //             return redirect()->back()->with('status','Email atau password salah!');
    //         }
    //     }else{
    //         return redirect()->back()->with('status','Email atau password salah!');
    //     }
    // }
    public function logout(){
        Session::remove('login');
        Session::remove('id');
        Session::remove('level');
        return redirect('login');
    }
}
