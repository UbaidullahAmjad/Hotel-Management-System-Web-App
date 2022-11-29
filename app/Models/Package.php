<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Package extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['name', 'detail','active'];

    public function rooms(){
        return $this->hasMany('App\Models\Room','package_id','id');
    }

    public function services(){
        return $this->hasMany('App\Models\Service');
    }

//     public function packagesServices()
// {
//     return $this->belongsToMany('App\Models\Package', 'package_service',
//       'package_id', 'service_id');
// }

}
