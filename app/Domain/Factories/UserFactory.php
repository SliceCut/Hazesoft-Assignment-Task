<?php

namespace App\Domain\Factories;

use App\Domain\Abstracts\FactoryAbstract;
use App\Domain\Helpers\StringNullToInteger;
use App\Domain\ObjectValues\UserObjectValue;

class UserFactory extends FactoryAbstract
{
    public static function make(array $data): UserObjectValue
    {
        return new UserObjectValue(
            StringNullToInteger::make($data['id'] ?? null),
            $data['name'],
            $data['email'],
            $data['password']
        );
    }
}
