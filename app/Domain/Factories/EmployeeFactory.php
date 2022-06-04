<?php
namespace App\Domain\Factories;

use App\Domain\Abstracts\FactoryAbstract;
use App\Domain\Helpers\StringNullToInteger;
use App\Domain\ObjectValues\EmployeeObjectValue;

class EmployeeFactory extends FactoryAbstract
{
    public static function make(array $data): EmployeeObjectValue
    {
        return new EmployeeObjectValue(
            StringNullToInteger::make($data['id'] ?? null),
            (int) $data['company_id'],
            $data['name'],
            $data['enroll_id'],
            $data['email'],
            $data['contact'],
            $data['designation'],
        );
    }
}