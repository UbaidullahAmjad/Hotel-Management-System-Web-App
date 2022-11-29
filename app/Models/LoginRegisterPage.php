<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginRegisterPage extends Model
{
    use HasFactory;

    protected $table = 'logreg_page';

    public $fillable = ['login','register','email','pass','rem_me','not_reg_yet','reg_here','name','c_pass','h_acc','log_now',

    'login1','register1','email1','pass1','rem_me1','not_reg_yet1','reg_here1','name1','c_pass1','h_acc1','log_now1'];
}
