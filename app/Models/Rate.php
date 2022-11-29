<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;
    protected $fillable=['room_id','start_date','end_date','package_id',
    'price_per_night1',
    'non_refundable1',
    'modifiable1',
    'prepayment1',
    'no_advance1',
    'price_per_night2',
    'non_refundable2',
    'modifiable2',
    'prepayment2',
    'no_advance2'];


    public function room()
    {
        return $this->belongsTo(Room::class , 'room_id');
    }
    public function package()
    {
        return $this->belongsTo(Package::class , 'package_id');
    }
}
