@extends('layouts.admin-layout')

@section('content')
<style>
    .card {
        position: inherit !important;
        padding: 14px;
    }
</style>
<div class="page">
    <div class="page-main h-100">
        <div class="app-content">
            <div class="error-message">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
                @endif
            </div>

            <div class="container" style="margin-top: 50px;">
                <div class="card">
                    <h2 class="mb-5 ml-5 mt-5">Edit Room</h2>
                    @foreach($errors->all() as $error)
                    <div class="alert alert-danger">{{ $error }}</div>
                    @endforeach
                    <form id="frm" action="{{ url('rooms/'.$room->id) }}" enctype="multipart/form-data" class="mt-5 ml-5" method="POST">
                        {{ method_field('PUT') }}

                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Room Name</label>
                                    <input type="text" class="form-control" value="{{ $room->name }}" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>No. of Beds</label>
                                    <input type="text" class="form-control" value="{{ $room->no_of_beds }}" name="no_of_beds" required>
                                </div>
                            </div>
                            <div class="col-12">
                                
                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <input type="file" class="dropify" data-default-file="{{ asset('/storage/'. $room->image) }}" data-height="180" name="image" id="image" />
                                </div>
                                

                                <div class="form-group">
                                    <label for="active">Active</label>
                                    <select name="active" id="active" class="form-control" required>
                                       
                                        @if($room->active == 0)
                                        <option value="{{$room->active}}" selected>No</option>
                                        <option value="1">Yes</option>
                                        @elseif($room->active == 1)
                                        <option value="{{$room->active}}" selected>Yes</option>
                                        <option value="0">No</option>
                                        @endif
                                        
                                        
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="facilities">Facilities</label>
                                    <br>
                                    @php
                                    $selected_facilities=App\Models\RoomFacility::where('room_id',$room->id)->pluck('facility_id')->toArray();
                                    @endphp
                                    @foreach($facilities as $facility)
                                    @if(in_array($facility->id , $selected_facilities))
                                    <input type="checkbox" name="facilities[]" value="{{$facility->id}}" checked>
                                    @elseif(!in_array($facility->id , $selected_facilities))
                                    <input type="checkbox" name="facilities[]" value="{{$facility->id}}">
                                    @endif
                                    {{$facility->title}} <br><br>

                                    @endforeach


                                </div>



                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" required class="form-control" id="description" cols="100" rows="4">{{$room->description}}</textarea>
                                    <script src="//cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>

                                    <script>
                                        CKEDITOR.replace('description', {
                                            filebrowserUploadUrl: "",
                                            filebrowserUploadMethod: 'form'
                                        });
                                    </script>
                                </div>

                                <div class="form-group">
                                    <label for="">Room detail</label><br><br>
                                    <div class="row">

                                        <div class="col-md-4">
                                        Maximum children
                                        </div>
                                        <div class="col-md-4">
                                        Maximum adults
                                        </div>
                                        <div class="col-md-4">
                                        Number of rooms
                                        </div>
                                        <div class="col-md-4">
                                        <input class="form-control" type="number" min="1" max="100" id="max_child" name="max_child" value="{{$room->max_child}}">
                                        </div>
                                        <div class="col-md-4">
                                        <input class="form-control" type="number" min="1" max="100" id="max_adults" name="max_adults" value="{{$room->max_adults}}">
                                        </div>
                                        <div class="col-md-4">
                                        <input class="form-control" type="number" min="1" max="100" id="no_of_rooms" name="no_of_rooms" value="{{$room->no_of_rooms}}">
                                        </div>
                                           
                                    </div>


                                </div>





                                <div class="form-group">
                                    <label for="onarrival">Standard Price (€)</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">€</span>
                                        </div>
                                        <input type="number" min="1" class="form-control" name="price1" id="price1" value="{{$room->price1}}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="onarrival">Standard Price (TND)</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">TND</span>
                                        </div>
                                        <input type="number" min="1" class="form-control" name="price2" id="price2" value="{{$room->price2}}" required>
                                    </div>
                                </div>


                                <div class="form-group mt-5">
                                    <span><button type="submit" id="su" type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Save </button></span>&nbsp;&nbsp;
                                </div>

                            </div>

                        </div>

                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

                        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
                        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                        <script>
                            $("#max_people").focusout(function() {
                                var c = $('#max_child').val();
                                var a = $('#max_adults').val();
                                var p = $('#max_people').val();


                                if (c != '' && a != '') {
                                    if ((parseInt(a) + parseInt(c)) <= parseInt(p)) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Great...',
                                            text: 'Data is correct',

                                        })
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: 'Sum of Child and Adult should be less or equal to People',

                                        })
                                        document.getElementById('max_child').value = '';
                                        document.getElementById('max_adults').value = '';
                                        document.getElementById('max_people').value = '';


                                    }
                                } else {

                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Max child and Max adults can not be null',

                                    })

                                    document.getElementById('max_child').value = '';
                                    document.getElementById('max_adults').value = '';
                                    document.getElementById('max_people').value = '';
                                }

                            });

                            imgInp.onchange = evt => {
                                const [file] = imgInp.files
                                if (file) {
                                    blah.src = URL.createObjectURL(file)
                                }
                            }
                        </script>



                        @endsection