<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::group(['middleware' => ['auth']], function() {
    Route::resource('companies', CompanyController::class);
    Route::get('/import-company', 'App\Http\Controllers\ImportCompanyController@importPage')->name('import-company');
    Route::post('/import-data', 'App\Http\Controllers\ImportCompanyController@importData')->name('import-data');
    Route::resource('employees', EmployeeController::class);
});
// Route::get('/import-company', 'ImportCompanyController@importPage')->name('import-company');
// Route::post('/import-data', 'ImportCompanyController@importData')->name('import-data');
// use App\Http\Controllers\ImportCompanyController;
// Route::get('/import-company' , [ImportCompanyController::class,'importPage']);
// Route::post('/import-data' , [ImportCompanyController::class,'importData']);