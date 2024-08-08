<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class UserLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:user')->except('logout');
    }

    public function showLoginForm()
    {
        return view('pelanggan.page.login');
    }

    public function loginUser(Request $request)
    {
        $dataLogin = [
            'email' => $request->email,
            'password'  => $request->password,
        ];

        $user = new User;
        $proses = $user::where('email', $request->email)->first();

        
        if (Auth::guard('user')->attempt($dataLogin)) {
            Alert::toast('Kamu berhasil login', 'success');
            $request->session()->regenerate();
            return redirect()->intended('/');
        } else {
            Alert::toast('Email dan Password salah', 'error');
            return back();
        }
    }

    public function logout()
    {
        Auth::guard('user')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        Alert::toast('Kamu berhasil Logout', 'success');
        return redirect('/');
    }
}
