<?php

namespace App\Http\Controllers\Api\V1;

use App\Domain\Criteria\Common\CompanyCriteria;
use App\Domain\Factories\CompanyFactory;
use App\Domain\Repositories\Company\CompanyRepositoryInterface;
use App\Domain\Repositories\Employee\EmployeeRepository;
use App\Domain\Repositories\Employee\EmployeeRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Company\CompanyStoreRequest;
use App\Http\Requests\Api\V1\Company\CompanyUpdateRequest;
use App\Http\Resources\Api\V1\Company\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    private CompanyRepositoryInterface $companyRepository;
    private EmployeeRepositoryInterface $employeeRepository;

    public function __construct(
        CompanyRepositoryInterface $companyRepository,
        EmployeeRepositoryInterface $employeeRepository
    )
    {
        $this->companyRepository = $companyRepository;
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

        $companies = $this->companyRepository->paginateCompanies(['*'],$perpage);

        return $this->responsePaginate(
            CompanyResource::collection($companies)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyStoreRequest $request)
    {
        try {
            $company = $this->companyRepository->createNewCompany(
                CompanyFactory::make($request->all())
            );
        } catch(\Exception $e) {
            return $this->responseError($e);
        }

        return $this->responseOk(
            "Company created successfully",
            $company,
            201
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        return CompanyResource::make($company);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyUpdateRequest $request, Company $company)
    {
        try {
            $company = $this->companyRepository->updateCompany(
                $company->id,
                CompanyFactory::make($request->all())
            );
        } catch(\Exception $e) {
            return $this->responseError($e);
        }

        return $this->responseOk(
            "Company updated successfully",
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        try {
            $company = $this->companyRepository->deleteCompany($company->id);
        } catch(\Exception $e) {
            return $this->responseError($e);
        }

        return $this->responseOk(
            "Company deleted successfully",
        );
    }

    public function getPaginatedEmployeeList(Request $request, Company $company)
    {
        $perpage = $request->get('perPage', 20);
        return $this->responsePaginate(
            $this->employeeRepository
                ->pushCriteria(
                    new CompanyCriteria($company->id)
                )
                ->paginateEmployees(['*'], $perpage)
        );
    }
}
