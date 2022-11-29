<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['name','price1','price2','description','person_price1','person_price2','flat_price1','flat_price2'];

    public function packages(){
        return $this->hasMany('App\Models\Package');
    }
}
