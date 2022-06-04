<?php

namespace App\Domain\Repositories\Department;

use App\Domain\ObjectValues\DepartmentObjectValue;

interface DepartmentRepositoryInterface
{
    public function findDepartmentOrFail(int $id);

    public function getDepartments(
        array $select = ['*'],
        string $order = 'id',
        string $sort = 'desc'
    );

    public function paginateDepartments(
        array $select = ['*'],
        int $limit = 20,
        string $order = 'id',
        string $sort = 'desc'
    );

    public function createNewDepartment(DepartmentObjectValue $departmentObjectValue);

    public function updateDepartment(int $id, DepartmentObjectValue $DepartmentObjectValue): bool;

    public function deleteDepartment(int $id): bool;
}
