<?php
namespace App\Domain\Factories;

use App\Domain\Abstracts\FactoryAbstract;
use App\Domain\Helpers\StringNullToInteger;
use App\Domain\ObjectValues\CompanyObjectValue;

class CompanyFactory extends FactoryAbstract
{
    public static function make(array $data): CompanyObjectValue
    {
        return new CompanyObjectValue(
            StringNullToInteger::make($data['id'] ?? null),
            $data['name'],
            $data['email'],
            $data['location'],
            $data['contact_number'],
        );   
    }
}