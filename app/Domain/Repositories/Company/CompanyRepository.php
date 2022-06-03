<?php

namespace App\Domain\Repositories\Company;

use App\Domain\Repositories\BaseRepository;

class CompanyRepository extends BaseRepository implements CompanyRepositoryInterface
{
    public function getCompanies(
        array $select = ['*'],
        string $order = 'id',
        string $sort = 'desc'
    ){
        return $this->all($select, $order, $sort);
    }

    public function paginateCompanies(
        array $select = ['*'],
        int $limit = 20,
        string $order = 'id',
        string $sort = 'desc'
    ){
        return $this->paginate($select, $limit, $order, $sort);
    }

    public function createCompany(array $data)
    {
        return $this->create($data);
    }

    public function updateCompany(int $id, array $data): bool
    {
        return $this->update($id, $data);
    }

    public function deleteCompany(int $id): bool
    {
        return $this->delete($id);
    }
}