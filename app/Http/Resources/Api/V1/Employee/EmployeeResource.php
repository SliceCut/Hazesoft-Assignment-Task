<?php

namespace App\Http\Resources\Api\V1\Employee;

use App\Http\Resources\Api\V1\Company\CompanyResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=> $this->id,
            'company_id' => $this->company_id,
            'name' => $this->name,
            'enroll_id' => $this->enroll_id,
            'email' => $this->email,
            'contact' => $this->contact,
            'designation' => $this->designation,
            'company' => CompanyResource::make($this->whenLoaded('company')),
            'departments' => EmployeeDepartmentResource::collection($this->whenLoaded('departments'))
        ];
    }
}
