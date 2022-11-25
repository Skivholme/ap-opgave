<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'street', 'street_no', 'zipcode', 'country_code'];

    public function employee(){
        return $this->belongsToMany(Employee::class); 
    }
}
