<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserType
{
    public function handle($request, Closure $next)
    {
        if (Auth::guard('users')->check()) {
            $request->user_type = 'users';
        } elseif (Auth::guard('admin')->check()) {
            $request->user_type = 'admin';
        } else {
            // ユーザーが認証されていない場合の処理
            // ここでは例としてリダイレクトさせていますが、適切な処理に変更してください
            return abort(403);
        }

        return $next($request);
    }
}
