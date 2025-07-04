<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (auth()->check()) {
            return redirect('/inicio');
        }

        return view('index')->with([
            'email' => Cookie::get('email'),
            'remember' => Cookie::get('remember', false),
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $this->setRememberMeCookies($request, $remember);
            return redirect()->intended('/inicio');
        }

        return redirect()->back()->withErrors([
            'email' => 'El correo o la contraseña no son correctos.',
        ])->withInput($request->only('email', 'remember'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $this->clearRememberMeCookies();
        return redirect('/login');
    }

    public function mostrar()
    {
        $user = Auth::user();

        // Determinar el saludo basado en la hora local de Perú
        $hora = Carbon::now('America/Lima')->hour;

        if ($hora >= 6 && $hora < 12) {
            $saludo = "Buenos días";
        } elseif ($hora >= 12 && $hora < 18) {
            $saludo = "Buenas tardes";
        } else {
            $saludo = "Buenas noches";
        }

        return view('admin.inicio', compact('user', 'saludo')); // Pasar el saludo solo a la vista 'inicio'
    }

    private function setRememberMeCookies(Request $request, $remember)
    {
        if ($remember) {
            Cookie::queue('email', $request->email, 60 * 24 * 7);
            Cookie::queue('remember', true, 60 * 24 * 7);
        } else {
            $this->clearRememberMeCookies();
        }
    }

    private function clearRememberMeCookies()
    {
        Cookie::queue(Cookie::forget('email'));
        Cookie::queue(Cookie::forget('remember'));
    }
}