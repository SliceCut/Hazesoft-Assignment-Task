<?php
namespace App\Domain\Abstracts;

use Illuminate\Database\Eloquent\Builder;

interface CriteriaInterface
{
    public function apply(Builder $query): Builder;
}