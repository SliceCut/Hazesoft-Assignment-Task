<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\CompanyController;

Route::post('login', LoginController::class)->name('login');

Route::get('companies', [CompanyController::class, 'index']);

Route::group(['middleware' => 'auth:sanctum'], function() {

    /**
     * Companies route
     */
    Route::get('companies/{company}',[CompanyController::class,'show']);
    Route::post('companies',[CompanyController::class,'store']);
    Route::patch('companies/{company}',[CompanyController::class,'update']);
    Route::delete('companies/{company}',[CompanyController::class,'destroy']);

}); 