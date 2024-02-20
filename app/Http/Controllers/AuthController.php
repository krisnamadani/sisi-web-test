<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    private $modules;

    public function login()
    {
        return view('pages.login');
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            return redirect()->route('dashboard');
        }

        return redirect()->route('login')->with('error', 'Email or password is incorrect');
    }

    public function register()
    {
        return view('pages.register');
    }

    public function postRegister(Request $request)
    {
        $request->validate([
            'nama_user' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required|min:4',
            'email' => 'required|email|unique:users',
            'no_hp' => 'required',
            'wa' => 'required',
            'pin' => 'required',
        ]);

        $user = new User;

        $id = Str::random(30);

        $user->id_user = $id;
        $user->nama_user = $request->nama_user;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->email = $request->email;
        $user->no_hp = $request->no_hp;
        $user->wa = $request->wa;
        $user->pin = $request->pin;

        $user->id_jenis_user = '2'; // 2 = user
        $user->status_user = 'active';
        $user->delete_mark = '0';
        $user->create_by = $id;
        $user->create_date = date('Y-m-d H:i:s');
        $user->update_by = $id;
        $user->update_date = date('Y-m-d H:i:s');

        $user->save();

        auth()->login($user);

        return redirect()->route('dashboard');
    }

    public function logout()
    {
        auth()->logout();

        return redirect()->route('login');
    }
}
