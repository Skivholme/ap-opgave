<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name', 'email'];

    public function workshop(){
        return $this->belongsToMany(Workshop::class); 
    }

    public function employeeFunction(){
        return $this->hasOne(EmployeeFunction::class, 'id', 'function_id');
    }

    public function employeeTitle(){
        return $this->hasOne(EmployeeTitle::class, 'id', 'title_id');
    }
}
