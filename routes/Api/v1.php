<?php

use App\Http\Controllers\Api\V1\Auth\AuthLogoutController;
use App\Http\Controllers\Api\V1\Auth\AuthUserDetailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\CompanyController;
use App\Http\Controllers\Api\V1\DepartmentController;
use App\Http\Controllers\Api\V1\EmployeeController;
use App\Http\Controllers\Api\V1\Filters\CompanyListController;
use App\Http\Controllers\Api\V1\Filters\DepartmentListController;

Route::post('login', LoginController::class)->name('login');

Route::get('companies', [CompanyController::class, 'index']);
Route::get('companies/{company}/employees', [CompanyController::class, 'getPaginatedEmployeeList']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('auth/user', AuthUserDetailController::class);
    Route::post('auth/logout', AuthLogoutController::class);

    Route::group(['prefix' => 'list'], function () {
        Route::get('company', [CompanyListController::class, 'getAllCompanyList'])->name('list.company');
        Route::get('department', [DepartmentListController::class, 'getAllDepartmentList'])->name('list.department');
    });

    /**
     * Company route
     */
    Route::get('companies/{company}', [CompanyController::class,'show']);
    Route::post('companies', [CompanyController::class,'store']);
    Route::patch('companies/{company}', [CompanyController::class,'update']);
    Route::delete('companies/{company}', [CompanyController::class,'destroy']);

    /**
     * Department route
     */
    Route::get('departments', [DepartmentController::class,'index']);
    Route::get('departments/{department}', [DepartmentController::class,'show']);
    Route::post('departments', [DepartmentController::class,'store']);
    Route::patch('departments/{department}', [DepartmentController::class,'update']);
    Route::delete('departments/{department}', [DepartmentController::class,'destroy']);
    Route::get('departments/{department}/employees', [DepartmentController::class,'getEmployeesOfDeparment']);

    /**
     * Employee route
     */
    Route::get('employees', [EmployeeController::class,'index']);
    Route::get('employees/{employee}', [EmployeeController::class,'show']);
    Route::post('employees', [EmployeeController::class,'store']);
    Route::patch('employees/{employee}', [EmployeeController::class,'update']);
    Route::delete('employees/{employee}', [EmployeeController::class,'destroy']);
});
