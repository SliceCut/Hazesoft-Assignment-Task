<?php

namespace Database\Seeders;

use App\Domain\Factories\EmployeeFactory;
use App\Domain\Repositories\Department\DepartmentRepositoryInterface;
use App\Domain\Repositories\Employee\EmployeeRepositoryInterface;
use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    private DepartmentRepositoryInterface $departmentRepository;
    private EmployeeRepositoryInterface $employeeRepository;

    public function __construct(
        DepartmentRepositoryInterface $departmentRepository,
        EmployeeRepositoryInterface $employeeRepository
    ) {
        $this->departmentRepository = $departmentRepository;
        $this->employeeRepository = $employeeRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = collect($this->departmentRepository->paginateDepartments(['id', 10])->items())->pluck('id');
        Employee::factory()
            ->count(10)
            ->make()
            ->each(function ($row) use ($departments) {
                $employee = $this->employeeRepository->createNewEmployee(
                    EmployeeFactory::make($row->toArray())
                );

                $this->employeeRepository->syncDepartment($employee, $departments->toArray());
            });
    }
}
