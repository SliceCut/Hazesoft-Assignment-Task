<?php

namespace App\Http\Controllers\Api\V1\Filters;

use App\Domain\Repositories\Department\DepartmentRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DepartmentListController extends Controller
{
    private DepartmentRepositoryInterface $departmentRepository;

    public function __construct(
        DepartmentRepositoryInterface $departmentRepository
    ) {
        $this->departmentRepository = $departmentRepository;
    }

    public function getAllDepartmentList()
    {
        return new Response(
            $this->departmentRepository->getDepartments(['id','name','company_id'])
        );
    }
}
