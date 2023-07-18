<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAnnouncementController;
use App\Http\Controllers\User\UserAnnouncementController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// adminsかusersかテーブル名を取得(optional() ヘルパー関数は、null許容値を含む値をラップし、その値が null の場合にもメソッド呼び出しを許可。)
// Route::get('/user-type', function (Request $request) {
//     return response()->json([
//         'type' => optional($request->user())->getTable(),
//     ]);
// });






Route::middleware('user_type')
    ->get('/user-type', function (Request $request) {
        return response()->json([
            'type' => $request->user_type,
        ]);
    });

// Route::middleware('auth:admin')->get('/user-type', function (Request $request) {
//     return response()->json([
//         'type' => 'admin',
//     ]);
// });






