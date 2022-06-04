<?php

namespace App\Domain\Repositories;

use App\Domain\Abstracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

interface BaseRepositoryInterface
{
    public function queryBuilder(): Builder;
    public function withRelations(array $relation): self;
    public function withCounts(array $counts): self;
    public function exceptAttribute(string $attribute, array $data): self;
    public function create(array $params);
    public function update($id, array $params): bool;
    public function updateOrCreate(array $params);
    public function delete($id): bool;
    public function findById($id);
    public function findOneOrFail($id);
    public function all(array $select = ['*'], string $order = 'id', string $sort = 'desc');
    public function getAllBy(array $data);
    public function where(Builder $query, array $data): Builder;
    public function findOneBy(array $data);
    public function paginate(array $select = ['*'], int $limit = 20, string $order = 'id', string $sort = 'desc');
    public function loadRelations(array $relation);
    public function insertMultiple(array $data);
    public function when($value, callable $callback);
    public function pushCriteria(CriteriaInterface $criteriaInterface): self;
}
