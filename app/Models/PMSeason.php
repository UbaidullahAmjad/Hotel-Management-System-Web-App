<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PMSeason extends Model
{
    use HasFactory;

    protected $table = "pm_seasons";

    protected $fillable = ['date1','date2','cc','in_person','bank_transfer','percentage_upfront','percentage_arrival'];
}
