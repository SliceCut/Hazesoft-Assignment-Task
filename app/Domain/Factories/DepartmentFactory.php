<?php
namespace App\Domain\Factories;

use App\Domain\Abstracts\FactoryAbstract;
use App\Domain\Helpers\StringNullToInteger;
use App\Domain\ObjectValues\DepartmentObjectValue;

class DepartmentFactory extends FactoryAbstract
{
    public static function make(array $data): DepartmentObjectValue
    {
        return new DepartmentObjectValue(
            StringNullToInteger::make($data['id'] ?? null),
            $data['company_id'],
            $data['name'],
        );
    }
}