<?php

namespace App\Domain\ObjectValues;

class DepartmentObjectValue
{
    public ?int $id;
    public int $company_id;
    public string $name;

    public function __construct(
        ?int $id,
        int $company_id,
        string $name
    ) {
        $this->id = $id;
        $this->company_id = $company_id;
        $this->name = $name;
    }

    public function toSql(): array
    {
        return [
            'id' => $this->id,
            'company_id' => $this->company_id,
            'name' => $this->name
        ];
    }
}
