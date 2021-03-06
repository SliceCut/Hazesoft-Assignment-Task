<?php

namespace App\Providers;

use App\Domain\Repositories\Company\CompanyRepository;
use App\Domain\Repositories\Company\CompanyRepositoryInterface;
use App\Domain\Repositories\Department\DepartmentRepository;
use App\Domain\Repositories\Department\DepartmentRepositoryInterface;
use App\Domain\Repositories\Employee\EmployeeRepository;
use App\Domain\Repositories\Employee\EmployeeRepositoryInterface;
use App\Domain\Repositories\User\UserRepository;
use App\Domain\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->bind(
            CompanyRepositoryInterface::class,
            CompanyRepository::class
        );

        $this->app->bind(
            DepartmentRepositoryInterface::class,
            DepartmentRepository::class
        );

        $this->app->bind(
            EmployeeRepositoryInterface::class,
            EmployeeRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Route::bind('company', function ($id, $route) {
            $company = app()->make(CompanyRepositoryInterface::class);

            return $company->findCompanyOrFail($id);
        });

        Route::bind('department', function ($id, $route) {
            $department = app()->make(DepartmentRepositoryInterface::class);
            return $department->findDepartmentOrFail($id);
        });

        Route::bind('employee', function ($id, $route) {
            $employee = app()->make(EmployeeRepositoryInterface::class);

            return $employee->findEmployeeOrFail($id);
        });
    }
}
