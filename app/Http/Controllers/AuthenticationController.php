<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterValidate;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Rules\Captcha;
use App\Http\Requests\LoginValidator;

class AuthenticationController extends Controller
{
    public function index()
    {
        // dd(auth()->check());
        return view('authentication/LoginOrRegisrter');
    }
    public function login(LoginValidator $request)
    {
        $dataLogin = [
            'email' => $request->emailLogin,
            'password' => $request->passwordLogin,
        ];
        if (Auth::attempt($dataLogin)) {
            session()->put('login', Auth::attempt($dataLogin));
            if (session()->has('loginFail')) {
                session()->forget('loginFail');
            }
            return redirect()->route('home.index');
        } else {
            session()->put('loginFail', 'Tài khoản hoặc mật khẩu không đúng.');
            return redirect()->route('login.index');
        }
    }
    public function register(RegisterValidate $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $dataLogin = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        if ($user) {
            Auth::attempt($dataLogin);
            return redirect()->route('home.index');
        }
    }
    public function logout()
    {
        Auth::logout();
        session()->forget('login');
        session()->forget('cart');
        return redirect()->route('home.index');
    }
}
