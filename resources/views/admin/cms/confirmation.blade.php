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
            <h2 class="mb-5 ml-5 mt-5">Edit Confirmation Page Text</h2>

            <form id="frm" action="{{ route('setting.update.confirm',$setting->id) }}" enctype="multipart/form-data" class="mt-5 ml-5" method="POST">


            @csrf
            <div class="row">
                <div class="col-md-6">
                <h2>In French</h2>

                    <div class="form-group">
                        <label for="">Invoice text</label>
                        <input type="text" name="invoice" value="{{ $setting->invoice  }}" class="form-control" >
                        <label for="">Order text</label>
                        <input type="text" name="ordr" value="{{ $setting->ordr  }}" class="form-control" >
                        <label for="">User Info text</label>
                        <input type="text" name="u_info" value="{{ $setting->u_info  }}" class="form-control" >
                        <label for="">User Email text</label>
                        <input type="text" name="u_email" value="{{ $setting->u_email  }}" class="form-control" >
                        <label for="">Date From text</label>
                        <input type="text" name="frm" value="{{ $setting->frm }}" class="form-control" >
                        <label for="">Date To text</label>
                        <input type="text" name="too" value="{{ $setting->too  }}" class="form-control" >
                        <label for="">Payment Method text</label>
                        <input type="text" name="p_m" value="{{ $setting->p_m  }}" class="form-control" >
                        <label for="">Order Date text</label>
                        <input type="text" name="o_date" value="{{ $setting->o_date }}" class="form-control" >
                        <label for="">Order Summary text</label>
                        <input type="text" name="o_sum" value="{{ $setting->o_sum  }}" class="form-control" >
                        <label for="">Total Amount text</label>
                        <input type="text" name="total" value="{{ $setting->total  }}" class="form-control" >
                        <label for="">Tax text</label>
                        <input type="text" name="tax" value="{{ $setting->tax  }}" class="form-control" >
                        <label for="">Amount text</label>
                        <input type="text" name="t_amount" value="{{ $setting->t_amount  }}" class="form-control" >
                        <label for="">Price in Order Summary Table text</label>
                        <input type="text" name="price" value="{{ $setting->price  }}" class="form-control" >
                        <label for="">Advance Pay text</label>
                        <input type="text" name="a_pay" value="{{ $setting->a_pay  }}" class="form-control" >
                        <label for="">Pay on Arrival text</label>
                        <input type="text" name="p_on_arival" value="{{ $setting->p_on_arival  }}" class="form-control" >
                        <label for="">Adult text</label>
                        <input type="text" name="adult" value="{{ $setting->adult  }}" class="form-control" >
                        <label for="">Child1 text</label>
                        <input type="text" name="child1" value="{{ $setting->child1  }}" class="form-control" >
                        <label for="">Child2 text</label>
                        <input type="text" name="child2" value="{{ $setting->child2  }}" class="form-control" >

                        <label for="">Cancellation Policy text</label>
                        <input type="text" name="c_p" value="{{ $setting->c_policy  }}" class="form-control" >
                        <label for="">Thank Message text</label>
                        <input type="text" name="thank_msg" value="{{ $setting->thank_msg  }}" class="form-control" >


                    </div>


                </div>

                <div class="col-md-6">
                <h2>In Other Language</h2>

                    <div class="form-group">
                        <label for="">Invoice text</label>
                        <input type="text" name="invoice1" value="{{ $setting->invoice1  }}" class="form-control" >
                        <label for="">Order text</label>
                        <input type="text" name="ordr1" value="{{ $setting->ordr1  }}" class="form-control" >
                        <label for="">User Info text</label>
                        <input type="text" name="u_info1" value="{{ $setting->u_info1  }}" class="form-control" >
                        <label for="">User Email text</label>
                        <input type="text" name="u_email1" value="{{ $setting->u_email1  }}" class="form-control" >
                        <label for="">Date From text</label>
                        <input type="text" name="frm1" value="{{ $setting->frm1 }}" class="form-control" >
                        <label for="">Date To text</label>
                        <input type="text" name="too1" value="{{ $setting->too1  }}" class="form-control" >
                        <label for="">Payment Method text</label>
                        <input type="text" name="p_m1" value="{{ $setting->p_m1  }}" class="form-control" >
                        <label for="">Order Date text</label>
                        <input type="text" name="o_date1" value="{{ $setting->o_date1 }}" class="form-control" >
                        <label for="">Order Summary text</label>
                        <input type="text" name="o_sum1" value="{{ $setting->o_sum1  }}" class="form-control" >
                        <label for="">Total Amount text</label>
                        <input type="text" name="total1" value="{{ $setting->total1  }}" class="form-control" >
                        <label for="">Tax text</label>
                        <input type="text" name="tax1" value="{{ $setting->tax1  }}" class="form-control" >
                        <label for="">Amount text</label>
                        <input type="text" name="t_amount1" value="{{ $setting->t_amount1  }}" class="form-control" >
                        <label for="">Price in Order Summary Table text</label>
                        <input type="text" name="price1" value="{{ $setting->price1  }}" class="form-control" >
                        <label for="">Advance Pay text</label>
                        <input type="text" name="a_pay1" value="{{ $setting->a_pay1  }}" class="form-control" >
                        <label for="">Pay on Arrival text</label>
                        <input type="text" name="p_on_arival1" value="{{ $setting->p_on_arival1  }}" class="form-control" >
                        <label for="">Adult text</label>
                        <input type="text" name="adult1" value="{{ $setting->adult1  }}" class="form-control" >
                        <label for="">Child1 text</label>
                        <input type="text" name="child11" value="{{ $setting->child11  }}" class="form-control" >
                        <label for="">Child2 text</label>
                        <input type="text" name="child22" value="{{ $setting->child22  }}" class="form-control" >

                        <label for="">Cancellation Policy text</label>
                        <input type="text" name="c_p1" value="{{ $setting->c_policy1  }}" class="form-control" >
                        <label for="">Thank Message text</label>
                        <input type="text" name="thank_msg1" value="{{ $setting->thank_msg1  }}" class="form-control" >


                    </div>


                </div>




                    <div class="form-group mt-5">
                            <span><button type="submit" id="su" type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Save </button></span>&nbsp;&nbsp;
                    </div>



            </div>

@endsection