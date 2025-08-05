<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        return view('login.index');
    }

    public function store(Request $request)
    {
        /* dd(Auth::attempt($request->except('_token'))); */
        if(!Auth::attempt($request->only(['email', 'password']))) {
            return redirect()->back()->withErrors(['Usuário ou senha inválidos']);
        }

        return to_route('series.index')
            ->with('success', 'Login realizado com sucesso.');
    }

    public function destroy()
    {
        Auth::logout();
        return to_route('login')
            ->with('success', 'Logout realizado com sucesso.');
    }
}