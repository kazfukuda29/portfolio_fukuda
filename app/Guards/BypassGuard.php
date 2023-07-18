<?php 

namespace App\Guards;

use Illuminate\Contracts\Auth\Factory as AuthFactory;

/**
 * BypassGuardは特別な認証ガードです。セッションからの認証とAPIからの認証を切り替える役割があります。
 */
class BypassGuard
{
    private $config;
    private $auth;

    /**
     * BypassGuardのコンストラクター（作り手）です。ここで重要な情報を受け取り、保管します。
     *
     * @param AuthFactory $auth  Laravelの認証システムを操作するための工場。
     * @param array $config 設定情報（セッションとAPIのガード名）。
     */
    public function __construct(AuthFactory $auth, array $config)
    {
        $this->config = $config;
        $this->auth = $auth;
    }

    /**
     * Laravelがこのガードを使ってユーザーを認証するときに呼び出される特別な関数です。
     *
     * @return mixed ログインしているユーザーの情報。
     */
    public function __invoke()
    {
        $sessionGuard = $this->config['session'];
        $sanctumGuard = $this->config['sanctum'];

        // 設定値に従ってsanctum.phpのguardを書き換える
        config(['sanctum.guard' => [$sessionGuard]]);

        // 設定値に入力したguardを実行
        return $this->auth->guard($sanctumGuard)->user();
    }
}
