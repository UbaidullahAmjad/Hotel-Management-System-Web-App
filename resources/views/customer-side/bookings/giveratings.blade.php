@extends('layouts.customer-layout')

<style>
    .card{
        padding: 14px;
    }
</style>
@section('content')

<div class="page" style="margin-top: 100px;">
   <div class="page-main h-100">
		<div class="app-content">
        <div class="container">
        <h3>Give Ratings</h3>
            <div class="card">

                    <form action="{{ route('give-review',$id) }}" method="POST">

                        {{ csrf_field() }}







                                    <div>
                                            <textarea name="comments" class="form-control" placeholder="write your review" rows="5" cols="40" required="true"></textarea>
                                        </div>
                                        <div class="rating">
                                            <input id="input-1" name="rate" class="rating rating-loading" data-min="0" data-max="5" data-step="1" value="" data-size="xs">
                                            <input type="hidden" name="id" required="" value="">
                                            <br/>
                                            <div>

                                        </div>

                            <button type="submit" class="btn btn-success">
                                Submit
                            </button>



                    </form>



                </div>

            </div>

        </div>

    </div>

</div>



<script type="text/javascript">

    $("#input-id").rating();

</script>

@endsection