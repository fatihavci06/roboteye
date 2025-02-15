<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('auth')->group(function () {
    // Kullanıcı girişi (Login)
    Route::post('login', [AuthController::class, 'login']);

    // Kullanıcı bilgilerini alma (Me)

    // Kullanıcı çıkışı (Logout)
    Route::middleware('jwtMiddleware')->post('logout', [AuthController::class, 'logout']);
});
Route::middleware(['jwtMiddleware'])->group(function () {
    Route::resource('companies', CompanyController::class);
    Route::resource('employes', EmployeController::class);
});