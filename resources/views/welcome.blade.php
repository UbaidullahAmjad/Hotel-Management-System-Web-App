<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Hotel Booking System</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="img/favicon.ico" />
    <!-- CSS FILES -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/flexslider.css') }}">
    <link rel="stylesheet" href="{{ asset('css/prettyPhoto.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="{{ asset('css/selectordie.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/2035.responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mobiscroll.javascript.min.css')}}">
    <script src="{{ asset('js/mobiscroll.javascript.min.js')}}"></script>
    <script src="js/vendor/modernizr-2.8.3-respond-1.1.0.min.js"></script>
    <!-- Styles -->
    <style>

    </style>

    <style>
        body {
            /*font-family: 'Nunito', sans-serif;*/
        }

        div.p_detail {
            background-color: white;
            width: 270px;
            height: 110px;
            overflow: hidden;
    padding: 10px;
    word-wrap: break-word
        }
        /* room */
        div.r_detail {
            background-color: white;
            width: 259px;
            height: 110px;
            overflow: hidden;
    padding: 10px;
    word-wrap: break-word
        }

        .fixed-header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    /* background-color: black;
    color: white; */
}
.visible-title {
    visibility: visible;
}



    </style>


</head>
<script>




</script>
<body class="antialiased">

@php


$sett = App\Models\HeaderFooter::all();
    $set = $sett[0];

    $dat = session()->get('latlong');

    $response = Http::get('https://nominatim.openstreetmap.org/reverse?format=geojson&lat=36.7394816&lon=10.2039552');
    $str = $response->json()['features'][0]['properties']['address']['country_code'];


@endphp

@if($str == "tn")
    <div class="header">
        <div class="main-header" style="background-color: white;">
            <div class="container">
                <div class="row">
                    <div class="pull-left">
                        <div class="logo">
                            <a href="/"><img alt="Logo" src="{{ asset('/storage/'. $set->logo) }}"
                                    class="img-responsive" /></a>
                        </div>
                    </div>
                    <div class="pull-right">
                        <div class="pull-left">
                            <nav class="nav  fixed-top">

                                <ul id="navigate" class="sf-menu navigate">
                                    {{-- @role('Admin') --}}

                                    {{-- Google Language Translator  START --}}


                                        {{-- @endrole --}}

                                    </li>


                                    @if(auth()->user())
                                    @role('Customer')
                                    <li><a href="{{ route('customer-bookings') }}">Go to Bookings</a></li>
                                    @endrole
                                    @if (request()->is(url('complete-booking')))
                                    @role('Admin')
                                    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                    @endrole
                                    <li><a href="{{ route('do-logout') }}">Logout</a></li>
                                    @endif
                                    @else

                                    <li><a href="{{ route('login') }}" style="color: black;">{{$set->login}}</a></li>
                                    <li><a href="{{ route('register') }}" style="color: black;">{{$set->reg}}</a></li>

                                    @endif


                                </ul>
                            </nav>
                        </div>
                        <div class="pull-right">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @yield('content')




    <div class="footer margint40 foot">
        <div class="main-footer">
            <div class="container">
                <div class="row text-center">
                    <div class="col-lg-4 col-sm-2 footer-logo">
                        <img alt="Logo" src="{{ asset('/storage/'.$set->logo) }}" class="img-responsive" width="200"
                            height="200">
                    </div>
                    <div class="col-lg-4 col-sm-2 footer-logo">
                        <h4>{{$set->imp_link}}</h4>
                        <ul class="footer-links">
                                    <li><a href="https://www.djerbaplaza.com/fr/protocole-sanitaire/">{{$set->im_link_1}}</a></li>
									<li><a href="https://www.djerbaplaza.com/fr/termes-et-conditions/">{{$set->im_link_2}}</a></li>
									<li><a href="https://www.djerbaplaza.com/fr/politique-de-confidentialites/">{{$set->im_link_3}}</a></li>
									<li><a href="https://www.djerbaplaza.com/fr/politique-interieur-et-conditions-de-sejour/">{{$set->im_link_4}}</a></li>
									<!-- <li><a href="#">Tripadvisor</a></li> -->
                        </ul>
                    </div>
                    <div class="col-lg-4 col-sm-2 footer-logo">
                        <h4>{{$set->s_link}} </h4>
                        <ul class="footer-links">
                                <li><a href="tel:+216 75  731 230">{{$set->tel}}: +216 75  731 230</a> </li>
                                    <li><a href="tel:+216 75  732 708">{{ $set->fax }}: +216 75  732 708</a> </li>
                                    <li><a href="mailto:contact@djerbaplaza.com">{{ $set->mail }}</a></li>
								</ul>
                    </div>
                    <!-- <div class="col-lg-10 col-sm-10">
							<div class="col-lg-3 col-sm-3">

							</div>
							<div class="col-lg-3 col-sm-3">
								<h6>Contact </h6> -->
                    <!-- <ul class="footer-links">
									<li><a href="#">Error Page</a></li>
									<li><a href="#">About</a></li>
									<li><a href="#">Blog</a></li>
									<li><a href="#">Blog Single</a></li>
									<li><a href="#">Category Grid</a></li>
									<li><a href="#">Category List</a></li>
								</ul> -->
                    <!-- </div> -->
                    <!-- <div class="col-lg-3 col-sm-3">
								<h6>PAGES SITE</h6>
								<ul class="footer-links">
									<li><a href="#">Contact</a></li>
									<li><a href="#">Gallery</a></li>
									<li><a href="#">Dashboard Full Screen</a></li>
									<li><a href="#">Left Sidebar Page</a></li>
									<li><a href="#">Right Sidebar Page</a></li>
									<li><a href="#">Room Single</a></li>
									<li><a href="#">Under Construction</a></li>
								</ul>
							</div>
							<div class="col-lg-3 col-sm-3">
								<h6>CONTACT</h6>
								<ul class="footer-links">
									<li><p><i class="fa fa-map-marker"></i> Lorem ipsum dolor sit amet lorem Victoria 8011 Australia </p></li>
									<li><p><i class="fa fa-phone"></i> +61 3 8376 6284 </p></li>
									<li><p><i class="fa fa-envelope"></i> <a href="mailto:info@cplusoft.com">info@cplusoft.com</a></p></li>
								</ul>
							</div> -->
                    <!-- </div> -->
                </div>
            </div>
        </div>
        <div class="pre-footer">
            <div class="container">
                <div class="row">
                    <div class="pull-left">
                    <a href="https://www.djerbaplaza.com/fr/">@ DjerbaPlaza.com 2021</a>

                    </div>
                    <!-- <div class="pull-right">
                        <ul>
                            <li>
                                <p>CONNECT WITH US</p>
                            </li>
                            <li><a><img alt="Facebook" src="temp/orkut.png"></a></li>
                            <li><a><img alt="Tripadvisor" src="temp/tripadvisor.png"></a></li>
                            <li><a><img alt="Yelp" src="temp/hyves.png"></a></li>
                            <li><a><img alt="Twitter" src="temp/skype.png"></a></li>
                        </ul>
                    </div> -->
                </div>
            </div>
        </div>
    </div>


    @else
    <div class="header">
        <div class="main-header" style="background-color: white;">
            <div class="container">
                <div class="row">
                    <div class="pull-left">
                        <div class="logo">
                            <a href="/"><img alt="Logo" src="{{ asset('/storage/'. $set->logo) }}"
                                    class="img-responsive" /></a>
                        </div>
                    </div>
                    <div class="pull-right">
                        <div class="pull-left">
                            <nav class="nav  fixed-top">

                                <ul id="navigate" class="sf-menu navigate">
                                    {{-- @role('Admin') --}}

                                    {{-- Google Language Translator  START --}}


                                        {{-- @endrole --}}

                                    </li>


                                    @if(auth()->user())
                                    @role('Customer')
                                    <li><a href="{{ route('customer-bookings') }}">Go to Bookings</a></li>
                                    @endrole
                                    @if (request()->is(url('complete-booking')))
                                    @role('Admin')
                                    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                    @endrole
                                    <li><a href="{{ route('do-logout') }}">Logout</a></li>
                                    @endif
                                    @else

                                    <li><a href="{{ route('login') }}" style="color: black;">{{$set->login1}}</a></li>
                                    <li><a href="{{ route('register') }}" style="color: black;">{{$set->reg1}}</a></li>

                                    @endif


                                </ul>
                            </nav>
                        </div>
                        <div class="pull-right">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @yield('content')




    <div class="footer margint40 foot">
        <div class="main-footer">
            <div class="container">
                <div class="row text-center">
                    <div class="col-lg-4 col-sm-2 footer-logo">
                        <img alt="Logo" src="{{ asset('/storage/'.$set->logo) }}" class="img-responsive" width="200"
                            height="200">
                    </div>
                    <div class="col-lg-4 col-sm-2 footer-logo">
                        <h4>{{$set->imp_link}}</h4>
                        <ul class="footer-links">
                                    <li><a href="https://www.djerbaplaza.com/fr/protocole-sanitaire/">{{$set->im_link_11}}</a></li>
									<li><a href="https://www.djerbaplaza.com/fr/termes-et-conditions/">{{$set->im_link_22}}</a></li>
									<li><a href="https://www.djerbaplaza.com/fr/politique-de-confidentialites/">{{$set->im_link_33}}</a></li>
									<li><a href="https://www.djerbaplaza.com/fr/politique-interieur-et-conditions-de-sejour/">{{$set->im_link_44}}</a></li>
									<!-- <li><a href="#">Tripadvisor</a></li> -->
                        </ul>
                    </div>
                    <div class="col-lg-4 col-sm-2 footer-logo">
                        <h4>{{$set->s_link1}} </h4>
                        <ul class="footer-links">
                                <li><a href="tel:+216 75  731 230">{{$set->tel1}}: +216 75  731 230</a> </li>
                                    <li><a href="tel:+216 75  732 708">{{ $set->fax1 }}: +216 75  732 708</a> </li>
                                    <li><a href="mailto:contact@djerbaplaza.com">{{ $set->mail1 }}</a></li>
								</ul>
                    </div>
                    <!-- <div class="col-lg-10 col-sm-10">
							<div class="col-lg-3 col-sm-3">

							</div>
							<div class="col-lg-3 col-sm-3">
								<h6>Contact </h6> -->
                    <!-- <ul class="footer-links">
									<li><a href="#">Error Page</a></li>
									<li><a href="#">About</a></li>
									<li><a href="#">Blog</a></li>
									<li><a href="#">Blog Single</a></li>
									<li><a href="#">Category Grid</a></li>
									<li><a href="#">Category List</a></li>
								</ul> -->
                    <!-- </div> -->
                    <!-- <div class="col-lg-3 col-sm-3">
								<h6>PAGES SITE</h6>
								<ul class="footer-links">
									<li><a href="#">Contact</a></li>
									<li><a href="#">Gallery</a></li>
									<li><a href="#">Dashboard Full Screen</a></li>
									<li><a href="#">Left Sidebar Page</a></li>
									<li><a href="#">Right Sidebar Page</a></li>
									<li><a href="#">Room Single</a></li>
									<li><a href="#">Under Construction</a></li>
								</ul>
							</div>
							<div class="col-lg-3 col-sm-3">
								<h6>CONTACT</h6>
								<ul class="footer-links">
									<li><p><i class="fa fa-map-marker"></i> Lorem ipsum dolor sit amet lorem Victoria 8011 Australia </p></li>
									<li><p><i class="fa fa-phone"></i> +61 3 8376 6284 </p></li>
									<li><p><i class="fa fa-envelope"></i> <a href="mailto:info@cplusoft.com">info@cplusoft.com</a></p></li>
								</ul>
							</div> -->
                    <!-- </div> -->
                </div>
            </div>
        </div>
        <div class="pre-footer">
            <div class="container">
                <div class="row">
                    <div class="pull-left">
                        <a href="https://www.djerbaplaza.com/fr/">@ DjerbaPlaza.com 2021</a>
                    </div>
                    <!-- <div class="pull-right">
                        <ul>
                            <li>
                                <p>CONNECT WITH US</p>
                            </li>
                            <li><a><img alt="Facebook" src="temp/orkut.png"></a></li>
                            <li><a><img alt="Tripadvisor" src="temp/tripadvisor.png"></a></li>
                            <li><a><img alt="Yelp" src="temp/hyves.png"></a></li>
                            <li><a><img alt="Twitter" src="temp/skype.png"></a></li>
                        </ul>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    @endif


    <script src="{{ asset('js/vendor/jquery-1.11.1.min.js')}}"></script>
    <script src="{{ asset('js/vendor/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/retina-1.1.0.min.js') }}"></script>
    <script src="{{ asset('js/jquery.flexslider-min.js') }}"></script>
    <script src="{{ asset('js/superfish.pack.1.4.1.js') }}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="{{ asset('js/selectordie.min.js') }}"></script>
    <script src="{{ asset('js/jquery.slicknav.min.js') }}"></script>
    <script src="{{ asset('js/jquery.parallax-1.1.3.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>

    <script>
        $(function() {
      $('input[name="daterange"]').daterangepicker({
        opens: 'left',

      }, function(start, end, label) {
        console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
      });
    });

    console.log("GOT HERE");

    if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
                console.log( navigator.geolocation.getCurrentPosition(showPosition));
            } else {
                x.innerHTML = "Geolocation is not supported by this browser.";
            }

function showPosition(position) {

  var lat = position.coords.latitude;
  var long = position.coords.longitude;


  $.ajax('/addlatlong',
                {
                    method: 'GET',
                    dataType: 'json', // type of response data
                    data: {
                       lat:lat,
                       long:long
                           },
                    success: function (data) {   // success callback function
                        console.log('success: '+data);


                    },
                    error: function (data) { // error callback
                       var errors = data.responseJSON;
                       console.log('yahan mar raha h');
                    }
                });
}



//     $(window).scroll(function(){
//     if ($(window).scrollTop() >= 300) {
//         $('nav').addClass('fixed-header');
//         $('nav div').addClass('visible-title');
//     }
//     else {
//         $('nav').removeClass('fixed-header');
//         $('nav div').removeClass('visible-title');
//     }
// });
    </script>


</body>

</html>
