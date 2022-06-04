<?php

namespace App\Http\Resources\Api\V1\Department;

use App\Http\Resources\Api\V1\Company\CompanyResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'company_id' => $this->id,
            'company' => CompanyResource::make($this->whenLoaded('company'))
        ];
    }
}
