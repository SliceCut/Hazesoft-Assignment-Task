<?php

namespace App\Domain\ObjectValues;

class CompanyObjectValue
{
    public ?int $id;
    public string $name;
    public string $email;
    public string $location;
    public string $contact_number;

    public function __construct(
        ?int $id,
        string $name,
        string $email,
        string $location,
        string $contact_number
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->location = $location;
        $this->contact_number = $contact_number;
    }

    public function toSql(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'location' => $this->location,
            'contact_number' => $this->contact_number,
        ];
    }
}
