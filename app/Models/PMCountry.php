<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PMCountry extends Model
{
    use HasFactory;

    protected $table = "pm_countries";

    protected $fillable = ['country_name','country_code','cc','in_person','bank_transfer','percentage_upfront','percentage_arrival'];
}
