<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildrenRate extends Model
{
    use HasFactory;
    protected $fillable=[
    'rate_id',
    'min_age',
    'max_age',
    'price1',
    'price2'
    ];
}
