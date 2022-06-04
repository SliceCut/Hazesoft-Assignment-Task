<?php

namespace App\Domain\Repositories\Company;

use App\Domain\ObjectValues\CompanyObjectValue;
use App\Domain\Repositories\BaseRepository;
use App\Models\Company;

class CompanyRepository extends BaseRepository implements CompanyRepositoryInterface
{
    public function __construct(
        Company $company
    ) {
        parent::__construct($company);
    }

    public function firstOrFail()
    {
        return parent::firstOrFail();
    }

    public function findCompanyOrFail(int $id)
    {
        return $this->findOneOrFail($id);
    }

    public function getCompanies(
        array $select = ['*'],
        string $order = 'id',
        string $sort = 'desc'
    ) {
        return $this->all($select, $order, $sort);
    }

    public function paginateCompanies(
        array $select = ['*'],
        int $limit = 20,
        string $order = 'id',
        string $sort = 'desc'
    ) {
        return $this->paginate($select, $limit, $order, $sort);
    }

    public function createNewCompany(CompanyObjectValue $companyObjectValue)
    {
        return $this->create($companyObjectValue->toSql());
    }

    public function updateCompany(int $id, CompanyObjectValue $companyObjectValue): bool
    {
        return $this->update($id, $companyObjectValue->toSql());
    }

    public function deleteCompany(int $id): bool
    {
        return $this->delete($id);
    }
}
