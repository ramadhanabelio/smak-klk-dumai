<?php

namespace App\Models;

use App\Models\User;
use App\Models\Department;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'user_id',
        'department_id',
        'employee_number',
        'name',
        'phone_number',
        'place_of_birth',
        'date_of_birth',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
