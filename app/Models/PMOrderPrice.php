<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PMOrderPrice extends Model
{
    use HasFactory;

    protected $table = "pm_orderprices";

    protected $fillable = ['euro_price_1','euro_price_2','tnd_price_1','tnd_price_2','cc','in_person','bank_transfer'];
}
