<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!->where('any', '.*')
|factory(App\User::class, 100)->create();
*/

/*Route::get('/', function () {
    return view('welcome');
});*/
Route::get('/{any}', function(){
    return view('single');
})->where('any', '.*');
Auth::routes();