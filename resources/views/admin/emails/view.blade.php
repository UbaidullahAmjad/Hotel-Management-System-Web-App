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
            <h2 class="mb-5 mt-5">Email</h2>

            

           

            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="">Subject</label><br>
                        {{$email->subject}}
                    </div>
                    <div class="form-group">
                        <label for="">Message</label>
                        <textarea name="message" id="message" cols="30" rows="10" readonly>{{$email->message}}</textarea>
                        <script src="//cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>

                                    <script>
                                        CKEDITOR.replace('message', {
                                            filebrowserUploadUrl: "",
                                            filebrowserUploadMethod: 'form'
                                        });
                                    </script>
                    </div>


                    <div class="form-group mt-5">
                        <label for="Users">Users</label><br>
                        @php $user_ids = json_decode($email->users); @endphp
                        @foreach($user_ids as $id)
                        @php $user = App\Models\User::find($id) @endphp
                        <span class="badge badge-success">{{$user->name}}</span>
                        @endforeach
                    </div>

                    <div class="form-group mt-5">
                        
                        @php $user_ids = json_decode($email->users); @endphp
                       
                        <form action="{{route('resend')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="userids" value="{{ $email->users }}">
                            <input type="hidden" name="message" value="{{ $email->message }}">
                            <input type="hidden" name="subject" value="{{ $email->subject }}">

                            <button type="submit" class="btn btn-info"><i class="fa fa-paper-plane"></i> Re-Send</button>
                        </form>
                       
                    </div>

                </div>

            </div>
       

            
@endsection