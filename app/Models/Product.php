<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'proteins', 'fats', 'carbs', 'ccal', 'meas_value', 'chpu'];
}
