@extends('layouts.admin-layout')

@section('content')
<style>

    .card{
        position: inherit !important;
        padding: 14px;
    }
</style>
<div class="page">
   <div class="page-main h-100">
		<div class="app-content">
            <div class="error-message">
            @if($errors->any())
            {{ implode('', $errors->all(':message')) }}
            @endif

            </div>

        <div class="container" style="margin-top: 50px;">
        @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
				@endif
            <div class="card">
            <h2 class="mb-5 ml-5 mt-5">Edit BookNow Page Text</h2>

            <form id="frm" action="{{ route('setting.update.booknow',$setting->id) }}" enctype="multipart/form-data" class="mt-5 ml-5" method="POST">


            @csrf
            <div class="row">
                <div class="col-md-6">
                    <h2>In French</h2>

                    <div class="form-group">
                        <label for="">Select Service text</label>
                        <input type="text" name="service" value="{{ $setting->s_service  }}" class="form-control" >
                        <label for="">Service Name text</label>
                        <input type="text" name="name" value="{{ $setting->s_name  }}" class="form-control" >
                        <label for="">Service Desc text</label>
                        <input type="text" name="desc" value="{{ $setting->s_des  }}" class="form-control" >
                        <label for="">Service Price text</label>
                        <input type="text" name="price" value="{{ $setting->s_price  }}" class="form-control" >
                        <label for="">Service Avail text</label>
                        <input type="text" name="avail" value="{{ $setting->s_avail }}" class="form-control" >
                        <label for="">Order Summary text</label>
                        <input type="text" name="o_sum" value="{{ $setting->order_sum  }}" class="form-control" >
                        <label for="">Coupon text</label>
                        <input type="text" name="coupon" value="{{ $setting->coupon  }}" class="form-control" >
                        <label for="">Apply Coupon text</label>
                        <input type="text" name="a_coupon" value="{{ $setting->a_coupon  }}" class="form-control" >
                        <label for="">De Apply Coupon text</label>
                        <input type="text" name="d_coupon" value="{{ $setting->d_coupon  }}" class="form-control" >
                        <label for="">Contact Info text</label>
                        <input type="text" name="c_info" value="{{ $setting->c_info  }}" class="form-control" >
                        <label for="">First Name text</label>
                        <input type="text" name="f_name" value="{{ $setting->f_name  }}" class="form-control" >
                        <label for="">Last Name text</label>
                        <input type="text" name="l_name" value="{{ $setting->l_name  }}" class="form-control" >
                        <label for="">Email text</label>
                        <input type="text" name="email" value="{{ $setting->email  }}" class="form-control" >
                        <label for="">Mobile Number text</label>
                        <input type="text" name="mob" value="{{ $setting->mob  }}" class="form-control" >
                        <label for="">Special Request text</label>
                        <input type="text" name="s_req" value="{{ $setting->s_req  }}" class="form-control" >
                        <label for="">Payment Method text</label>
                        <input type="text" name="pm" value="{{ $setting->c_p_method  }}" class="form-control" >
                        <label for="">In Person text</label>
                        <input type="text" name="in" value="{{ $setting->in_person  }}" class="form-control" >
                        <label for="">Pay By Bank text</label>
                        <input type="text" name="bt" value="{{ $setting->bt  }}" class="form-control" >
                        <label for="">Pay By Credit Card text</label>
                        <input type="text" name="cc" value="{{ $setting->cc  }}" class="form-control" >
                        <label for="">Terms and Condition text</label>
                        <input type="text" name="term" value="{{ $setting->term  }}" class="form-control" >
                        <label for="">Apply Policy text</label>
                        <input type="text" name="policy" value="{{ $setting->policy  }}" class="form-control" >
                        <label for="">Cancellation Policy text</label>
                        <input type="text" name="c_p" value="{{ $setting->c_policy  }}" class="form-control" >
                        <label for="">Complete Booking Button text</label>
                        <input type="text" name="c_b" value="{{ $setting->c_book  }}" class="form-control" >
                        <label for="">Order Number text</label>
                        <input type="text" name="o_n" value="{{ $setting->o_number  }}" class="form-control" >
                        <label for="">Order Price text</label>
                        <input type="text" name="o_p" value="{{ $setting->o_price  }}" class="form-control" >

                        <label for="">Date Range text</label>
                        <input type="text" name="d_r" value="{{ $setting->d_range  }}" class="form-control" >

                        <label for="">To text</label>
                        <input type="text" name="to" value="{{ $setting->to }}" class="form-control" >



                    </div>


                </div>

                <div class="col-md-6">
                    <h2>In Other Language</h2>

                    <div class="form-group">
                        <label for="">Select Service text</label>
                        <input type="text" name="service1" value="{{ $setting->s_service1  }}" class="form-control" >
                        <label for="">Service Name text</label>
                        <input type="text" name="name1" value="{{ $setting->s_name1  }}" class="form-control" >
                        <label for="">Service Desc text</label>
                        <input type="text" name="desc1" value="{{ $setting->s_des1  }}" class="form-control" >
                        <label for="">Service Price text</label>
                        <input type="text" name="price1" value="{{ $setting->s_price1  }}" class="form-control" >
                        <label for="">Service Avail text</label>
                        <input type="text" name="avail1" value="{{ $setting->s_avail1 }}" class="form-control" >
                        <label for="">Order Summary text</label>
                        <input type="text" name="o_sum1" value="{{ $setting->order_sum1  }}" class="form-control" >
                        <label for="">Coupon text</label>
                        <input type="text" name="coupon1" value="{{ $setting->coupon1  }}" class="form-control" >
                        <label for="">Apply Coupon text</label>
                        <input type="text" name="a_coupon1" value="{{ $setting->a_coupon1  }}" class="form-control" >
                        <label for="">De Apply Coupon text</label>
                        <input type="text" name="d_coupon1" value="{{ $setting->d_coupon1  }}" class="form-control" >
                        <label for="">Contact Info text</label>
                        <input type="text" name="c_info1" value="{{ $setting->c_info1  }}" class="form-control" >
                        <label for="">First Name text</label>
                        <input type="text" name="f_name1" value="{{ $setting->f_name1  }}" class="form-control" >
                        <label for="">Last Name text</label>
                        <input type="text" name="l_name1" value="{{ $setting->l_name1  }}" class="form-control" >
                        <label for="">Email text</label>
                        <input type="text" name="email1" value="{{ $setting->email1  }}" class="form-control" >
                        <label for="">Mobile Number text</label>
                        <input type="text" name="mob1" value="{{ $setting->mob1  }}" class="form-control" >
                        <label for="">Special Request text</label>
                        <input type="text" name="s_req1" value="{{ $setting->s_req1  }}" class="form-control" >
                        <label for="">Payment Method text</label>
                        <input type="text" name="pm1" value="{{ $setting->c_p_method1  }}" class="form-control" >
                        <label for="">In Person text</label>
                        <input type="text" name="in1" value="{{ $setting->in_person1  }}" class="form-control" >
                        <label for="">Pay By Bank text</label>
                        <input type="text" name="bt1" value="{{ $setting->bt1  }}" class="form-control" >
                        <label for="">Pay By Credit Card text</label>
                        <input type="text" name="cc1" value="{{ $setting->cc1  }}" class="form-control" >
                        <label for="">Terms and Condition text</label>
                        <input type="text" name="term1" value="{{ $setting->term1  }}" class="form-control" >
                        <label for="">Apply Policy text</label>
                        <input type="text" name="policy1" value="{{ $setting->policy1  }}" class="form-control" >
                        <label for="">Cancellation Policy text</label>
                        <input type="text" name="c_p1" value="{{ $setting->c_policy1  }}" class="form-control" >
                        <label for="">Complete Booking Button text</label>
                        <input type="text" name="c_b1" value="{{ $setting->c_book1  }}" class="form-control" >
                        <label for="">Order Number text</label>
                        <input type="text" name="o_n1" value="{{ $setting->o_number1  }}" class="form-control" >
                        <label for="">Order Price text</label>
                        <input type="text" name="o_p1" value="{{ $setting->o_price1  }}" class="form-control" >

                        <label for="">Date Range text</label>
                        <input type="text" name="d_r1" value="{{ $setting->d_range1  }}" class="form-control" >
                        <label for="">To text</label>
                        <input type="text" name="to1" value="{{ $setting->to1 }}" class="form-control" >


                    </div>


                </div>




                    <div class="form-group mt-5">
                            <span><button type="submit" id="su" type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Save </button></span>&nbsp;&nbsp;
                    </div>



            </div>

@endsection