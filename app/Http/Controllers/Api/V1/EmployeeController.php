<?php

namespace App\Http\Controllers\Api\V1;

use App\Domain\Factories\EmployeeFactory;
use App\Domain\Repositories\Employee\EmployeeRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\V1\Employee\EmployeeStoreRequest;
use App\Http\Requests\Api\V1\Employee\EmployeeUpdateRequest;
use App\Http\Resources\Api\V1\Employee\EmployeeResource;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    private EmployeeRepositoryInterface $employeeRepository;

    public function __construct(
        EmployeeRepositoryInterface $employeeRepository
    ) {
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

        $employees = $this->employeeRepository
            ->withRelations(['departments'])
            ->paginateEmployees(['*'], $perpage);

        return $this->responsePaginate(
            EmployeeResource::collection($employees)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $employee = $this->employeeRepository->createNewEmployee(
                EmployeeFactory::make($request->all())
            );


            if ($request->departments) {
                $this->employeeRepository->syncDepartment($employee, $request->departments);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->responseError($e);
        }

        return $this->responseOk(
            "Employee created successfully",
            EmployeeResource::make($employee),
            201
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        return EmployeeResource::make($employee->load('departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeUpdateRequest $request, Employee $employee)
    {
        DB::beginTransaction();
        try {
            $this->employeeRepository->updateEmployee(
                $employee->id,
                EmployeeFactory::make($request->all())
            );

            if ($request->departments) {
                $this->employeeRepository->syncDepartment($employee, $request->departments);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->responseError($e);
        }

        return $this->responseOk(
            "Employee updated successfully",
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        try {
            $employee = $this->employeeRepository->deleteEmployee($employee->id);
        } catch (\Exception $e) {
            return $this->responseError($e);
        }

        return $this->responseOk(
            "Employee deleted successfully",
        );
    }
}
