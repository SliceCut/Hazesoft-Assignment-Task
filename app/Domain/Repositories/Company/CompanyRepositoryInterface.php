<?php

namespace App\Domain\Repositories\Company;

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

    public function createCompany(array $data);

    public function updateCompany(int $id, array $data): bool;

    public function deleteCompany(int $id): bool;
}