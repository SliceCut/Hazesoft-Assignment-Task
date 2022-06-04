<?php

namespace App\Domain\Repositories\Department;

use App\Domain\Criteria\Common\CompanyCriteria;
use App\Domain\ObjectValues\DepartmentObjectValue;
use App\Models\Department;
use App\Domain\Repositories\BaseRepository;
use App\Domain\Repositories\Department\DepartmentRepositoryInterface;

class DepartmentRepository extends BaseRepository implements DepartmentRepositoryInterface
{
    protected $defaultRelations = ['company'];

    protected $filters = [
        'company_id' => CompanyCriteria::class
    ];

	/**
     * DepartmentRepository constructor.
     *
     * @param Department $dummy
     */
    public function __construct(Department $model)
    {
        parent::__construct($model);
    }

    public function findDepartmentOrFail(int $id)
    {
        return $this->findOneOrFail($id);
    }

    public function getDepartments(
        array $select = ['*'],
        string $order = 'id',
        string $sort = 'desc'
    ){
        return $this->all($select, $order, $sort);
    }

    public function paginateDepartments(
        array $select = ['*'],
        int $limit = 20,
        string $order = 'id',
        string $sort = 'desc'
    ){
        return $this->paginate($select, $limit, $order, $sort);
    }

    public function createNewDepartment(DepartmentObjectValue $departmentObjectValue)
    {
        return $this->create($departmentObjectValue->toSql());
    }

    public function updateDepartment(int $id, DepartmentObjectValue $departmentObjectValue): bool
    {
        return $this->update($id, $departmentObjectValue->toSql());
    }

    public function deleteDepartment(int $id): bool
    {
        return $this->delete($id);
    }

}