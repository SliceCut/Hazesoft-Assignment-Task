<?php

namespace App\Models;

use App\Models\Concerns\HasCompany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Employee extends Model
{
    use HasFactory;
    use HasCompany;

    protected $fillable = [
        'company_id',
        'name',
        'enroll_id',
        'email',
        'contact',
        'designation'
    ];

    public function departments(): BelongsToMany
    {
        return $this->belongsToMany(Department::class, 'employee_department', 'employee_id', 'department_id');
    }
}
