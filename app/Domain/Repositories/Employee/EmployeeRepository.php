<?php

namespace App\Domain\Repositories\Employee;

use App\Domain\Abstracts\CriteriaInterface;
use App\Domain\Criteria\Common\CompanyCriteria;
use App\Domain\Criteria\Employee\EmployeeDepartmentCriteria;
use App\Domain\ObjectValues\EmployeeObjectValue;
use App\Models\Employee;
use App\Domain\Repositories\BaseRepository;
use App\Domain\Repositories\Employee\EmployeeRepositoryInterface;

class EmployeeRepository extends BaseRepository implements EmployeeRepositoryInterface
{
    protected $defaultRelations = ['company'];
    protected $filters = [
        'company_id' => CompanyCriteria::class,
        'department_id' => EmployeeDepartmentCriteria::class,
    ];

    /**
     * EmployeeRepository constructor.
     *
     * @param Employee $dummy
     */
    public function __construct(Employee $model)
    {
        parent::__construct($model);
    }

    public function withRelations(array $relation): self
    {
        parent::withRelations($relation);
        return $this;
    }

    public function pushCriteria(CriteriaInterface $criteriaInterface): self
    {
        parent::pushCriteria($criteriaInterface);

        return $this;
    }

    public function findEmployeeOrFail(int $id)
    {
        return $this->findOneOrFail($id);
    }

    public function getEmployees(
        array $select = ['*'],
        string $order = 'id',
        string $sort = 'desc'
    ) {
        return $this->all($select, $order, $sort);
    }

    public function paginateEmployees(
        array $select = ['*'],
        int $limit = 20,
        string $order = 'id',
        string $sort = 'desc'
    ) {
        return $this->paginate($select, $limit, $order, $sort);
    }

    public function createNewEmployee(EmployeeObjectValue $employeeObjectValue)
    {
        return $this->create($employeeObjectValue->toSql());
    }

    public function updateEmployee(int $id, EmployeeObjectValue $employeeObjectValue): bool
    {
        return $this->update($id, $employeeObjectValue->toSql());
    }

    public function syncDepartment(Employee $employee, array $datas)
    {
        return $employee->departments()->sync($datas);
    }

    public function getEmployeeDepartments(Employee $employee)
    {
        return $employee->departments()->get();
    }

    public function deleteEmployee(int $id): bool
    {
        return $this->delete($id);
    }
}
