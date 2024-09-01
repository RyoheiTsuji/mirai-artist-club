<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        Log::info('Attempting login with credentials:', $credentials);

        // メールアドレスが存在するか確認
        $admin = \App\Models\Admin::where('email', $credentials['email'])->first();
        if (!$admin) {
            Log::warning('Login failed: email does not exist.', ['email' => $credentials['email']]);
            return back()->withErrors([
                'email' => 'このメールアドレスは登録されていません。',
            ]);
        }

        // パスワードが正しいか確認
        if (!\Hash::check($credentials['password'], $admin->password)) {
            Log::warning('Login failed: incorrect password.', ['email' => $credentials['email']]);
            return back()->withErrors([
                'password' => 'パスワードが正しくありません。',
            ]);
        }

        // 上記のチェックをパスした場合にログイン試行
        if (Auth::guard('admin')->attempt($credentials)) {
            Log::info('Login successful for admin:', ['email' => $request->email]);
            return redirect()->intended('/admin');
        }

        Log::warning('Login failed for unknown reason.', ['email' => $request->email]);
        return back()->withErrors([
            'email' => 'ログインに失敗しました。',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        //return redirect('/admin/login');
        return redirect('/dual-login');
    }
}
