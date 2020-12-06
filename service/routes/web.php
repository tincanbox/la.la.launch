<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Inertia::share('app', [
    'env' => [
        'app_name' => env('APP_NAME')
    ]
]);

/**
 * Authenticated
 */
Route::group([
    'middleware' => ['auth:sanctum', 'verified']
], function () {

    Route::get('/', function () {
        return redirect('dashboard');
    });

    Route::get('/dashboard', function () {
        return inertia('Dashboard', []);
    })->name('dashboard');

});

/**
 * Guest
 */
Route::group([
    'middleware' => ['guest']
], function(){
    Route::get('/', function () {
        return view('auth.login');
    });
});
