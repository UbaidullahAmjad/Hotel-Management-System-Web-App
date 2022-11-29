<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style>

    .card{
        position: inherit !important;
        padding: 14px;
    }
    tr th{
        background-color: #a29b91;
        color: white !important;
    }

    .heading{
        background-color: #a7947a;
        color: white;
        padding: 10px;
    }
</style>
</head>

<body>
<div class="page" style="margin-top: 100px;">
   <div class="page-main h-100">
		<div class="app-content">
            <div class="container">
                <div class="card">

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                    <h2>Dear Customer</h2>
                    <p>Your Booking has been confirmed and your booking number is  <b>{{$booking->booking_no}}</b></p>
                    <p>Thank you</p>

                   
                       
                   
                </div>
            </div>
        </div>
    </div>
</div>


</body>
</html>
