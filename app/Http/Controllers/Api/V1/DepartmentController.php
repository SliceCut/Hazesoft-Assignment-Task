<?php

namespace App\Http\Controllers\Api\V1;

use App\Domain\Criteria\Employee\EmployeeDepartmentCriteria;
use App\Domain\Factories\DepartmentFactory;
use App\Domain\Repositories\Department\DepartmentRepositoryInterface;
use App\Domain\Repositories\Employee\EmployeeRepository;
use App\Domain\Repositories\Employee\EmployeeRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Department\DepartmentResource;
use App\Http\Requests\Api\V1\Department\DepartmentStoreRequest;
use App\Http\Requests\Api\V1\Department\DepartmentUpdateRequest;
use App\Http\Resources\Api\V1\Employee\EmployeeResource;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perpage = $request->get('perPage', 20);

        $departments = $this->departmentRepository
            ->paginateDepartments(['*'], $perpage);

        return $this->responsePaginate(
            DepartmentResource::collection($departments)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartmentStoreRequest $request)
    {
        try {
            $department = $this->departmentRepository->createNewDepartment(
                DepartmentFactory::make($request->all())
            );
        } catch (\Exception $e) {
            return $this->responseError($e);
        }

        return $this->responseOk(
            "Department created successfully",
            $department,
            201
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        return DepartmentResource::make($department);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DepartmentUpdateRequest $request, Department $department)
    {
        dd($request->all());
        try {
            $company = $this->departmentRepository->updateDepartment(
                $department->id,
                DepartmentFactory::make($request->all())
            );
        } catch (\Exception $e) {
            return $this->responseError($e);
        }

        return $this->responseOk(
            "Department updated successfully",
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        try {
            $company = $this->departmentRepository->deleteDepartment($department->id);
        } catch (\Exception $e) {
            return $this->responseError($e);
        }

        return $this->responseOk(
            "Department deleted successfully",
        );
    }

    public function getEmployeesOfDeparment(Request $request, Department $department)
    {
        $perpage = $request->get('perPage', 20);
        $employees=  $this->employeeRepository->pushCriteria(
            new EmployeeDepartmentCriteria($department->id)
        )
        ->paginateEmployees(['*'], $perpage);

        return $this->responsePaginate(EmployeeResource::collection($employees));
    }
}
