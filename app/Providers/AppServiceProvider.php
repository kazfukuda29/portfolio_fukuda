<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\RequestGuard;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Auth::resolved(function ($auth) {
            $auth->extend('proxy-sanctum', function ($app, $name, array $config) use ($auth) {
                return tap($this->createGuard($auth, $config), function ($guard) {
                    app()->refresh('request', $guard, 'setRequest');
                });
            });
        });
        // Schema::disableForeignKeyConstraints();
    }

    /**
     * 新しいRequestGuard（認証ガード）を作ります。このガードはBypassGuardを使います。
     *
     * @param $auth Laravelの認証システム。
     * @param $config 設定情報（セッションとAPIのガード名）。
     * @return RequestGuard 新しく作った認証ガード。
     */
    protected function createGuard($auth, $config)
    {
        return new RequestGuard(
            new \App\Guards\BypassGuard($auth, $config),
            request(),
            $auth->createUserProvider($config['provider'] ?? null)
        );
    }
}

