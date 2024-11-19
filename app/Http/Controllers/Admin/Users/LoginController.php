<?php

namespace App\Http\Controllers\Admin\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index()
    {
        return view('admin.users.login', [
            'title' => 'Đăng Nhập Hệ Thống'
        ]);
    }

    // request là nhận data gửi lên từ form
    public function store(Request $request)
    {
        $this -> validate($request, [
                'email' => 'required|email:filter',
                'password' => 'required'
        ]);

        if(Auth::attempt([
            // Kiểm tra thông tin người dùng có khớp với data không
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ], $request -> input('remember'))
        ){
            return redirect()->route('admin');
        }else{
            //dd('Authentication failed'); 
            Session::flash('error','Email or Password incorrect');
            return redirect() -> back();
        }


    }
}

