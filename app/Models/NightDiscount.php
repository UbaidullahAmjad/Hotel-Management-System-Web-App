<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NightDiscount extends Model
{
    use HasFactory;

    protected $table = "night_discounts";

    protected $fillable = ['discount1', 'discount2', 'datefrom', 'dateto'];
}
