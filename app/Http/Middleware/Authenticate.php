<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * ログインがタイムアウトした時のリダイレクト先
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        // 管理者用のリダイレクト
        if ($request->is('admin/*')) {
            return route('admin.login');
        }

        // アーティスト用のリダイレクト
        if ($request->is('artist/*')) {
            return route('artist.login');
        }

        // デフォルトのリダイレクト先を指定
        return route('home'); // 共通のログインページにリダイレクトする場合
    }
}
