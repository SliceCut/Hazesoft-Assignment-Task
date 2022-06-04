<?php

namespace App\Http\Controllers\Api\V1\Filters;

use App\Domain\Repositories\Company\CompanyRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CompanyListController extends Controller
{
    private CompanyRepositoryInterface $companyRepository;

    public function __construct(
        CompanyRepositoryInterface $companyRepository
    ) {
        $this->companyRepository = $companyRepository;
    }

    public function getAllCompanyList()
    {
        return new Response(
            $this->companyRepository->getCompanies(['id','name'])
        );
    }
}
