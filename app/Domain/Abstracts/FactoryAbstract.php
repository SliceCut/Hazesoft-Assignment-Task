<?php
namespace App\Domain\Abstracts;

abstract class FactoryAbstract {
    abstract public static function make(array $data): mixed;
}