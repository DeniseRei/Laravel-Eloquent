<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

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

Route::get('/select', function(){
    //$users = User::all();
    //$users = User::where('id', 10)->get();
    //$users = User::first();
    //$users = User::find(10);
    //$users = User::findOrFail(10);
    //$users = User::where('name', request('name'))->firstOrFail();
    $users = User::firstWhere('name', request('name'));
    dd($users);
});

Route::get('/', function () {
    return view('welcome');
});
