<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PMCoupon extends Model
{
    use HasFactory;

    protected $table = "pm_promotional";

    protected $fillable = ['coupon','coupon_price1','coupon_price2','valid','enable','cc','in_person','bank_transfer','percentage_upfront','percentage_arrival'];
}
