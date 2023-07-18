<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\AuthenticationException;

/**
 * Authenticateは認証が必要なページに未ログインユーザーがアクセスしたときに
 * リダイレクトする振る舞いを定義します。
 */
class Authenticate extends Middleware
{
    // リダイレクト先を、'設定したGuardの名称' => 'ログインしたいルート名'で記載する
    protected $redirectTo = [
        'users' => 'user.login',
        'admin' => 'admin.login',
    ];

    /**
     * 未認証ユーザーをログイン画面にリダイレクトするURLを取得します。
     *
     * @param $request 現在のリクエスト情報。
     * @param $guards 使用するガードのリスト。
     * @return string リダイレクトするURL。
     */
    protected function redirectToMultiLogin($request, $guards)
    {
        if (! $request->expectsJson()) {
            foreach ($guards as $guard) {
                if (isset($this->redirectTo[$guard])) {
                    return route($this->redirectTo[$guard], $request->route()->parameters());
                }
            }
        }
    }

    /**
     * 未認証ユーザーがいたときに例外をスローします。これにより、ユーザーはログイン画面にリダイレクトされます。
     *
     * @param $request 現在のリクエスト情報。
     * @param array $guards 使用するガードのリスト。
     * @throws AuthenticationException 未認証例外。
     */
    protected function unauthenticated($request, array $guards)
    {
        throw new AuthenticationException(
            'Unauthenticated.', $guards, $this->redirectToMultiLogin($request, $guards)
        );
    }
}
