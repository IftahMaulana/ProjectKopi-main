<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class AdminLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function showLoginForm()
    {
        auth()->logout();
        return view('admin.page.login', [
            'name' => "Login",
            'title' => 'Admin Login',
        ]);
    }

    public function loginAdmin(Request $request)
    {
        Session::flash('error', $request->email);
    
        $dataLogin = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        // dd($dataLogin);
    
        $user = new User;
        $proses = $user::where('email', $request->email)->first();
    
        if ($proses === null) {
            Session::flash('error', 'Pengguna tidak ditemukan');
            return back();
        }
        // dd($proses->is_admin);
    
        if ($proses->is_admin === 0) {
            Session::flash('error', 'Kamu bukan admin');
            return back();
        } else {
            if (Auth::guard('admin')->attempt($dataLogin)) {
                Alert::toast('Kamu berhasil login', 'success');
                $request->session()->regenerate();
                return redirect()->intended('/admin/dashboard');
            } else {
                Alert::toast('Email dan Password salah', 'error');
                return back();
            }
        }
        // $credentials = request()->only('email', 'password');

        // if (auth()->guard('admin')->attempt($credentials)) {
        //     return redirect()->route('/admin/dashboard');
        // }

        // return back()->with('error', 'Login failed!');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        Alert::toast('Kamu berhasil Logout', 'success');
        return redirect('/admin');
    }
}
