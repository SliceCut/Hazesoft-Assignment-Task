<?php
namespace App\Domain\ObjectValues;

class EmployeeObjectValue
{
    public ?int $id;
    public int $company_id;
    public string $enroll_id;
    public string $email;
    public string $contact;
    public string $designation;

    public function __construct(
        ?int $id,
        int $company_id,
        string $name,
        string $enroll_id,
        string $email,
        string $contact,
        string $designation
    ){
        $this->id =$id;
        $this->company_id =$company_id;
        $this->name =$name;
        $this->email =$email;
        $this->enroll_id =$enroll_id;
        $this->contact =$contact;
        $this->designation =$designation;
    }

    public function toSql()
    {
        return [
            'company_id' => $this->company_id,
            'name' => $this->name,
            'enroll_id' => $this->enroll_id,
            'email' => $this->email,
            'contact' => $this->contact,
            'designation' => $this->designation,
        ];
    }
}