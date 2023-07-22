<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * クラス RedirectIfAuthenticated
 *
 * 既に認証されたユーザーをリダイレクトするためのミドルウェア。
 *
 * @package App\Http\Middleware
 */
class RedirectIfAuthenticated
{
    /**
     * 各ガードがリダイレクトすべきパス。
     *
     * @var array
     */
    protected $redirectTo = [
        'admin' => RouteServiceProvider::ADMIN_HOME,
        'users' => RouteServiceProvider::USER_HOME,
    ];

    /**
     * 送られてきたリクエストを処理します。
     *
     * このメソッドでは、提供された各ガードについて認証状態をチェックします。もしユーザーが
     * ガードで認証されている場合、そのユーザーを適切なホームページにリダイレクトします。
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$guards
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check() && $request->routeIs($guard . '.*')) {
                return redirect($this->redirectTo[$guard]);
            }
        }

        return $next($request);
    }
}

