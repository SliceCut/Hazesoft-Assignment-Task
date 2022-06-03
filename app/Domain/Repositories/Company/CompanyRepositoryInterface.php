<?php

namespace App\Domain\Repositories\Company;

use App\Domain\ObjectValues\CompanyObjectValue;

interface CompanyRepositoryInterface
{
    public function getCompanies(
        array $select = ['*'],
        string $order = 'id',
        string $sort = 'desc'
    );

    public function paginateCompanies(
        array $select = ['*'],
        int $limit = 20,
        string $order = 'id',
        string $sort = 'desc'
    );

    public function findCompanyOrFail(int $id);

    public function createNewCompany(CompanyObjectValue $companyObjectValue);

    public function updateCompany(int $id, CompanyObjectValue $companyObjectValue): bool;

    public function deleteCompany(int $id): bool;
}