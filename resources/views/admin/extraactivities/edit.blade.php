@extends('layouts.admin-layout')

@section('content')
<style>

    .card{
        position: inherit !important;
        padding: 14px;
    }
    #price{
        border: 1px solid lightgrey;
    font-weight: 400;
    font-size: 16px;
}

</style>
<div class="page">
   <div class="page-main h-100">
		<div class="app-content">
            <div class="error-message">
            @if($errors->any())
            {{ implode('', $errors->all(':message')) }}
            @endif
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
				@endif
            </div>

        <div class="container" style="margin-top: 50px;">
            <div class="card">
            <h2 class="mb-5 ml-5 mt-5">Edit Activity</h2>

            <form id="frm" action="{{ route('activities.update',$activity->id) }}" enctype="multipart/form-data" class="mt-5 ml-5" method="POST">
            @csrf
            @Method('PUT')
            <div class="row">
                <div class="col-12">
                <div class="form-group">
                                    <label for="image">Image</label>
                                    <input type="file" class="dropify" data-default-file="{{ asset('/storage/'. $activity->image) }}" data-height="180" name="image" id="image" />
                                </div>
                    
                    <div class="form-group">
                        <label for="name">Title</label>
                        <input type="text" class="form-control" name="title" id="title" value="{{ $activity->title }}"  required>
                    </div>
                    <!-- <div class="form-group">
                        <label for="name">Sub Title</label>
                        <input type="text" class="form-control" name="subtitle" id="subtitle" value="{{ $activity->subtitle }}"  required>
                    </div> -->
                    <div class="form-group">
                        <label for="name">Description</label>
                        <textarea class="form-control" name="description" id="description"   required>{{ $activity->title }}</textarea>
                        <script src="//cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>

                                    <script>
                                        CKEDITOR.replace('description', {
                                            filebrowserUploadUrl: "",
                                            filebrowserUploadMethod: 'form'
                                        });
                                    </script>
                    </div>
                    <div class="form-group">
                        <label for="name">Maximum Children</label>
                        <input type="number" min="1" class="form-control" value="{{ $activity->max_child }}" name="max_child" id="max_child"  required>
                    </div>
                    <div class="form-group">
                        <label for="name">Maximum Adults</label>
                        <input type="number" min="1" class="form-control" value="{{ $activity->max_adults }}" name="max_adults" id="max_adults"  required>
                    </div>
                    
                    <div class="form-group">
                        <label for="name">Price1 (€)</label>
                        <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">€</span>
                                        </div>
                                        <input type="text" class="form-control" value="{{ $activity->price1 }}" name="price1" id="price1"  required>

                                    </div>
                    </div>
                    <div class="form-group">
                        <label for="name">Price2 (TND)</label>
                        <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">TND</span>
                                        </div>
                                        <input type="text" class="form-control" value="{{ $activity->price2 }}" name="price2" id="price2"  required>

                                    </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="name">Days</label>
                                <select name="day" id="day" class="form-control">
                                    @for($i = 0;$i <= 10; $i++)
                                    @if($activity->days == $i)
                                    <option value="{{$i}}" selected>{{$i}}</option>
                                    @else
                                    <option value="{{$i}}">{{$i}}</option>
                                    @endif
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="name">Hours</label>
                                <select name="hours" id="hours" class="form-control">
                                @for($i = 1;$i <= 24; $i++)
                                    @if($activity->hours == $i)
                                    <option value="{{$i}}" selected>{{$i}}</option>
                                    @else
                                    <option value="{{$i}}">{{$i}}</option>
                                    @endif
                                @endfor
                                    
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="name">Minutes</label>
                                <select name="minutes" id="minutes" class="form-control">
                                    @for($i = 1;$i <= 60; $i++)
                                        @if($activity->minutes == $i)
                                        <option value="{{$i}}" selected>{{$i}}</option>
                                        @else
                                        <option value="{{$i}}">{{$i}}</option>
                                        @endif
                                    @endfor
                                    
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="">Total Duration</label>
                               
                                    <input type="text" name="total" id="total" value="{{$activity->total}}" class="form-control" readonly>
                                
                            </div>
                        </div>
                        

                    </div>








                    <div class="form-group mt-5">
                            <span><button type="submit" id="su" type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Save </button></span>&nbsp;&nbsp;
                    </div>

                </div>

            </div>
            <script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
      var h = 0;
      var m = 0;
      var d = 0;
      var k = 0;
      var j = 0;

      $('#day').on('change', function() {
        d = this.value;
        if(m != 0 && h != 0){
            var dd = d;
                var ddd = Math.floor(h/1440);
                var mmm = Math.floor(m/86400);
                
                if(ddd == 0){
                    if(h%24 == 0){
                        ddd = 0;
                        d= parseInt(d)+parseInt(1);
                        k=1;
                    }else{
                        ddd = h;
                        if(k==1){
                            d= parseInt(d)-parseInt(1);
                            k=0;
                        }
                        
                    }
                }

                if(mmm == 0){
                    if(m%60 == 0){
                        mmm = 0;
                        h= parseInt(h)-parseInt(1);
                        j=1;
                    }else{
                        mmm = m;
                        if(j==1){
                            h= parseInt(h)+parseInt(1);
                            j=0;
                        }
                        
                    }
                }
                
                var total = d + " D   "+ ddd+ " H    " + mmm + " M";
                $('#total').val(total);
                
            }
        });
        $('#hours').on('change', function() {
        h = this.value;
        if(d != 0 && m != 0){
            
            var dd = d;
                var ddd = Math.floor(h/1440);
                var mmm = Math.floor(m/86400);
                if(ddd == 0){
                    if(h%24 == 0){
                        ddd = 0;
                        d= parseInt(d)+parseInt(1);
                        k=1;
                    }else{
                        ddd = h;
                        if(k==1){
                            d= parseInt(d)-parseInt(1);
                            k=0;
                        }
                        
                    }
                }
                if(mmm == 0){
                    if(m%60 == 0){
                        mmm = 0;
                        h= parseInt(h)-parseInt(1);
                        j=1;
                    }else{
                        mmm = m;
                        if(j==1){
                            h= parseInt(h)+parseInt(1);
                            j=0;
                        }
                        
                    }
                }
                var total = d + " D   "+ ddd+ " H    " + mmm + " M";

                $('#total').val(total);

                
            }
        });
        $('#minutes').on('change', function() {
        m = this.value;
            if(d != 0 && h != 0){
                
                var dd = d;
                var ddd = Math.floor(h/1440);
                var mmm = Math.floor(m/86400);
                if(ddd == 0){
                    if(h%24 == 0){
                        ddd = 0;
                        d= parseInt(d)+parseInt(1);
                        k=1;
                    }else{
                        ddd = h;
                        if(k==1){
                            d= parseInt(d)-parseInt(1);
                            k=0;
                        }
                        
                    }
                }
                if(mmm == 0){
                    if(m%60 == 0){
                        mmm = 0;
                        h= parseInt(h)-parseInt(1);
                        j=1;
                    }else{
                        mmm = m;
                        if(j==1){
                            h= parseInt(h)+parseInt(1);
                            j=0;
                        }
                        
                    }
                }
                var total = d + " D   "+ ddd+ " H    " + mmm + " M";
               

                $('#total').val(total);
                
            }
        });

        
    // $("#max_people").focusout(function(){
    //     var c = $('#max_child').val();
    //     var a = $('#max_adults').val();
    //     var p = $('#max_people').val();


    //     if(c != '' && a !=''){
    //         if( (parseInt(a) + parseInt(c)) <= parseInt(p) ){
    //             Swal.fire({
    //                 icon: 'success',
    //                 title: 'Great...',
    //                 text: 'Data is correct',

    //             })
    //         }else{
    //             Swal.fire({
    //                 icon: 'error',
    //                 title: 'Oops...',
    //                 text: 'Sum of Child and Adult should be less or equal to People',

    //             })
    //                 document.getElementById('max_child').value = '';
    //                 document.getElementById('max_adults').value = '';
    //                 document.getElementById('max_people').value = '';


    //         }
    //     }else{

    //         Swal.fire({
    //                 icon: 'error',
    //                 title: 'Oops...',
    //                 text: 'Max child and Max adults can not be null',

    //             })

    //             document.getElementById('max_child').value = '';
    //                 document.getElementById('max_adults').value = '';
    //                 document.getElementById('max_people').value = '';
    //     }

    // });
 </script>

@endsection