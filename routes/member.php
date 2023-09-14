<?php

use App\Http\Controllers\Member\AllocationController;
use App\Http\Controllers\Member\Auth\ConfirmPasswordController;
use App\Http\Controllers\Member\Auth\ForgotPasswordController;
use App\Http\Controllers\Member\Auth\ResetPasswordController;
use App\Http\Controllers\Member\Auth\VerificationController;
use App\Http\Controllers\Member\DashboardController;
use App\Http\Controllers\Member\Auth\LoginController;
use App\Http\Controllers\Member\UserController;
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

Route::get('/', function () {
    return redirect()->route('member.login');
});



Route::get('/login', [LoginController::class, 'showLoginForm'])->name('member.login');
Route::post('/login', [LoginController::class, 'login'])->name('member.login');
Route::post('/logout', [LoginController::class, 'logout'])->name('member.logout');

Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('member.password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('member.password.email');

Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('member.password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('member.password.update');

Route::get('password/confirm', [ConfirmPasswordController::class, 'showConfirmForm'])->name('member.password.confirm');
Route::post('password/confirm', [ConfirmPasswordController::class, 'confirm']);

Route::get('email/verify', [VerificationController::class, 'show'])->name('member.verification.notice');
Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('member.verification.verify');
Route::post('email/resend', [VerificationController::class, 'resend'])->name('member.verification.resend');

Route::group(['prefix' => 'dashboard', 'as' => 'member.dashboard.', 'middleware' => ['verified','auth:member']], static function() {

    Route::get('/', [DashboardController::class, 'index'])->name('index');

    Route::group(['prefix' => 'users', 'as' => 'users.', 'middleware' => ['verified','auth']], static function () {
        Route::get('/profile',[UserController::class, 'profile'])->name('profile');
        Route::post('/password/store',[UserController::class, 'password'])->name('password.store');
    });

    Route::group(['prefix' => 'allocations', 'as' => 'allocations.', 'middleware' => ['verified','auth:member']], static function () {
        Route::get('/', [AllocationController::class, 'index'])->name('index');
    });


});
