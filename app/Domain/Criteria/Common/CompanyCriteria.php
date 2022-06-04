<?php

namespace App\Domain\Criteria\Common;

use App\Domain\Abstracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Builder;

class CompanyCriteria implements CriteriaInterface
{
    private $company_id;

    public function __construct($company_id)
    {
        $this->company_id = $company_id;
    }

    public function apply(Builder $query): Builder
    {
        return $query->where('company_id', $this->company_id);
    }
}
