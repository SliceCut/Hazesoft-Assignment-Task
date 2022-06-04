<?php

namespace Database\Seeders;

use App\Domain\Factories\DepartmentFactory;
use App\Domain\Repositories\Department\DepartmentRepositoryInterface;
use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    private DepartmentRepositoryInterface $departmentRepository;

    public function __construct(
        DepartmentRepositoryInterface $departmentRepository
    ) {
        $this->departmentRepository = $departmentRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::factory()
            ->count(10)
            ->make()
            ->each(function ($row) {
                $this->departmentRepository->createNewDepartment(
                    DepartmentFactory::make($row->toArray())
                );
            });
    }
}
