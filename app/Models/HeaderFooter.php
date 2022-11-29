<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use willvincent\Rateable\Rateable;

class HeaderFooter extends Model
{
    use HasFactory;

    protected $table = "header_footer";

    protected $fillable = ['logo','login','reg','imp_link','im_link_1','im_link_2','im_link_3','im_link_4','s_link','tel','fax','mail'

    ,'login1','reg1','imp_link1','im_link_11','im_link_22','im_link_33','im_link_44','s_link1','tel1','fax1','mail1'];


}
