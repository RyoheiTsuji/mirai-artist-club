<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArtistAuthController extends Controller
{
    /**
     * Show the artist login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.artist_login');
    }

    /**
     * Handle the artist login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('artist')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/mypage');
        }

        return back()->withErrors([
            'email' => 'ログインに失敗しました。',
        ]);
    }

    /**
     * Handle the artist logout request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::guard('artist')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        //return redirect('/artist/login');
        return redirect('/dual-login');
    }
}
