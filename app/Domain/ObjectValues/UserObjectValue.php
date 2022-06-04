<?php

namespace App\Domain\ObjectValues;

use Illuminate\Support\Facades\Hash;

class UserObjectValue
{
    public ?int $id;
    public string $name;
    public string $email;
    public string $password;

    public function __construct(
        ?int $id,
        string $name,
        string $email,
        string $password
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public function toSql()
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password)
        ];
    }
}
