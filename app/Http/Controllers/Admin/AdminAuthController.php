<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.admin-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.home');
            } else {
                Auth::logout();
                return back()->withErrors(['error' => 'Bạn không có quyền truy cập admin']);
            }
        }

        return back()->withErrors(['error' => 'Username hoặc mật khẩu không đúng']);
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
