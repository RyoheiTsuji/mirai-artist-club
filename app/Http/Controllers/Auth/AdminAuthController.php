<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminAuthController extends Controller
{
    /**
     * 管理者ログインフォームの表示
     */
    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    /**
     * 管理者ログイン処理
     */
    public function login(Request $request)
    {
        // 入力値を検証
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // ログインに必要な認証情報を取得
        $credentials = $request->only('email', 'password');

        Log::info('Attempting login with credentials:', $credentials);

        // メールアドレスが存在するか確認
        $admin = Admin::where('email', $credentials['email'])->first();
        if (!$admin) {
            return back()->withErrors([
                'email' => 'このメールアドレスは登録されていません。',
            ]);
        }

        // パスワードが正しいか確認
        if (!Hash::check($credentials['password'], $admin->password)) {
            return back()->withErrors([
                'password' => 'パスワードが正しくありません。',
            ]);
        }

        // リメンバーオプション付きで認証情報を基にログイン試行
        $remember = $request->filled('remember'); // remember がチェックされているか確認
        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            return redirect()->intended('/admin');
        }

        return back()->withErrors([
            'email' => 'ログインに失敗しました。',
        ]);
    }

    /**
     * 管理者ログアウト処理
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        // ログイン画面にリダイレクト
        return redirect('/admin/login');
    }
}
