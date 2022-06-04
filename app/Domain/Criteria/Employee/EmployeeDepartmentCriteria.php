<?php

namespace App\Domain\Criteria\Employee;

use App\Domain\Abstracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Builder;

class EmployeeDepartmentCriteria implements CriteriaInterface
{
    private $department_id;

    public function __construct($department_id)
    {
        $this->department_id = $department_id;
    }

    public function apply(Builder $query): Builder
    {
        return $query->whereHas('departments', function ($q) {
            $q->where('id', $this->department_id);
        });
    }
}
