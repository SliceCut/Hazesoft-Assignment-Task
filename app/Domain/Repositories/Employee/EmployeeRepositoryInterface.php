<?php

namespace App\Domain\Repositories\Employee;

use App\Domain\Abstracts\CriteriaInterface;
use App\Domain\ObjectValues\EmployeeObjectValue;
use App\Models\Employee;

interface EmployeeRepositoryInterface
{
    public function withRelations(array $relations);

    public function pushCriteria(CriteriaInterface $criteriaInterface): self;

    public function findEmployeeOrFail(int $id);

    public function getEmployees(
        array $select = ['*'],
        string $order = 'id',
        string $sort = 'desc'
    );

    public function paginateEmployees(
        array $select = ['*'],
        int $limit = 20,
        string $order = 'id',
        string $sort = 'desc'
    );

    public function createNewEmployee(EmployeeObjectValue $employeeObjectValue);

    public function updateEmployee(int $id, EmployeeObjectValue $employeeObjectValue): bool;

    public function syncDepartment(Employee $employee, array $data);

    public function deleteEmployee(int $id): bool;

    public function getEmployeeDepartments(Employee $employee);
}
