<?php

namespace App\Domain\Repositories;

use App\Domain\Abstracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Arr;
use InvalidArgumentException;

abstract class BaseRepository implements BaseRepositoryInterface
{
    public $model;

    protected $defaultRelations = [];
    protected $filters = [];

    public function  __construct($model)
    {
        $this->model = $model;
        $this->withRelations($this->defaultRelations);
        $this->applyFilters();
    }

    public function queryBuilder(): Builder
    {
        return $this->model;
    }

    /**
     * find a model by id
     *@return self
     */

    public function withRelations( array $relation): self
    {
        $this->model = $this->model->with($relation);
        return $this;
    }
    
    public function withCounts(array $counts): self
    {
        $this->model = $this->model->withCount($counts);
        return $this;
    }

    public function exceptAttribute(string $attribute, array $data):self
    {
        $this->model = $this->model->whereNotIn($attribute, $data);
        return $this;
    }

    /**
     * Create Model
     *
     * @param array $params
     *
     * @return Model
     * @throws InvalidArgumentException
     */
    public function create(array $params)
    {
        try {
            return $this->model->create($params);
        } catch (QueryException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }

    /**
     * Update the model
     *
     * @param array $params
     * @return bool
     */
    public function update($id, array $params): bool
    {
        $model = $this->findOneOrFail($id);
        return $model->update($params);
    }

    /**
     * Update the model
     *
     * @param int $id
     * @param array $params
     * @return Model
     */
    public function updateOrCreate(array $params)
    {
        return $this->model->updateOrCreate($params);
    }

    /**
     * Delete a model
     *
     * @return bool
     */
    public function delete($id): bool
    {
        $model = $this->findOneOrFail($id);
        return  $model->delete();
    }
    /**
     * @param string $id
     * @return mixed
     */
    public function findById($id)
    {
        return $this->model->find($id);
    }

    /**
     * @param  $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findOneOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * find a model by id
     * @return Model
     */

    public function all(array $select = ['*'], string $order = 'id', string $sort = 'desc')
    {
        try {
            return $this->model->select($select)->orderBy($order, $sort)->get();
        } catch (QueryException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }

    /**
     * @param array $data
     * @return Collection
     */
    public function getAllBy(array $data)
    {
        return $this->model->where($data)->get();
    }
    /**
     * @param array $data
     * @return Builder
     */
    public function where(Builder $query, array $data): Builder
    {
        return $query->where($data);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function findOneBy(array $data)
    {
        return $this->model->where($data)->first();
    }

    public function paginate(array $select = ['*'], int $limit = 20, string $order = 'id', string $sort = 'desc')
    {
        if (!$select == ['*']) {
            $this->model->select($select);
        }
        return $this->model
            ->orderBy($order, $sort)
            ->paginate($limit)
            ->appends(request()->all());
    }

    public function loadRelations(array $relation)
    {
        return $this->model->load('settings');
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function insertMultiple(array $data)
    {
        return $this->model->insert($data);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function when($value, callable $callback)
    {
        if ($value) {
            return  $callback($value, $this);
        }

        return $this;
    }

    public function pushCriteria(CriteriaInterface $criteriaInterface): self
    {
        $this->model = $criteriaInterface->apply($this->model);
        return $this;
    }

    private function applyFilters()
    {
        $filters = request()->all();

        foreach($filters as $filter => $value) {
            if(isset($this->filters[$filter])) {
                $resolver = $this->resolveFilter($filter, $value);
                if($resolver instanceof CriteriaInterface) {
                    $this->model = $resolver->apply($this->model); 
                } else {
                    throw new \Exception("Filter Criteria must be instance of ".CriteriaInterface::class);
                }
            }
        }
    }

    private function resolveFilter(string $filter, $value)
    {
        return new $this->filters[$filter]($value);
    }


}