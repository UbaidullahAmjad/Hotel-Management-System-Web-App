<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use willvincent\Rateable\Rateable;

class Confirmation extends Model
{
    use HasFactory;

    protected $table = "confirmation_page";

    protected $fillable = ['invoice','ordr','u_info','u_email','frm','too','p_m','o_date','o_sum','total','tax','t_amount','price','a_pay','p_on_arival','adult','child1','child2','c_policy','thank_msg',

    'invoice1','ordr1','u_info1','u_email1','frm1','too1','p_m1','o_date1','o_sum1','total1','tax1','t_amount1','price1','a_pay1','p_on_arival1','adult1','child11','child22','c_policy1','thank_msg1'];


}
