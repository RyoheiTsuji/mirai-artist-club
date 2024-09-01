<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Handle unauthenticated user exceptions (e.g., session timeout)
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    protected function unauthenticated($request, AuthenticationException $exception): \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
    {
        $guard = Arr::get($exception->guards(), 0);  // 最初のガードを取得

        if ($guard === 'admin') {
            $loginRoute = 'admin.login'; // 管理者のログインルート
        } elseif ($guard === 'artist') {
            $loginRoute = 'artist.login'; // アーティストのログインルート
        } else {
            // もし他のガードが存在しない場合は、適切なエラーハンドリングを行います。
            abort(403, 'Unauthorized action.');
        }

        if ($request->expectsJson()) {
            return new JsonResponse(['message' => 'Unauthenticated.'], 401);
        }

        return redirect()->route($loginRoute)->with([
            'error' => 'ログイン後一定時間操作がなかったためログアウトされました。',
            'redirect_url' => url()->current(),
        ]);
    }


}
