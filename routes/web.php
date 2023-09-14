<?php

use App\Http\Controllers\Admin\AllocationController;
use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\AssetController;
use App\Http\Controllers\Admin\AssetUsesController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SubAssetController;
use App\Http\Controllers\Admin\LogsController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Front\HomeController;
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
    return redirect()->route('login');
});

Auth::routes();

Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.', 'middleware' => ['verified','auth']], static function() {

    Route::get('/', [DashboardController::class, 'index'])->name('index');

    Route::group(['prefix' => 'users', 'as' => 'users.', 'middleware' => ['verified','auth']], static function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create',[UserController::class, 'create'])->name('create');
        Route::post('/store',[UserController::class, 'store'])->name('store');
        Route::get('/edit/{user}',[UserController::class, 'edit'])->name('edit');
        Route::post('/update/{user}',[UserController::class, 'update'])->name('update');
        Route::post('/delete',[UserController::class, 'destroy'])->name('delete');
        Route::get('/profile',[UserController::class, 'profile'])->name('profile');
        Route::get('/export',[UserController::class, 'export'])->name('export');
        Route::get('/import',[UserController::class, 'import'])->name('import');
        Route::post('/import/store',[UserController::class, 'importStore'])->name('import.store');
        Route::get('/import/download/sample',[UserController::class, 'downloadSample'])->name('import.download.sample');
        Route::post('/password/store',[UserController::class, 'password'])->name('password.store');
    });


    Route::group(['prefix' => 'members', 'as' => 'members.', 'middleware' => ['verified','auth']], static function () {
        Route::get('/', [MemberController::class, 'index'])->name('index');
        Route::get('/create',[MemberController::class, 'create'])->name('create');
        Route::post('/store',[MemberController::class, 'store'])->name('store');
        Route::get('/edit/{member}',[MemberController::class, 'edit'])->name('edit');
        Route::post('/update/{member}',[MemberController::class, 'update'])->name('update');
        Route::post('/delete',[MemberController::class, 'destroy'])->name('delete');
        Route::get('/profile/{member}',[MemberController::class, 'profile'])->name('profile');
        Route::get('/password',[MemberController::class, 'password'])->name('password');
        Route::get('/export',[MemberController::class, 'export'])->name('export');
        Route::get('/import',[MemberController::class, 'import'])->name('import');
        Route::post('/import/store',[MemberController::class, 'importStore'])->name('import.store');
        Route::get('/import/download/sample',[MemberController::class, 'downloadSample'])->name('import.download.sample');
        Route::post('/password/store',[MemberController::class, 'changePassword'])->name('password.store');
    });

    Route::group(['prefix' => 'assets', 'as' => 'assets.', 'middleware' => ['verified','auth']], static function () {
        Route::get('/', [AssetController::class, 'index'])->name('index');
        Route::get('/create',[AssetController::class, 'create'])->name('create');
        Route::post('/store',[AssetController::class, 'store'])->name('store');
        Route::get('/edit/{asset}',[AssetController::class, 'edit'])->name('edit');
        Route::post('/update/{asset}',[AssetController::class, 'update'])->name('update');
        Route::get('/export',[AssetController::class, 'export'])->name('export');
        Route::get('/import',[AssetController::class, 'import'])->name('import');
        Route::post('/import/store',[AssetController::class, 'importStore'])->name('import.store');
        Route::get('/import/download/sample',[AssetController::class, 'downloadSample'])->name('import.download.sample');
        Route::post('/delete',[AssetController::class, 'destroy'])->name('delete');
    });

    Route::group(['prefix' => 'subassets', 'as' => 'subassets.', 'middleware' => ['verified','auth']], static function () {
        Route::get('/', [SubAssetController::class, 'index'])->name('index');
        Route::get('/create',[SubAssetController::class, 'create'])->name('create');
        Route::post('/store',[SubAssetController::class, 'store'])->name('store');
        Route::get('/edit/{subasset}',[SubAssetController::class, 'edit'])->name('edit');
        Route::post('/update/{subasset}',[SubAssetController::class, 'update'])->name('update');
        Route::get('/export',[SubAssetController::class, 'export'])->name('export');
        Route::get('/import',[SubAssetController::class, 'import'])->name('import');
        Route::post('/import/store',[SubAssetController::class, 'importStore'])->name('import.store');
        Route::get('/import/download/sample',[SubAssetController::class, 'downloadSample'])->name('import.download.sample');
        Route::post('/delete',[SubAssetController::class, 'destroy'])->name('delete');
    });

    Route::group(['prefix' => 'areas', 'as' => 'areas.', 'middleware' => ['verified','auth']], static function () {
        Route::get('/', [AreaController::class, 'index'])->name('index');
        Route::get('/create',[AreaController::class, 'create'])->name('create');
        Route::post('/store',[AreaController::class, 'store'])->name('store');
        Route::get('/edit/{area}',[AreaController::class, 'edit'])->name('edit');
        Route::post('/update/{area}',[AreaController::class, 'update'])->name('update');
        Route::get('/export',[AreaController::class, 'export'])->name('export');
        Route::get('/import',[AreaController::class, 'import'])->name('import');
        Route::post('/import/store',[AreaController::class, 'importStore'])->name('import.store');
        Route::get('/import/download/sample',[AreaController::class, 'downloadSample'])->name('import.download.sample');
        Route::post('/delete',[AreaController::class, 'destroy'])->name('delete');
    });

    Route::group(['prefix' => 'uses', 'as' => 'uses.', 'middleware' => ['verified','auth']], static function () {
        Route::get('/', [AssetUsesController::class, 'index'])->name('index');
        Route::get('/create',[AssetUsesController::class, 'create'])->name('create');
        Route::post('/store',[AssetUsesController::class, 'store'])->name('store');
        Route::get('/edit/{use}',[AssetUsesController::class, 'edit'])->name('edit');
        Route::post('/update/{use}',[AssetUsesController::class, 'update'])->name('update');
        Route::get('/export',[AssetUsesController::class, 'export'])->name('export');
        Route::get('/import',[AssetUsesController::class, 'import'])->name('import');
        Route::post('/import/store',[AssetUsesController::class, 'importStore'])->name('import.store');
        Route::get('/import/download/sample',[AssetUsesController::class, 'downloadSample'])->name('import.download.sample');
        Route::post('/delete',[AssetUsesController::class, 'destroy'])->name('delete');
    });

    Route::group(['prefix' => 'allocations', 'as' => 'allocations.', 'middleware' => ['verified','auth']], static function () {
        Route::get('/', [AllocationController::class, 'index'])->name('index');
        Route::get('/create',[AllocationController::class, 'create'])->name('create');
        Route::post('/store',[AllocationController::class, 'store'])->name('store');
        Route::get('/edit/{subasset}',[AllocationController::class, 'edit'])->name('edit');
        Route::post('/update/{subasset}',[AllocationController::class, 'update'])->name('update');
        Route::get('/export',[AllocationController::class, 'export'])->name('export');
        Route::get('/import',[AllocationController::class, 'import'])->name('import');
        Route::post('/import/store',[AllocationController::class, 'importStore'])->name('import.store');
        Route::get('/import/download/sample',[AllocationController::class, 'downloadSample'])->name('import.download.sample');
        Route::post('/delete',[AllocationController::class, 'destroy'])->name('delete');
    });


    Route::group(['prefix' => 'logs', 'as' => 'logs.', 'middleware' => ['verified','auth']], static function () {
        Route::get('/', [LogsController::class, 'index'])->name('index');
    });

    Route::group(['prefix' => 'settings', 'as' => 'settings.', 'middleware' => ['verified','auth']], static function () {

        Route::group(['prefix' => 'general', 'as' => 'general.', 'middleware' => ['verified','auth']], static function () {

            Route::get('/', [SettingController::class, 'general'])->name('index');
            Route::post('/store', [SettingController::class, 'generalStore'])->name('store');
        });

        Route::group(['prefix' => 'roles', 'as' => 'roles.', 'middleware' => ['verified','auth']], static function () {
            Route::get('/', [RolesController::class, 'index'])->name('index');
            Route::get('/create',[RolesController::class, 'create'])->name('create');
            Route::post('/store',[RolesController::class, 'store'])->name('store');
            Route::get('/edit/{role}',[RolesController::class, 'edit'])->name('edit');
            Route::post('/update/{role}',[RolesController::class, 'update'])->name('update');
            Route::post('/delete',[RolesController::class, 'destroy'])->name('delete');
        });

    });

    Route::group(['prefix' => 'reports', 'as' => 'reports.', 'middleware' => ['verified','auth']], static function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');

        Route::group(['prefix' => 'summary', 'as' => 'summary.', 'middleware' => ['verified','auth']], static function () {
            Route::get('/', [ReportController::class, 'showSummaryReports'])->name('index');
        });
        
        Route::group(['prefix' => 'members', 'as' => 'members.', 'middleware' => ['verified','auth']], static function () {
            Route::get('/', [ReportController::class, 'getMembersReports'])->name('index');
            Route::get('/show', [ReportController::class, 'showMembersReports'])->name('show');
            Route::post('/excel', [ReportController::class, 'excelMembersReport'])->name('excel');
        });

        Route::group(['prefix' => 'subassets', 'as' => 'subassets.', 'middleware' => ['verified','auth']], static function () {
            Route::get('/', [ReportController::class, 'getSubAssetsReports'])->name('index');
            Route::get('/show', [ReportController::class, 'showSubAssetsReports'])->name('show');
            Route::post('/excel', [ReportController::class, 'excelSubAssetsReport'])->name('excel');
        });

    });

});
