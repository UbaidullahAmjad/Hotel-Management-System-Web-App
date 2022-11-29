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
            <h2 class="mb-5 ml-5 mt-5">Edit Home Page Text</h2>

            <form id="frm" action="{{ route('setting.update.home', $setting->id) }}" enctype="multipart/form-data" class="mt-5 ml-5" method="POST">


            @csrf
            <div class="row">
                <div class="col-md-6">
                    <h2>In French</h2>
                    <div class="form-group">
                        <label for="">Select Adult text</label>
                        <input type="text" name="adults" value="{{ $setting->adult }}" class="form-control" >
                        <label for="">Select Child1 text</label>
                        <input type="text" name="child1" value="{{ $setting->child1 }}" class="form-control" >
                        <label for="">Select Child2 text</label>
                        <input type="text" name="child2" value="{{ $setting->child2 }}" class="form-control" >
                        <label for="">Search Button Text</label>
                        <input type="text" name="search_btn_text" value="{{ $setting->s_btn }}" class="form-control" >
                        <label for="">Search Result Text</label>
                        <input type="text" name="search_res_text" value="{{ $setting->search_result }}" class="form-control" >
                        <label for="">Invoice Text</label>
                        <input type="text" name="invoice" value="{{ $setting->invoice }}" class="form-control" >
                        <label for="">Date From Text</label>
                        <input type="text" name="datefrom" value="{{ $setting->datefrom }}" class="form-control" >
                        <label for="">Date To Text</label>
                        <input type="text" name="dateto" value="{{ $setting->dateto }}" class="form-control" >
                        <label for="">No of Days Text</label>
                        <input type="text" name="n_days" value="{{ $setting->n_days }}" class="form-control" >
                        <label for="">No of beds Text</label>
                        <input type="text" name="n_beds" value="{{ $setting->n_beds }}" class="form-control" >
                        <label for="">Choose Package Text</label>
                        <input type="text" name="c_pack" value="{{ $setting->c_pack }}" class="form-control" >
                        <label for="">Total Text</label>
                        <input type="text" name="total" value="{{ $setting->total }}" class="form-control" >
                        <label for="">Price Per Person Per Night Text</label>
                        <input type="text" name="ppn" value="{{ $setting->ppn }}" class="form-control" >
                        <label for="">Excluding Taxes & Fees Text</label>
                        <input type="text" name="etax" value="{{ $setting->etax }}" class="form-control" >

                    </div>
                </div>
                <div class="col-md-6">
                    <h2>In Other Language</h2>
                    <div class="form-group">
                        <label for="">Select Adult text</label>
                        <input type="text" name="adults1" value="{{ $setting->adult1 }}" class="form-control" >
                        <label for="">Select Child1 text</label>
                        <input type="text" name="child11" value="{{ $setting->child11 }}" class="form-control" >
                        <label for="">Select Child2 text</label>
                        <input type="text" name="child22" value="{{ $setting->child22 }}" class="form-control" >
                        <label for="">Search Button Text</label>
                        <input type="text" name="search_btn_text1" value="{{ $setting->s_btn1 }}" class="form-control" >
                        <label for="">Search Result Text</label>
                        <input type="text" name="search_res_text1" value="{{ $setting->search_result1 }}" class="form-control" >
                        <label for="">Invoice Text</label>
                        <input type="text" name="invoice1" value="{{ $setting->invoice1 }}" class="form-control" >
                        <label for="">Date From Text</label>
                        <input type="text" name="datefrom1" value="{{ $setting->datefrom1 }}" class="form-control" >
                        <label for="">Date To Text</label>
                        <input type="text" name="dateto1" value="{{ $setting->dateto1 }}" class="form-control" >
                        <label for="">No of Days Text</label>
                        <input type="text" name="n_days1" value="{{ $setting->n_days1 }}" class="form-control" >
                        <label for="">No of beds Text</label>
                        <input type="text" name="n_beds1" value="{{ $setting->n_beds1 }}" class="form-control" >
                        <label for="">Choose Package Text</label>
                        <input type="text" name="c_pack1" value="{{ $setting->c_pack1 }}" class="form-control" >
                        <label for="">Total Text</label>
                        <input type="text" name="total1" value="{{ $setting->total1 }}" class="form-control" >
                        <label for="">Price Per Person Per Night Text</label>
                        <input type="text" name="ppn1" value="{{ $setting->ppn1 }}" class="form-control" >
                        <label for="">Excluding Taxes & Fees Text</label>
                        <input type="text" name="etax1" value="{{ $setting->etax1 }}" class="form-control" >

                    </div>
                </div>

                    <div class="form-group mt-5">
                            <span><button type="submit" id="su" type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Save </button></span>&nbsp;&nbsp;
                    </div>



            </div>

@endsection