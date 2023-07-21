<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Mail\ComputanEmail;

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
//Entry route for the application
Route::get('/all',function(){
    return view('all');
});
//Route for Admin Login page
Route::get('/admin', [AuthController::class, 'admin'])->name('admin');

//Route for user Login page
Route::get('/', [AuthController::class, 'user']);

//Route to validate admin
Route::post('/validate', [AuthController::class, 'auth']);

//Route to validate user
Route::post('/validate_user', [AuthController::class, 'auth']);

//Route to user homepage
Route::get('/home', [AuthController::class, 'home'])->middleware('auth');

//Route to process Csv  file and store record
Route::post('/csvupload', [TaskController::class, 'csvupload']);

//Route to user homepage
Route::get('/admin_home', [AuthController::class, 'home'])->middleware('auth');

//Route to read data from https://api.publicapis.org/entries  API
Route::get('/read-dfa', [TaskController::class, 'read_dfa']);

//Route to get the info for any batch of Job
Route::get('/batchinfo', [TaskController::class, 'batchinfo']);

//Route to show mailer form
Route::get('/mailer',[TaskController::class, 'showMailer']);

//Route to process mailer
Route::post('/mailer',[TaskController::class, 'mailer']);


