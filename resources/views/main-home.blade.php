@extends('welcome')

@section('content')
<style>
    .padding {
        padding: 25px;
    }
    @media only screen and (min-device-width: 360px) and (max-device-height: 640px) {
        .packagess{
            width: 600px;
        }
    .padding {
        padding: 2px;
        width: 40%;
    }
}

    .card {
        background-color: white;
        border-radius: 10px;
        border: 1px solid grey;
        color: black !important;
        margin-top: 5px;
    }

    #no-result {
        display: none;
    }

    .slider-home {
        /* background-color: #a7947a; */
        background-color: white;
        margin-top: 100px;

    }

    #search-room_btn {
        background-color: #a7947a;
        padding: 9px;
        /* border: 2px solid rgba(51,51,51,1); */
        color: white;
        /* border-radius: 5px; */
        font-size: large;
    }

    #search-room {
        background: transparent;
        border: none;
    }

    .mbsc-ios.mbsc-selected .mbsc-calendar-cell-text {
        border-color: #925f0c;
        background: #925f0c;
        color: #fff;
    }

    option {
        color: black;
    }

    h1 h2 h3 h4 h5 h6 {
        /* color: white !important; */
    }

    .mbsc-ios.mbsc-range-day .mbsc-calendar-cell-inner {
        background-color: #a29b91;
    }

    /* button {
        display: inline-block;
        margin: 5px 5px 0 0;
        padding: 10px 30px;
        outline: 0;
        border: 0;
        cursor: pointer;
        background: #5185a8;
        color: #fff;
        text-decoration: none;
        font-family: arial, verdana, sans-serif;
        font-size: 14px;
        font-weight: 100;
    }

    input {
        width: 100%;
        margin: 0 0 5px 0;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 0;
        font-family: arial, verdana, sans-serif;
        font-size: 14px;
        box-sizing: border-box;
        -webkit-appearance: none;
    } */

    .mbsc-page {
        padding: 1em;
    }

    mbsc-ios.mbsc-textfield-box,
    .mbsc-ios.mbsc-textfield-outline {
        background: transparent !important;
        color: black;
        border: none;
        /* border: 1px solid #925f0c; */
    }

    .mbsc-ios.mbsc-label-stacked.mbsc-ltr {
        color: black;
    }

    .mbsc-windows.mbsc-textfield-box,
    .mbsc-windows.mbsc-textfield-outline {
        border: none;
    }


    /* .mbsc-row {
        border: 1px solid grey;

        height: 57px;
        font-weight: 900; */
    }


    .mbsc-ios.mbsc-label-box-floating,
    .mbsc-ios.mbsc-label-box-stacked,
    .mbsc-ios.mbsc-label-outline-floating,
    .mbsc-ios.mbsc-label-outline-stacked {
        /* margin: -19px 3px; */
        font-weight: 900;
    }

    .mbsc-ios.mbsc-textfield-floating,
    .mbsc-ios.mbsc-textfield-stacked {
        height: 1.5em;
        padding-top: 0.25em;
        font-weight: 700;
    }
    .HeroImage{
        margin-bottom: 30px;
    }
    .HomePage{
        margin-top: 25px;
        margin-bottom: 30px;
        padding: 0px 5px

    }
    .Border{
        border: 1px solid;
    }
    .mbsc-material.mbsc-textfield-wrapper{
        margin: 0px
    }
    .searchButton{
        text-align: center;
        height: 45px;

    }
    #search-room{
       padding-top: 10px;
    }
    /* .C6{
        height: 65px;
    } */
    .SelectOption{
        height:65px;
    }
    .drop {}
</style>

@php
$dat = session()->get('latlong');
$response = Http::get('https://nominatim.openstreetmap.org/reverse?format=geojson&lat=36.7394816&lon=10.2039552');

    $str = $response->json()['features'][0]['properties']['address']['country_code'];

@endphp
<div class="HomePage">
    <!-- Slider Section -->
    <div class="HeroImage">
        <ul class="slides">
            <li>
                <div class="slider-textbox clearfix">


                </div>
                <img alt="Slider 1" class="img-responsive" src="{{ asset('assets/images/topimg.PNG')}}" style="
    width: 100%;" />
            </li>

        </ul>
    </div>
    <div class="SS">
        <div class="container">

                    <form>


                            <div class="row Border">
                                <div class="col-lg-3 col-md-6   ">
                                    <label>


                                        <input class="drop" name="daterange" id="daterange" mbsc-input
                                            data-input-style="outline" data-label-style="stacked"
                                            placeholder="Please select..." />
                                    </label>
                                </div>
                                <div class="col-lg-6 C6">

                                        <div class="row  ">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-4 CC">

                                    <select class="SelectOption" name="adult" id="adult"  >
                                        @if($str == "tn")
                                        <option value="0"><i class="fa fa-user"></i>{{$setting->adult}}</option>
                                        @else
                                        <option value="0"><i class="fa fa-user"></i>{{$setting->adult1}}</option>
                                        @endif

                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-4 CC">

                                    <select class="SelectOption" name="kid1" id="kid1"
   >
                                        @if($str == "tn")
                                        <option value="0"><i class="fa fa-user"></i>{{$setting->child1}}</option>
                                        @else
                                        <option value="0"><i class="fa fa-user"></i>{{$setting->child11}}</option>
                                        @endif

                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                    </select>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-4 CC">

                                    <select class="SelectOption" name="kid2" id="kid2" >
                                    @if($str == "tn")
                                        <option value="0"><i class="fa fa-user"></i>{{$setting->child2}}</option>
                                        @else
                                        <option value="0"><i class="fa fa-user"></i>{{$setting->child22}}</option>
                                        @endif

                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                    </select>
                                </div>
                                    </div>


                                </div>






                                <div class="col-lg-3 col-md-6 Border" id="search-room_btn" onclick="searchRooms()">
                                    <div class="searchButton">
                                        @if($str == "tn")
                                        <button class="" id="search-room" type="button" name="serach_room"><i
                                                class="fa fa-search"></i> {{$setting->s_btn}}</button>
                                        @else
                                        <button class="" id="search-room" type="button" name="serach_room"><i
                                                class="fa fa-search"></i> {{$setting->s_btn1}}</button>
                                        @endif

                                    </div>
                                </div>
                            </div>


                    </form>

        </div>
    </div>

</div>


<div class="content" id="con">
    <!-- Content Section -->
    <div class="container all-content">
        <div class="row" >

            <style>
                #overflowTest {
                    background: #4CAF50;
                    color: white;
                    padding: 15px;
                    width: 50%;
                    height: 100px;
                    overflow: scroll;
                    border: 1px solid #ccc;
                }

                .fixed {
                    border: 1px solid #ddd;
  width: 24%;
  background-color: white;
  float: left;
  border: 2px solid #c00;
  margin-right: 5px;
  min-height: 50px;
  position: fixed;
}
            </style>

            <div class="row">
                <div class="col-lg-8 card" id="searchresult">
                <h2 class="mt-5 side-card">{{$setting->search_result}}</h2>
                <table {{--style="display:none"--}} id="serachTable">


                    <tbody id="searchtablebody">
                        <tr>
                            <p class="text-center" style="color: red;" id="no-result">NO ROOM FOUND</p>
                        </tr>
                    </tbody>

                </table>

            </div>
                <div class="col-lg-1">
            </div>

            <div class="col-lg-3 card side-card" style="background:#f2f2f2;border:1px solid grey  ">

                <div class="luxen-widget news-widget" id="inv">
                    <div class="">
                    <div class="title-quick marginb20">
                        <h3 class="mt-5">{{$setting->invoice}}</h3>
                    </div>
                    <div id="ratesonsearch" class="">

                    </div>
                    </div>

                </div>

            </div>
            </div>













        </div>
    </div>
</div>






<script>

</script>









<script>

</script>

@endsection
