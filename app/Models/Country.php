<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    // mass assign attributes
    protected $fillable = ['country_name', 'capital_city'];
}
