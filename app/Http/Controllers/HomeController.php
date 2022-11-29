<?php

namespace App\Http\Controllers;

use App\Models\PackageRoom;
use Illuminate\Http\Request;
use App\Models\Package;
// use App\Models\Service;
use App\Models\RangePrice;
use App\Models\Room;
use App\Models\FlatRate;
use App\Models\Facility;
use App\Models\PMOrderPrice;



use DateTime;
use App\Models\Booking;
use App\Models\CustDetail;
use App\Models\DateRangePackage;
use App\Models\DiscountPrice;
use App\Models\DiscountRoom;
use App\Models\PackageService;
use App\Models\PaymentMethod;
use App\Models\PMCoupon;
use App\Models\PMCountry;

use IPQualityScore\IPQualityScore;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use \willvincent\Rateable\Rating;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Mail\PasswordSent;
use App\Mail\ConfirmationEmail;

use App\Models\BookNowSetting;
use App\Models\Confirmation;
use App\Models\HomePageSetting;
use App\Models\LatLong;
use App\Models\NightDiscount;
use App\Models\Rate;
use App\Models\Badge;
use App\Models\BadgePackage;
use App\Models\RoomRate;
use App\Models\NewHomeSetting;
use Illuminate\Support\Facades\Mail;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use App\Models\Tax;

use App\Models\ExtraActivity;
use App\Models\CancelPolicy;
use App\Models\Service;

use App\Models\RoomData;
use App\Models\RoomServiceData;
use App\Models\RoomActivityData;
use App\Models\HeaderFooter;






// use Carbon\Carbon;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        return view('home');
    }

    public function getGoogleTranslate()
    {


        $key = 'bdELPYQYzlqCYrKewn0cwN9tTOjxXvVK';

        $qualityScore = new IPQualityScore($key);
        $ip_address = \Request::ip();
        $result1 = $qualityScore->IPAddressVerification->getResponse($ip_address);
        // dd($result1);
        $result = $result1->data;
    }


    public function searchRooms(Request $request)
    {


        // $key = 'bdELPYQYzlqCYrKewn0cwN9tTOjxXvVK';
        // $qualityScore = new IPQualityScore($key);
        // $ip_address = \Request::ip();
        // $result1 = $qualityScore->IPAddressVerification->getResponse("196.235.250.179");
        // $result = $result1->data;

        //return response()->json($request->all());


        $dat = session()->get('latlong');

        $response = Http::get('https://nominatim.openstreetmap.org/reverse?format=geojson&lat=36.7394816&lon=10.2039552');
        // return response()->json($response);

        $str = $request->country_code;



        // dd($date1);
        $date1 = $request['date_from'];
        $date2 = $request['date_to'];
        $date1 = DateTime::createFromFormat('Y-m-d', $date1);
        $date2 = DateTime::createFromFormat('Y-m-d', $date2);
        $datefrom = $date1->format('Y-m-d');
        $dateto = $date2->format('Y-m-d');
        $datediff = strtotime($dateto) - strtotime($datefrom);
        $days = (int)round($datediff / (60 * 60 * 24));
        $datefrom = $datefrom;
        $dateto = $dateto;
        $adults = $request['adults'];
        $kid1 = $request['kid1'];
        $kid2 = $request['kid2'];
        $kids = $kid1 + $kid2;

        $total_person = $adults + $kid1 + $kid2;


        //Seperate date and month
        $dff = explode("-", $datefrom);
        $df_month = $dff[1];
        $df_day = $dff[2];

        $dtt = explode("-", $dateto);
        $dt_month = $dtt[1];
        $dt_day = $dtt[2];

        $n_discounts = NightDiscount::where('datefrom', '<=', $datefrom)
            ->orWhere('dateto', '>=', $dateto)
            ->first();
        // dd($n_discounts);
        $disc = 0;
        if ($n_discounts != null) {
            if ($days <= 3) {
                $disc = $n_discounts->discount1;
            } else {
                $disc = $n_discounts->discount2;
            }
        }

        $rooms = Room::all();
        // $data = [];
        $data = [];
        $new_pricing = [];
        $new_array = [];
        $dataarray = [
            'datefrom' => $datefrom,
            'dateto' => $dateto,
            'adults' => $adults,
            'kid1' => $kid1,
            'kid2' => $kid2,
            'no_of_days' => $days,

        ];

        $k = 0;
        $status = "";

        $policies = CancelPolicy::all();
        foreach ($rooms as $room) {
            $facilities = Facility::join('room_facilities','room_facilities.facility_id','facilities.id')->where('room_facilities.room_id',$room->id)->get();

            $room_capacity = $room->max_child + $room->max_adults;
            if($room->no_of_rooms > 0 && ($adults > $room->max_adults || $kids > $room->max_child)){
                $status = "capacity";
            }
            elseif($room->no_of_rooms > 0 && $kids <= $room->max_child && $adults <= $room->max_adults ){
                
                if ($kid1 == 0 && $kid2 == 0 && $adults == 1 && $room->no_of_beds >=2) {
                    $rates = RoomRate::join('rates', 'rates.rate_id', 'room_rates.id')
                        ->where('rates.room_id', $room->id)->get();
                    // dd($rates);
                    if (count($rates) > 0) {
                        foreach ($rates as $rate) {
                            $package = Package::find($rate->package_id);
                            if (($df_month == "07" && $df_day >= "19" && $dt_month == "07" && $dt_day <= "31")) {
                                $status = "date";
                                $k = 1;
    
                                if ($str == "tn") {
                                    $data = [
                                        'room' => $room,
                                        'policies' => $policies,
                                        'rate' => $rate,
                                        'package' => $package,
                                        'price' => $days * ($rate->price_per_night2 + (int)50) * ((100 - $disc) / 100),
                                        'non_refundable' => $days * ($rate->non_refundable2 + (int)50) * ((100 - $disc) / 100),
                                        'non_modifiable' => $days * ($rate->non_modifiable2 + (int)50) * ((100 - $disc) / 100),
                                        'prepayment' => $days * ($rate->prepayment2 + (int)50) * ((100 - $disc) / 100),
                                        'no_advance' => $days * ($rate->no_advance2 + (int)50) * ((100 - $disc) / 100),
                                       
                                        'facilities' => [
                                            'room_id'=>$room->id,
                                        'room_name'=>$room->name,
                                            'room_facilities'=>$facilities],
                                            'symbol' => "TND",
    
                                    ];
                                    
                                } else {
                                    
                                    $data = [
                                        'room' => $room,
                                        'policies' => $policies,
                                        'rate' => $rate,
                                        'package' => $package,
                                        'price' => $days * ($rate->price_per_night1 + (int)50) * ((100 - $disc) / 100),
                                        'non_refundable' => $days * ($rate->non_refundable1 + (int)50) * ((100 - $disc) / 100),
                                        'non_modifiable' => $days * ($rate->non_modifiable1 + (int)50) * ((100 - $disc) / 100),
                                        'prepayment' => $days * ($rate->prepayment1 + (int)50) * ((100 - $disc) / 100),
                                        'no_advance' => $days * ($rate->no_advance1 + (int)50) * ((100 - $disc) / 100),
                                        'facilities' => ['room_id'=>$room->id,
                       'room_name'=>$room->name,
                        'room_facilities'=>$facilities],
'symbol' => "€",
                                    ];
                                }
                            } else if (($df_month == "08" && $df_day >= "01" && $dt_month == "08" && $dt_day <= "29")) {
                                $k = 1;
                                $status = "date";
                                if ($str == "tn") {
                                    $data = [
                                        'room' => $room,
                                        'policies' => $policies,
                                        'rate' => $rate,
                                        'package' => $package,
                                        'price' => $days * ($rate->price_per_night2 + (int)70) * ((100 - $disc) / 100),
                                        'non_refundable' => $days * ($rate->non_refundable2 + (int)70) * ((100 - $disc) / 100),
                                        'non_modifiable' => $days * ($rate->non_modifiable2 + (int)70) * ((100 - $disc) / 100),
                                        'prepayment' => $days * ($rate->prepayment2 + (int)70) * ((100 - $disc) / 100),
                                        'no_advance' => $days * ($rate->no_advance2 + (int)70) * ((100 - $disc) / 100),
                                        'facilities' => ['room_id'=>$room->id,
                       'room_name'=>$room->name,
                        'room_facilities'=>$facilities],
'symbol' => "TND",
                                    ];
                                } else {
                                    $data = [
                                        'room' => $room,
                                        'policies' => $policies,
                                        'rate' => $rate,
                                        'package' => $package,
                                        'price' => $days * ($rate->price_per_night1 + (int)70) * ((100 - $disc) / 100),
                                        'non_refundable' => $days * ($rate->non_refundable1 + (int)70) * ((100 - $disc) / 100),
                                        'non_modifiable' => $days * ($rate->non_modifiable1 + (int)70) * ((100 - $disc) / 100),
                                        'prepayment' => $days * ($rate->prepayment1 + (int)70) * ((100 - $disc) / 100),
                                        'no_advance' => $days * ($rate->no_advance1 + (int)70) * ((100 - $disc) / 100),
                                        'facilities' => ['room_id'=>$room->id,
                       'room_name'=>$room->name,
                        'room_facilities'=>$facilities],
'symbol' => "€",
                                    ];
                                }
                            } else if (($df_month >= "08" && $df_day >= "30") && ($dt_month <= "10" && $dt_day <= "31")) {
                                // $data = [
                                //     'room'  => $room,
                                //     'rate' => $rate,
                                //     'package'  => $package,
    
                                // ];
                                $status = "date";
                                $k = 1;
                                if ($str == "tn") {
                                    $data = [
                                        'room' => $room,
                                        'policies' => $policies,
                                        'rate' => $rate,
                                        'package' => $package,
                                        'price' => $days * ($rate->price_per_night2 + (int)50) * ((100 - $disc) / 100),
                                        'non_refundable' => $days * ($rate->non_refundable2 + (int)50) * ((100 - $disc) / 100),
                                        'non_modifiable' => $days * ($rate->non_modifiable2 + (int)50) * ((100 - $disc) / 100),
                                        'prepayment' => $days * ($rate->prepayment2 + (int)50) * ((100 - $disc) / 100),
                                        'no_advance' => $days * ($rate->no_advance2 + (int)50) * ((100 - $disc) / 100),
                                        'facilities' => ['room_id'=>$room->id,
                       'room_name'=>$room->name,
                        'room_facilities'=>$facilities],
'symbol' => "TND",
                                    ];
                                } else {
                                    $data = [
                                        'room' => $room,
                                        'policies' => $policies,
                                        'rate' => $rate,
                                        'package' => $package,
                                        'price' => $days * ($rate->price_per_night1 + (int)50) * ((100 - $disc) / 100),
                                        'non_refundable' => $days * ($rate->non_refundable1 + (int)50) * ((100 - $disc) / 100),
                                        'non_modifiable' => $days * ($rate->non_modifiable1 + (int)50) * ((100 - $disc) / 100),
                                        'prepayment' => $days * ($rate->prepayment1 + (int)50) * ((100 - $disc) / 100),
                                        'no_advance' => $days * ($rate->no_advance1 + (int)50) * ((100 - $disc) / 100),
                                        'facilities' => ['room_id'=>$room->id,
                       'room_name'=>$room->name,
                        'room_facilities'=>$facilities],
'symbol' => "€",
                                    ];
                                }
                            }
                                if(!empty($data)){
                                    $status = "Show Rooms";
                                    array_push($new_array, $data);  
                                }else{
                                    $status = "No Rooms Aavailable";
                                }
    
                            // array_push($new_pricing, $pricing);
                        }
                    }
                }
        }
        
                // return response()->json($new_array);
                if ($k != 1) {
                    foreach ($rooms as $room) {
                        $facilities = Facility::join('room_facilities','room_facilities.facility_id','facilities.id')->where('room_facilities.room_id',$room->id)->get();
                        if($room->no_of_rooms > 0 && ($adults > $room->max_adults || $kids > $room->max_child)){
                            $status = "capacity";
                        }
                        elseif(!empty($room) && $room->no_of_rooms > 0 && $kids <= $room->max_child && $adults <= $room->max_adults) {
                            $discounts = DiscountRoom::where('room_id', $room->id)->get();
                            if ($kid1 == 1 && $kid2 == 0 && $adults <= 2) { // FIRST Condition
                                $rates = RoomRate::join('rates', 'rates.rate_id', 'room_rates.id')
                                    ->where('rates.room_id', $room->id)->get();
                                if (count($rates) > 0) {
                                    foreach ($rates as $rate) {
                                        $package = Package::find($rate->package_id);
    
                                        if ($rate->start_date <= $datefrom && $rate->end_date >= $dateto) {
                                            $status = "date";
                                            if (count($discounts) > 0) {
                                                if ($str == "tn") {
                                                    $data = [
                                                        'room'  => $room,
                                                        'policies'  => $policies,
                                                        'rate' => $rate,
                                                        'package'  => $package,
                                                        'price' => ($adults * $rate->price_per_night2 * $days) + (((($kids * $days * $rate->price_per_night2)) * ((100 - $discounts[0]->discount) / 100) * ((100 - $disc) / 100))),
                                                        'non_refundable' => ($adults * $rate->non_refundable2 * $days) + (((($kids * $days * $rate->non_refundable2)) * ((100 - $discounts[0]->discount) / 100) * ((100 - $disc) / 100))),
                                                        'non_modifiable' => ($adults * $rate->non_modifiable2 * $days) + (((($kids * $days * $rate->non_modifiable2)) * ((100 - $discounts[0]->discount) / 100) * ((100 - $disc) / 100))),
                                                        'prepayment' => ($adults * $rate->prepayment2 * $days) + (((($kids * $days * $rate->prepayment2)) * ((100 - $discounts[0]->discount) / 100) * ((100 - $disc) / 100))),
                                                        'no_advance' => ($adults * $rate->no_advance2 * $days) + (((($kids * $days * $rate->no_advance2)) * ((100 - $discounts[0]->discount) / 100) * ((100 - $disc) / 100))),
                                                        'facilities' => ['room_id'=>$room->id,
                       'room_name'=>$room->name,
                        'room_facilities'=>$facilities],
                        'symbol' => "TND",
                                                    ];
                                                } else {
                                                    $data = [
                                                        'room'  => $room,
                                                        'policies'  => $policies,
                                                        'rate' => $rate,
                                                        'package'  => $package,
                                                        'price' => ($adults * $rate->price_per_night1 * $days) + (((($kids * $days * $rate->price_per_night1)) * ((100 - $discounts[0]->discount) / 100) * ((100 - $disc) / 100))),
                                                        'non_refundable' => ($adults * $rate->non_refundable1 * $days) + (((($kids * $days * $rate->non_refundable1)) * ((100 - $discounts[0]->discount) / 100) * ((100 - $disc) / 100))),
                                                        'non_modifiable' => ($adults * $rate->non_modifiable1 * $days) + (((($kids * $days * $rate->non_modifiable1)) * ((100 - $discounts[0]->discount) / 100) * ((100 - $disc) / 100))),
                                                        'prepayment' => ($adults * $rate->prepayment1 * $days) + (((($kids * $days * $rate->prepayment1)) * ((100 - $discounts[0]->discount) / 100) * ((100 - $disc) / 100))),
                                                        'no_advance' => ($adults * $rate->no_advance1 * $days) + (((($kids * $days * $rate->no_advance1)) * ((100 - $discounts[0]->discount) / 100) * ((100 - $disc) / 100))),
                                                        'facilities' => ['room_id'=>$room->id,
                       'room_name'=>$room->name,
                        'room_facilities'=>$facilities],
                        'symbol' => "€",
                                                    ];
                                                }
                                            } else {
                                                $status = "nodate";
                                                if ($str == "tn") {
                                                    $data = [
                                                        'room'  => $room,
                                                        'policies'  => $policies,
                                                        'rate' => $rate,
                                                        'package'  => $package,
                                                        'price' => ($adults * $rate->price_per_night2 * $days) + (((($kids * $days * $rate->price_per_night2)) * ((100 - 0) / 100) * ((100 - $disc) / 100))),
                                                        'non_refundable' => ($adults * $rate->non_refundable2 * $days) + (((($kids * $days * $rate->non_refundable2)) * ((100 - 0) / 100) * ((100 - $disc) / 100))),
                                                        'non_modifiable' => ($adults * $rate->non_modifiable2 * $days) + (((($kids * $days * $rate->non_modifiable2)) * ((100 - 0) / 100) * ((100 - $disc) / 100))),
                                                        'prepayment' => ($adults * $rate->prepayment2 * $days) + (((($kids * $days * $rate->prepayment2)) * ((100 - 0) / 100) * ((100 - $disc) / 100))),
                                                        'no_advance' => ($adults * $rate->no_advance2 * $days) + (((($kids * $days * $rate->no_advance2)) * ((100 - 0) / 100) * ((100 - $disc) / 100))),
                                                        'facilities' => ['room_id'=>$room->id,
                       'room_name'=>$room->name,
                        'room_facilities'=>$facilities],
                        'symbol' => "TND",
                                                    ];
                                                } else {
                                                    $data = [
                                                        'room'  => $room,
                                                        'policies'  => $policies,
                                                        'rate' => $rate,
                                                        'package'  => $package,
                                                        'price' => ($adults * $rate->price_per_night1 * $days) + (((($kids * $days * $rate->price_per_night1)) * ((100 - 0) / 100) * ((100 - $disc) / 100))),
                                                        'non_refundable' => ($adults * $rate->non_refundable1 * $days) + (((($kids * $days * $rate->non_refundable1)) * ((100 - 0) / 100) * ((100 - $disc) / 100))),
                                                        'non_modifiable' => ($adults * $rate->non_modifiable1 * $days) + (((($kids * $days * $rate->non_modifiable1)) * ((100 - 0) / 100) * ((100 - $disc) / 100))),
                                                        'prepayment' => ($adults * $rate->prepayment1 * $days) + (((($kids * $days * $rate->prepayment1)) * ((100 - 0) / 100) * ((100 - $disc) / 100))),
                                                        'no_advance' => ($adults * $rate->no_advance1 * $days) + (((($kids * $days * $rate->no_advance1)) * ((100 - 0) / 100) * ((100 - $disc) / 100))),
                                                        'facilities' => ['room_id'=>$room->id,
                       'room_name'=>$room->name,
                        'room_facilities'=>$facilities],
                        'symbol' => "€",
                                                    ];
                                                }
                                            }
                                        } else {
                                            // $data = [
                                            //     'room'  => $room,
                                            //     'rate' => $rate,
                                            //     'package'  => $package,
    
                                            // ];
                                            if (count($discounts) > 0) {
                                                if ($str == "tn") {
                                                    $data = [
                                                        'room'  => $room,
                                                        'policies'  => $policies,
                                                        'rate' => $rate,
                                                        'package'  => $package,
                                                        'price' => ($adults * $room->price2 * $days) + (((($kids * $days * $room->price2)) * ((100 - $discounts[0]->discount) / 100) * ((100 - $disc) / 100))),
                                                        'facilities' => ['room_id'=>$room->id,
                       'room_name'=>$room->name,
                        'room_facilities'=>$facilities],
                        'symbol' => "TND",
                                                    ];
                                                } else {
                                                    $data = [
                                                        'room'  => $room,
                                                        'policies'  => $policies,
                                                        'rate' => $rate,
                                                        'package'  => $package,
                                                        'price' => ($adults * $room->price1 * $days) + (((($kids * $days * $room->price1)) * ((100 - $discounts[0]->discount) / 100) * ((100 - $disc) / 100))),
                                                        'facilities' => ['room_id'=>$room->id,
                       'room_name'=>$room->name,
                        'room_facilities'=>$facilities],
                        'symbol' => "€",
                                                    ];
                                                }
                                            } else {
                                                if ($str == "tn") {
                                                    $data = [
                                                        'room'  => $room,
                                                        'policies'  => $policies,
                                                        'rate' => $rate,
                                                        'package'  => $package,
                                                        'price' => ($adults * $room->price2 * $days) + (((($kids * $days * $room->price2)) * ((100 - 0) / 100) * ((100 - $disc) / 100))),
                                                        'facilities' => ['room_id'=>$room->id,
                       'room_name'=>$room->name,
                        'room_facilities'=>$facilities],
                        'symbol' => "TND",
                                                    ];
                                                } else {
                                                    $data = [
                                                        'room'  => $room,
                                                        'policies'  => $policies,
                                                        'rate' => $rate,
                                                        'package'  => $package,
                                                        'price' => ($adults * $room->price1 * $days) + (((($kids * $days * $room->price1)) * ((100 - 0) / 100) * ((100 - $disc) / 100))),
                                                        'facilities' => ['room_id'=>$room->id,
                       'room_name'=>$room->name,
                        'room_facilities'=>$facilities],
                        'symbol' => "€",
                                                    ];
                                                }
                                            }
                                        }
                                        if(!empty($data) && $status != "nodate"){
                                            $status = "Show Rooms";
                                            array_push($new_array, $data);  
                                        }else{
                                            $status = "No Rooms Aavailable";
                                        }
                                    }
                                }
                            } elseif ($kid1 == 0 && $kid2 == 1 && $adults == 1) { // SECOND Condition
                                $rates = RoomRate::join('rates', 'rates.rate_id', 'room_rates.id')
                                    ->where(
                                        'rates.room_id',
                                        $room->id
                                    )->get();
                                if (count($rates) > 0) {
                                    foreach ($rates as $rate) {
                                        $package = Package::find($rate->package_id);
    
                                        if ($rate->start_date <= $datefrom && $rate->end_date >= $dateto) {
                                            // $data = [
                                            //     'room'  => $room,
                                            //     'rate' => $rate,
                                            //     'package'  => $package,
    
                                            // ];
                                            $status = "date";
                                            if (count($discounts) > 0) {
                                                if ($str == "tn") {
                                                    $data = [
                                                        'room'  => $room,
                                                        'policies'  => $policies,
                                                        'rate' => $rate,
                                                        'package'  => $package,
                                                        'price' => ($adults * $rate->price_per_night2 * $days) + (((($kids * $days * $rate->price_per_night2)) * ((100 - $discounts[1]->discount) / 100) * ((100 - $disc) / 100))),
                                                        'non_refundable' => ($adults * $rate->non_refundable2 * $days) + (((($kids * $days * $rate->non_refundable2)) * ((100 - $discounts[1]->discount) / 100) * ((100 - $disc) / 100))),
                                                        'non_modifiable' => ($adults * $rate->non_modifiable2 * $days) + (((($kids * $days * $rate->non_modifiable2)) * ((100 - $discounts[1]->discount) / 100) * ((100 - $disc) / 100))),
                                                        'prepayment' => ($adults * $rate->prepayment2 * $days) + (((($kids * $days * $rate->prepayment2)) * ((100 - $discounts[1]->discount) / 100) * ((100 - $disc) / 100))),
                                                        'no_advance' => ($adults * $rate->no_advance2 * $days) + (((($kids * $days * $rate->no_advance2)) * ((100 - $discounts[1]->discount) / 100) * ((100 - $disc) / 100))),
                                                        'facilities' => ['room_id'=>$room->id,
                       'room_name'=>$room->name,
                        'room_facilities'=>$facilities],
                        'symbol' => "TND",
                                                    ];
                                                } else {
                                                    $data = [
                                                        'room'  => $room,
                                                        'policies'  => $policies,
                                                        'rate' => $rate,
                                                        'package'  => $package,
                                                        'price' => ($adults * $rate->price_per_night1 * $days) + (((($kids * $days * $rate->price_per_night1)) * ((100 - $discounts[1]->discount) / 100) * ((100 - $disc) / 100))),
                                                        'non_refundable' => ($adults * $rate->non_refundable1 * $days) + (((($kids * $days * $rate->non_refundable1)) * ((100 - $discounts[1]->discount) / 100) * ((100 - $disc) / 100))),
                                                        'non_modifiable' => ($adults * $rate->non_modifiable1 * $days) + (((($kids * $days * $rate->non_modifiable1)) * ((100 - $discounts[1]->discount) / 100) * ((100 - $disc) / 100))),
                                                        'prepayment' => ($adults * $rate->prepayment1 * $days) + (((($kids * $days * $rate->prepayment1)) * ((100 - $discounts[1]->discount) / 100) * ((100 - $disc) / 100))),
                                                        'no_advance' => ($adults * $rate->no_advance1 * $days) + (((($kids * $days * $rate->no_advance1)) * ((100 - $discounts[1]->discount) / 100) * ((100 - $disc) / 100))),
                                                        'facilities' => ['room_id'=>$room->id,
                       'room_name'=>$room->name,
                        'room_facilities'=>$facilities],
                            'symbol' => "€",
                                                    ];
                                                }
                                            } else {
                                                if ($str == "tn") {
                                                    $data = [
                                                        'room'  => $room,
                                                        'policies'  => $policies,
                                                        'rate' => $rate,
                                                        'package'  => $package,
                                                        'price' => ($adults * $rate->price_per_night2 * $days) + (((($kids * $days * $rate->price_per_night2)) * ((100 - 0) / 100) * ((100 - $disc) / 100))),
                                                        'non_refundable' => ($adults * $rate->non_refundable2 * $days) + (((($kids * $days * $rate->non_refundable2)) * ((100 - 0) / 100) * ((100 - $disc) / 100))),
                                                        'non_modifiable' => ($adults * $rate->non_modifiable2 * $days) + (((($kids * $days * $rate->non_modifiable2)) * ((100 - 0) / 100) * ((100 - $disc) / 100))),
                                                        'prepayment' => ($adults * $rate->prepayment2 * $days) + (((($kids * $days * $rate->prepayment2)) * ((100 - 0) / 100) * ((100 - $disc) / 100))),
                                                        'no_advance' => ($adults * $rate->no_advance2 * $days) + (((($kids * $days * $rate->no_advance2)) * ((100 - 0) / 100) * ((100 - $disc) / 100))),
                                                        'facilities' => ['room_id'=>$room->id,
                       'room_name'=>$room->name,
                        'room_facilities'=>$facilities],
                        'symbol' => "TND",
                                                    ];
                                                } else {
                                                    $data = [
                                                        'room'  => $room,
                                                        'policies'  => $policies,
                                                        'rate' => $rate,
                                                        'package'  => $package,
                                                        'price' => ($adults * $rate->price_per_night1 * $days) + (((($kids * $days * $rate->price_per_night1)) * ((100 - 0) / 100) * ((100 - $disc) / 100))),
                                                        'non_refundable' => ($adults * $rate->non_refundable1 * $days) + (((($kids * $days * $rate->non_refundable1)) * ((100 - 0) / 100) * ((100 - $disc) / 100))),
                                                        'non_modifiable' => ($adults * $rate->non_modifiable1 * $days) + (((($kids * $days * $rate->non_modifiable1)) * ((100 - 0) / 100) * ((100 - $disc) / 100))),
                                                        'prepayment' => ($adults * $rate->prepayment1 * $days) + (((($kids * $days * $rate->prepayment1)) * ((100 - 0) / 100) * ((100 - $disc) / 100))),
                                                        'no_advance' => ($adults * $rate->no_advance1 * $days) + (((($kids * $days * $rate->no_advance1)) * ((100 - 0) / 100) * ((100 - $disc) / 100))),
                                                        'facilities' => ['room_id'=>$room->id,
                       'room_name'=>$room->name,
                        'room_facilities'=>$facilities],
                        'symbol' => "€",
                                                    ];
                                                }
                                            }
                                        } else {
                                            $status = "nodate";
                                            if (count($discounts) > 0) {
                                                if ($str == "tn") {
                                                    $data = [
                                                        'room'  => $room,
                                                        'policies'  => $policies,
                                                        'rate' => $rate,
                                                        'package'  => $package,
                                                        'price' => ($adults * $room->price2 * $days) + (((($kids * $days * $room->price2)) * ((100 - $discounts[1]->discount) / 100) * ((100 - $disc) / 100))),
                                                        'facilities' => ['room_id'=>$room->id,
                       'room_name'=>$room->name,
                        'room_facilities'=>$facilities],
                        'symbol' => "TND",
                                                    ];
                                                } else {
                                                    $data = [
                                                        'room'  => $room,
                                                        'policies'  => $policies,
                                                        'rate' => $rate,
                                                        'package'  => $package,
                                                        'price' => ($adults * $room->price1 * $days) + (((($kids * $days * $room->price1)) * ((100 - $discounts[1]->discount) / 100) * ((100 - $disc) / 100))),
                                                        'facilities' => ['room_id'=>$room->id,
                       'room_name'=>$room->name,
                        'room_facilities'=>$facilities],
                    'symbol' => "€",
                                                    ];
                                                }
                                            } else {
                                                if ($str == "tn") {
                                                    $data = [
                                                        'room'  => $room,
                                                        'policies'  => $policies,
                                                        'rate' => $rate,
                                                        'package'  => $package,
                                                        'price' => ($adults * $room->price2 * $days) + (((($kids * $days * $room->price2)) * ((100 - 0) / 100) * ((100 - $disc) / 100))),
                                                        'facilities' => ['room_id'=>$room->id,
                       'room_name'=>$room->name,
                        'room_facilities'=>$facilities],
                    'symbol' => "TND",
                                                    ];
                                                } else {
                                                    $data = [
                                                        'room'  => $room,
                                                        'policies'  => $policies,
                                                        'rate' => $rate,
                                                        'package'  => $package,
                                                        'price' => ($adults * $room->price1 * $days) + (((($kids * $days * $room->price1)) * ((100 - 0) / 100) * ((100 - $disc) / 100))),
                                                        'facilities' => ['room_id'=>$room->id,
                       'room_name'=>$room->name,
                        'room_facilities'=>$facilities],
                        'symbol' => "€",
                                                    ];
                                                }
                                            }
                                        }
                                        if(!empty($data) && $status != "nodate"){
                                            $status = "Show Rooms";
                                            array_push($new_array, $data);  
                                        }else{
                                            $status = "No Rooms Aavailable";
                                        }
                                       
                                    }
                                }
                            } elseif ($kid1 == 0 && ($kid2 == 1 || $kid2 == 2) && $adults <= 2) {   // THIRD Condition
                                $rates = RoomRate::join('rates', 'rates.rate_id', 'room_rates.id')
                                    ->where('rates.room_id', $room->id)->get();
                                if (count($rates) > 0) {
                                    foreach ($rates as $rate) {
                                        $package = Package::find($rate->package_id);
    
                                        if ($rate->start_date <= $datefrom && $rate->end_date >= $dateto) {
                                           $date = "date";
                                            if (count($discounts) > 0) {
                                                if ($str == "tn") {
                                                    $data = [
                                                        'room'  => $room,
                                                        'policies'  => $policies,
                                                        'rate' => $rate,
                                                        'package'  => $package,
                                                        'price' => ($adults * $rate->price_per_night2 * $days) + (((($kids * $days * $rate->price_per_night2)) * ((100 - $discounts[2]->discount) / 100) * ((100 - $disc) / 100))),
                                                        'non_refundable' => ($adults * $rate->non_refundable2 * $days) + (((($kids * $days * $rate->non_refundable2)) * ((100 - $discounts[2]->discount) / 100) * ((100 - $disc) / 100))),
                                                        'non_modifiable' => ($adults * $rate->non_modifiable2 * $days) + (((($kids * $days * $rate->non_modifiable2)) * ((100 - $discounts[2]->discount) / 100) * ((100 - $disc) / 100))),
                                                        'prepayment' => ($adults * $rate->prepayment2 * $days) + (((($kids * $days * $rate->prepayment2)) * ((100 - $discounts[2]->discount) / 100) * ((100 - $disc) / 100))),
                                                        'no_advance' => ($adults * $rate->no_advance2 * $days) + (((($kids * $days * $rate->no_advance2)) * ((100 - $discounts[2]->discount) / 100) * ((100 - $disc) / 100))),
                                                        'facilities' => ['room_id'=>$room->id,
                       'room_name'=>$room->name,
                        'room_facilities'=>$facilities],
                        'symbol' => "TND",
                                                    ];
                                                } else {
                                                    $data = [
                                                        'room'  => $room,
                                                        'policies'  => $policies,
                                                        'rate' => $rate,
                                                        'package'  => $package,
                                                        'price' => ($adults * $rate->price_per_night1 * $days) + (((($kids * $days * $rate->price_per_night1)) * ((100 - $discounts[2]->discount) / 100) * ((100 - $disc) / 100))),
                                                        'non_refundable' => ($adults * $rate->non_refundable1 * $days) + (((($kids * $days * $rate->non_refundable1)) * ((100 - $discounts[2]->discount) / 100) * ((100 - $disc) / 100))),
                                                        'non_modifiable' => ($adults * $rate->non_modifiable1 * $days) + (((($kids * $days * $rate->non_modifiable1)) * ((100 - $discounts[2]->discount) / 100) * ((100 - $disc) / 100))),
                                                        'prepayment' => ($adults * $rate->prepayment1 * $days) + (((($kids * $days * $rate->prepayment1)) * ((100 - $discounts[2]->discount) / 100) * ((100 - $disc) / 100))),
                                                        'no_advance' => ($adults * $rate->no_advance1 * $days) + (((($kids * $days * $rate->no_advance1)) * ((100 - $discounts[2]->discount) / 100) * ((100 - $disc) / 100))),
                                                        'facilities' => ['room_id'=>$room->id,
                       'room_name'=>$room->name,
                        'room_facilities'=>$facilities],
                        'symbol' => "€",
                                                    ];
                                                }
                                            } else {
                                                if ($str == "tn") {
                                                    $data = [
                                                        'room'  => $room,
                                                        'policies'  => $policies,
                                                        'rate' => $rate,
                                                        'package'  => $package,
                                                        'price' => ($adults * $rate->price_per_night2 * $days) + (((($kids * $days * $rate->price_per_night2)) * ((100 - 0) / 100) * ((100 - $disc) / 100))),
                                                        'non_refundable' => ($adults * $rate->non_refundable2 * $days) + (((($kids * $days * $rate->non_refundable2)) * ((100 - 0) / 100) * ((100 - $disc) / 100))),
                                                        'non_modifiable' => ($adults * $rate->non_modifiable2 * $days) + (((($kids * $days * $rate->non_modifiable2)) * ((100 - 0) / 100) * ((100 - $disc) / 100))),
                                                        'prepayment' => ($adults * $rate->prepayment2 * $days) + (((($kids * $days * $rate->prepayment2)) * ((100 - 0) / 100) * ((100 - $disc) / 100))),
                                                        'no_advance' => ($adults * $rate->no_advance2 * $days) + (((($kids * $days * $rate->no_advance2)) * ((100 - 0) / 100) * ((100 - $disc) / 100))),
                                                        'facilities' => ['room_id'=>$room->id,
                       'room_name'=>$room->name,
                        'room_facilities'=>$facilities],
                        'symbol' => "TND",
                                                    ];
                                                } else {
                                                    $data = [
                                                        'room'  => $room,
                                                        'policies'  => $policies,
                                                        'rate' => $rate,
                                                        'package'  => $package,
                                                        'price' => ($adults * $rate->price_per_night1 * $days) + (((($kids * $days * $rate->price_per_night1)) * ((100 - 0) / 100) * ((100 - $disc) / 100))),
                                                        'non_refundable' => ($adults * $rate->non_refundable1 * $days) + (((($kids * $days * $rate->non_refundable1)) * ((100 - 0) / 100) * ((100 - $disc) / 100))),
                                                        'non_modifiable' => ($adults * $rate->non_modifiable1 * $days) + (((($kids * $days * $rate->non_modifiable1)) * ((100 - 0) / 100) * ((100 - $disc) / 100))),
                                                        'prepayment' => ($adults * $rate->prepayment1 * $days) + (((($kids * $days * $rate->prepayment1)) * ((100 - 0) / 100) * ((100 - $disc) / 100))),
                                                        'no_advance' => ($adults * $rate->no_advance1 * $days) + (((($kids * $days * $rate->no_advance1)) * ((100 - 0) / 100) * ((100 - $disc) / 100))),
                                                        'facilities' => ['room_id'=>$room->id,
                       'room_name'=>$room->name,
                        'room_facilities'=>$facilities],
                            'symbol' => "€",
                                                    ];
                                                }
                                            }
                                        } else {
                                            $status = "nodate";
                                            if (count($discounts) > 0) {
                                                if ($str == "tn") {
                                                    $data = [
                                                        'room'  => $room,
                                                        'policies'  => $policies,
                                                        'rate' => $rate,
                                                        'package'  => $package,
                                                        'price' => ($adults * $room->price2 * $days) + (((($kids * $days * $room->price2)) * ((100 - $discounts[2]->discount) / 100) * ((100 - $disc) / 100))),
                                                        'facilities' => ['room_id'=>$room->id,
                       'room_name'=>$room->name,
                        'room_facilities'=>$facilities],
                        'symbol' => "TND",
                                                    ];
                                                } else {
                                                    $data = [
                                                        'room'  => $room,
                                                        'policies'  => $policies,
                                                        'rate' => $rate,
                                                        'package'  => $package,
                                                        'price' => ($adults * $room->price1 * $days) + (((($kids * $days * $room->price1)) * ((100 - $discounts[2]->discount) / 100) * ((100 - $disc) / 100))),
                                                        'facilities' => ['room_id'=>$room->id,
                       'room_name'=>$room->name,
                        'room_facilities'=>$facilities],
                        'symbol' => "€",
                                                    ];
                                                }
                                            } else {
                                                if ($str == "tn") {
                                                    $data = [
                                                        'room'  => $room,
                                                        'policies'  => $policies,
                                                        'rate' => $rate,
                                                        'package'  => $package,
                                                        'price' => ($adults * $room->price2 * $days) + (((($kids * $days * $room->price2)) * ((100 - 0) / 100) * ((100 - $disc) / 100))),
                                                        'facilities' => ['room_id'=>$room->id,
                       'room_name'=>$room->name,
                        'room_facilities'=>$facilities],
                        'symbol' => "TND",
                                                    ];
                                                } else {
                                                    $data = [
                                                        'room'  => $room,
                                                        'policies'  => $policies,
                                                        'rate' => $rate,
                                                        'package'  => $package,
                                                        'price' => ($adults * $room->price1 * $days) + (((($kids * $days * $room->price1)) * ((100 - 0) / 100) * ((100 - $disc) / 100))),
                                                        'facilities' => ['room_id'=>$room->id,
                       'room_name'=>$room->name,
                        'room_facilities'=>$facilities],
                        'symbol' => "€",
                                                    ];
                                                }
                                            }
                                        }
                                        if(!empty($data) && $status != "nodate"){
                                            $status = "Show Rooms";
                                            array_push($new_array, $data);  
                                        }else{
                                            $status = "No Rooms Aavailable";
                                        }
                                        
                                    }
                                }
                            } elseif (($kid2 == 1 || $kid2 == 2 || $kid2 == 3) && $kid1 == 0 && $adults == 0) { // FOURTH Condition
                                $rates = RoomRate::join('rates', 'rates.rate_id', 'room_rates.id')
                                    ->where(
                                        'rates.room_id',
                                        $room->id
                                    )->get();
                                if (count($rates) > 0) {
                                    foreach ($rates as $rate) {
                                        $package = Package::find($rate->package_id);
    
                                        if ($rate->start_date <= $datefrom && $rate->end_date >= $dateto) {
                                            $status = "date";
                                            if (count($discounts) > 0) {
                                                if ($str == "tn") {
                                                    $data = [
                                                        'room'  => $room,
                                                        'policies'  => $policies,
                                                        'rate' => $rate,
                                                        'package'  => $package,
                                                        'price' => ($adults * $rate->price_per_night2 * $days) + (((($kids * $days * $rate->price_per_night2)) * ((100 - $discounts[3]->discount) / 100) * ((100 - $disc) / 100))),
                                                        'non_refundable' => ($adults * $rate->non_refundable2 * $days) + (((($kids * $days * $rate->non_refundable2)) * ((100 - $discounts[3]->discount) / 100) * ((100 - $disc) / 100))),
                                                        'non_modifiable' => ($adults * $rate->non_modifiable2 * $days) + (((($kids * $days * $rate->non_modifiable2)) * ((100 - $discounts[3]->discount) / 100) * ((100 - $disc) / 100))),
                                                        'prepayment' => ($adults * $rate->prepayment2 * $days) + (((($kids * $days * $rate->prepayment2)) * ((100 - $discounts[3]->discount) / 100) * ((100 - $disc) / 100))),
                                                        'no_advance' => ($adults * $rate->no_advance2 * $days) + (((($kids * $days * $rate->no_advance2)) * ((100 - $discounts[3]->discount) / 100) * ((100 - $disc) / 100))),
                                                        'facilities' => ['room_id'=>$room->id,
                       'room_name'=>$room->name,
                        'room_facilities'=>$facilities],
                        'symbol' => "TND",
                                                    ];
                                                } else {
                                                    $data = [
                                                        'room'  => $room,
                                                        'policies'  => $policies,
                                                        'rate' => $rate,
                                                        'package'  => $package,
                                                        'price' => ($adults * $rate->price_per_night1 * $days) + (((($kids * $days * $rate->price_per_night1)) * ((100 - $discounts[3]->discount) / 100) * ((100 - $disc) / 100))),
                                                        'non_refundable' => ($adults * $rate->non_refundable1 * $days) + (((($kids * $days * $rate->non_refundable1)) * ((100 - $discounts[3]->discount) / 100) * ((100 - $disc) / 100))),
                                                        'non_modifiable' => ($adults * $rate->non_modifiable1 * $days) + (((($kids * $days * $rate->non_modifiable1)) * ((100 - $discounts[3]->discount) / 100) * ((100 - $disc) / 100))),
                                                        'prepayment' => ($adults * $rate->prepayment1 * $days) + (((($kids * $days * $rate->prepayment1)) * ((100 - $discounts[3]->discount) / 100) * ((100 - $disc) / 100))),
                                                        'no_advance' => ($adults * $rate->no_advance1 * $days) + (((($kids * $days * $rate->no_advance1)) * ((100 - $discounts[3]->discount) / 100) * ((100 - $disc) / 100))),
                                                        'facilities' => ['room_id'=>$room->id,
                       'room_name'=>$room->name,
                        'room_facilities'=>$facilities],
                        'symbol' => "€",
                                                    ];
                                                }
                                            } else {
                                                if ($str == "tn") {
                                                    $data = [
                                                        'room'  => $room,
                                                        'policies'  => $policies,
                                                        'rate' => $rate,
                                                        'package'  => $package,
                                                        'price' => ($adults * $rate->price_per_night2 * $days) + (((($kids * $days * $rate->price_per_night2)) * ((100 - 0) / 100) * ((100 - $disc) / 100))),
                                                        'non_refundable' => ($adults * $rate->non_refundable2 * $days) + (((($kids * $days * $rate->non_refundable2)) * ((100 - 0) / 100) * ((100 - $disc) / 100))),
                                                        'non_modifiable' => ($adults * $rate->non_modifiable2 * $days) + (((($kids * $days * $rate->non_modifiable2)) * ((100 - 0) / 100) * ((100 - $disc) / 100))),
                                                        'prepayment' => ($adults * $rate->prepayment2 * $days) + (((($kids * $days * $rate->prepayment2)) * ((100 - 0) / 100) * ((100 - $disc) / 100))),
                                                        'no_advance' => ($adults * $rate->no_advance2 * $days) + (((($kids * $days * $rate->no_advance2)) * ((100 - 0) / 100) * ((100 - $disc) / 100))),
                                                        'facilities' => ['room_id'=>$room->id,
                       'room_name'=>$room->name,
                        'room_facilities'=>$facilities],
                        'symbol' => "TND",
                                                    ];
                                                } else {
                                                    $data = [
                                                        'room'  => $room,
                                                        'policies'  => $policies,
                                                        'rate' => $rate,
                                                        'package'  => $package,
                                                        'price' => ($adults * $rate->price_per_night1 * $days) + (((($kids * $days * $rate->price_per_night1)) * ((100 - 0) / 100) * ((100 - $disc) / 100))),
                                                        'non_refundable' => ($adults * $rate->non_refundable1 * $days) + (((($kids * $days * $rate->non_refundable1)) * ((100 - 0) / 100) * ((100 - $disc) / 100))),
                                                        'non_modifiable' => ($adults * $rate->non_modifiable1 * $days) + (((($kids * $days * $rate->non_modifiable1)) * ((100 - 0) / 100) * ((100 - $disc) / 100))),
                                                        'prepayment' => ($adults * $rate->prepayment1 * $days) + (((($kids * $days * $rate->prepayment1)) * ((100 - 0) / 100) * ((100 - $disc) / 100))),
                                                        'no_advance' => ($adults * $rate->no_advance1 * $days) + (((($kids * $days * $rate->no_advance1)) * ((100 - 0) / 100) * ((100 - $disc) / 100))),
                                                        'facilities' => ['room_id'=>$room->id,
                       'room_name'=>$room->name,
                        'room_facilities'=>$facilities],
                            'symbol' => "€",
                                                    ];
                                                }
                                            }
                                        } else {
                                            $status = "nodate";
                                            if (count($discounts) > 0) {
                                                if ($str == "tn") {
                                                    $data = [
                                                        'room'  => $room,
                                                        'policies'  => $policies,
                                                        'rate' => $rate,
                                                        'package'  => $package,
                                                        'price' => ($adults * $room->price2 * $days) + (((($kids * $days * $room->price2)) * ((100 - $discounts[3]->discount) / 100) * ((100 - $disc) / 100))),
                                                        'facilities' => ['room_id'=>$room->id,
                       'room_name'=>$room->name,
                        'room_facilities'=>$facilities],
                        'symbol' => "TND",
                                                    ];
                                                } else {
                                                    $data = [
                                                        'room'  => $room,
                                                        'policies'  => $policies,
                                                        'rate' => $rate,
                                                        'package'  => $package,
                                                        'price' => ($adults * $room->price1 * $days) + (((($kids * $days * $room->price1)) * ((100 - $discounts[3]->discount) / 100) * ((100 - $disc) / 100))),
                                                        'facilities' => ['room_id'=>$room->id,
                       'room_name'=>$room->name,
                        'room_facilities'=>$facilities],
                            'symbol' => "€",
                                                    ];
                                                }
                                            } else {
                                                if ($str == "tn") {
                                                    $data = [
                                                        'room'  => $room,
                                                        'policies'  => $policies,
                                                        'rate' => $rate,
                                                        'package'  => $package,
                                                        'price' => ($adults * $room->price2 * $days) + (((($kids * $days * $room->price2)) * ((100 - 0) / 100) * ((100 - $disc) / 100))),
                                                        'facilities' => ['room_id'=>$room->id,
                       'room_name'=>$room->name,
                        'room_facilities'=>$facilities],
                            'symbol' => "TND",
                                                    ];
                                                } else {
                                                    $data = [
                                                        'room'  => $room,
                                                        'policies'  => $policies,
                                                        'rate' => $rate,
                                                        'package'  => $package,
                                                        'price' => ($adults * $room->price1 * $days) + (((($kids * $days * $room->price1)) * ((100 - 0) / 100) * ((100 - $disc) / 100))),
                                                        'facilities' => ['room_id'=>$room->id,
                       'room_name'=>$room->name,
                        'room_facilities'=>$facilities],
                            'symbol' => "€",
                                                    ];
                                                }
                                            }
                                        }
                                        if(!empty($data)&& $status != "nodate"){
                                            $status = "Show Rooms";
                                            array_push($new_array, $data);  
                                        }else{
                                            $status = "No Rooms Aavailable";
                                        }
                                        
                                    }
                                }
                            } else { // Else Condition with no child discounts
                                $rates = RoomRate::join('rates', 'rates.rate_id', 'room_rates.id')
                                    ->where('rates.room_id', $room->id)->get();
                                if (count($rates) > 0) {
                                    foreach ($rates as $rate) {
                                        $package = Package::find($rate->package_id);
    
                                        if ($rate->start_date <= $datefrom && $rate->end_date >= $dateto) {
                                           $status = "date";
                                            if ($str == "tn") {
                                                $data = [
                                                    
                                                    'room' => $room,
                                                    'policies'  => $policies,
                                                    'rate' => $rate,
                                                    'package' => $package,
                                                    'price' => ($adults * $rate->price_per_night2 * $days) + (((($kids * $days * $rate->price_per_night2)) * ((100 - $disc) / 100))),
                                                    'non_refundable' => ($adults * $rate->non_refundable2 * $days) + (((($kids * $days * $rate->non_refundable2)) * ((100 - $disc) / 100))),
                                                    'non_modifiable' => ($adults * $rate->non_modifiable2 * $days) + (((($kids * $days * $rate->non_modifiable2)) * ((100 - $disc) / 100))),
                                                    'prepayment' => ($adults * $rate->prepayment2 * $days) + (((($kids * $days * $rate->prepayment2)) * ((100 - $disc) / 100))),
                                                    'no_advance' => ($adults * $rate->no_advance2 * $days) + (((($kids * $days * $rate->no_advance2)) * ((100 - $disc) / 100))),
                                                    'facilities' => ['room_id'=>$room->id,
                       'room_name'=>$room->name,
                        'room_facilities'=>$facilities],
                        'symbol' => "TND",
                                                ];
                                            } else {
                                                $data = [
                                                    'room' => $room,
                                                    'policies' => $policies,
                                                    'rate' => $rate,
                                                    'package' => $package,
                                                    'price' => ($adults * $rate->price_per_night1 * $days) + (((($kids * $days * $rate->price_per_night1)) * ((100 - $disc) / 100))),
                                                    'non_refundable' => ($adults * $rate->non_refundable1 * $days) + (((($kids * $days * $rate->non_refundable1)) * ((100 - $disc) / 100))),
                                                    'non_modifiable' => ($adults * $rate->non_modifiable1 * $days) + (((($kids * $days * $rate->non_modifiable1)) * ((100 - $disc) / 100))),
                                                    'prepayment' => ($adults * $rate->prepayment1 * $days) + (((($kids * $days * $rate->prepayment1)) * ((100 - $disc) / 100))),
                                                    'no_advance' => ($adults * $rate->no_advance1 * $days) + (((($kids * $days * $rate->no_advance1)) * ((100 - $disc) / 100))),
                                                    'facilities' => ['room_id'=>$room->id,
                       'room_name'=>$room->name,
                        'room_facilities'=>$facilities],
                        'symbol' => "€",
                                                ];
                                            }
                                        } else {
                                            $status = "nodate";
    
                                            if ($str == "tn") {
                                                $data = [
                                                    'room' => $room,
                                                    'policies' => $policies,
                                                    'rate' => $rate,
                                                    'package' => $package,
                                                    'price' => ($adults * $room->price2 * $days) + (((($kids * $days * $room->price2)) * ((100 - $disc) / 100))),
                                                    'facilities' => ['room_id'=>$room->id,
                       'room_name'=>$room->name,
                        'room_facilities'=>$facilities],
                        'symbol' => "TND",
                                                ];
                                            } else {
                                                $data = [
                                                    'room' => $room,
                                                    'policies' => $policies,
                                                    'rate' => $rate,
                                                    'package' => $package,
                                                    'price' => ($adults * $room->price1 * $days) + (((($kids * $days * $room->price1)) * ((100 - $disc) / 100))),
                                                    'facilities' => ['room_id'=>$room->id,
                       'room_name'=>$room->name,
                        'room_facilities'=>$facilities],
                        'symbol' => "€",
                                                ];
                                            }
                                        }
                                        if(!empty($data) && $status != "nodate"){
                                            $status = "Show Rooms";
                                            array_push($new_array, $data);  
                                        }else{
                                            $status = "No Rooms Aavailable";
                                        }
                                        
                                    }
                                }
                            }
                        
                    }
                }
    
            }
                return response()->json([
                    'success'               =>  true,
                    'status'                => $status,
                    'data_array'            =>  $dataarray,
                    'data'                  =>  $new_array,
                    // 'pricing'               =>  $new_pricing
                ], 200);
            
            
        }
    } // END of ROOM Search Room function



    public function choosePackage(Request $request)
    {

        // dd($request->all());

        $ranges_array = session()->get('ranges_array' . $request->room_id);
        // dd($ranges_array);
        $discount = session()->get('discount_room' . $request->room_id);


        $data = session()->get('array_data');
        $datefrom1 = $data['datefrom'];
        $dateto1 = $data['dateto'];

        $dat = session()->get('latlong');
        $response = Http::get('https://nominatim.openstreetmap.org/reverse?format=geojson&lat=36.7394816&lon=10.2039552');
        $str = $response->json()['features'][0]['properties']['address']['country_code'];


        $df = $data['datefrom'];
        $dff = explode("-", $df);
        $df_month = $dff[1];
        $df_day = $dff[2];


        $dt = $data['dateto'];
        $dtt = explode("-", $dt);
        $dt_month = $dtt[1];
        $dt_day = $dtt[2];
        // $df1 = $dff->format('m-d');
        // dd($df1);

        $days = $data['no_of_days'];


        $settings = HomePageSetting::all();
        $setting = $settings[0];

        $n_discounts = NightDiscount::where('datefrom', '<=', $datefrom1)
            ->orWhere('dateto', '>=', $dateto1)
            ->first();
        // dd($n_discounts);
        $disc = 0;
        if ($n_discounts != null) {
            if ($days <= 3) {
                $disc = $n_discounts->discount1;
            } else {
                $disc = $n_discounts->discount2;
            }
        }






        $output = "";
        $i = 0;
        $package_ids = array();
        $package_services = PackageService::all();
        foreach ($package_services as $package_service) {
            array_push($package_ids, $package_service->package_id);
        }
        $ranges = RangePrice::all();



        // dd($date1);


        // $datefrom1 = $df->format('Y-m-d');
        // $dateto1 = $dt->format('Y-m-d');
        // dd($datefrom1);
        $adult = $request->adult;
        $check = "";
        $check1 = "";
        $check2 = "";



        $key = 'bdELPYQYzlqCYrKewn0cwN9tTOjxXvVK';
        $qualityScore = new IPQualityScore($key);
        $ip_address = \Request::ip();
        // $result1 = $qualityScore->IPAddressVerification->getResponse("196.235.250.179");
        // dd($result1);

        $result1 = $qualityScore->IPAddressVerification->getResponse($ip_address);
        // dd($result1);
        $result = $result1->data;

        // $tr = new GoogleTranslate();
        //     if($result['country_code'] == 'TN'){
        //         $tr->setTarget('fr');
        //         $tr->setSource();
        //     }else{
        //         $tr->setTarget('en');
        //         $tr->setSource();
        //     }

        $arr = [];
        $arr1 = [];
        $arr2 = [];
        $arr3 = [];
        $arr4 = [];

        $j = 0;

        foreach ($ranges as $r) {

            $room = Room::find($r->room_id);
        }

        $kid1 = $data['kid1'];
        $kid2 = $data['kid2'];
        $adults = $data['adults'];
        $persons = $adults + $kid1 + $kid2;
        $kids = $kid1 + $kid2;


        $room = Room::find($request->room_id);


        // $range_prices = RangePrice::where('room_id',$room->id)->groupBy('package_id')->select('range_prices.*')->get();
        $range_prices = DB::table('range_prices')
            ->select('id', 'package_id')
            ->where('room_id', $room->id)
            ->groupBy('package_id')
            ->get();
        // dd($range_prices);

        $packages = [];
        foreach ($range_prices as $range_price) {
            $package = Package::find($range_price->package_id);
            array_push($packages, $package);
        }
        // dd($packages->distinct()->get());

        $k = count($packages);
        $s = 1;
        foreach ($packages as $package) {

            // FIRST CONDITION FOR DISCOUNT




            $sp1 =  - ($room->price1 * $persons * $days * $disc) +  ($room->price1 * $persons * $days);

            $sp2 =  - ($room->price2 * $persons * $days * $disc) +  ($room->price2 * $persons * $days);


            // SUPLIMENT CONDITIONS

            if ($data['kid1'] == 0 && $data['adults'] == 1 && $data['kid2'] == 0 && $room->no_of_beds > 1) {



                $range = RangePrice::where('room_id', $room->id)
                    ->where('package_id', $package->id)
                    ->where('datefrom', '<=', $datefrom1)
                    ->where('dateto', '>=', $dateto1)

                    ->get();
                // dd($range);






                $pack_services = PackageService::where('package_id', $package->id)->get();

                // if($request->guest_count <= $package->no_of_guests){
                $output .= '<tr id="packagess" class="packss" style="border-bottom: 1px solid #e4b248;">' .
                    '<td class="padding"><h2 class="pack-name">' . $package->name . '</h2><div class="p_detail">' . $package->detail;

                '</div><h5><b>Facilities</b> </h5>';
                if (!empty($pack_services)) {
                    foreach ($pack_services as $pack_service) {
                        $service = Service::find($pack_service->service_id);
                        if (!empty($service)) {
                            $output .= '<li>' . $service->name . '</li>';
                        }
                    }
                }

                $output .= '</td><td></td>';

                if (count($range) > 0) {
                    foreach ($range as $r) {
                        if ($datefrom1 >= $r->datefrom  && $dateto1 <= $r->dateto) {
                            if (($df_month == "07" && $df_day >= "19" && $dt_month == "07" && $dt_day <= "31")) {
                                // dd($sp);
                                if (count($range) > 0) {
                                    $sp2 = $days * ($r->price2 + (int)50) * ((100 - $disc) / 100);
                                    $sp1 = $days * ($r->price1 + (int)50) * ((100 - $disc) / 100);
                                    if ($str == "tn") {
                                        $output .= '<td> <b><span style="font-weight:900;font-size: 20px;">TND ' . $sp2 . '<span style="font-size:10px">/Total</span></span></b><br><span style="font-size:15px;font-weight:bold;">TND&nbsp;' . $r->price2 . '<span style="font-size:10px">/' . $setting->ppn . '</span></span><br>' . $setting->etax . '<br>';
                                        $output .= '<div class="choose-package" style="color:white;height: 44px;width: 86px;"><a  href="/booknow/' . $package->id . '/' . $request->room_id . '/' . $request->noofrooms . '/' . $sp2 . '"><span class=""><b style="color:white;font-size:18px;margin-left:-3px;">Réserver</b></span></a></div></td>'
                                            . '</tr>';
                                    } else {
                                        $output .= '<td> <b><span style="font-weight:900;font-size: 20px;">€ ' . $sp1 . '<span style="font-size:10px">/Total</span></span></b><br><span style="font-size:15px;font-weight:bold;">€&nbsp;' . $r->price1 . '<span style="font-size:10px">/' . $setting->ppn1 . '</span></span><br>' . $setting->etax1 . '<br>';
                                        $output .= '<div class="choose-package" style="color:white;height: 44px;width: 86px;"><a  href="/booknow/' . $package->id . '/' . $request->room_id . '/' . $request->noofrooms . '/' . $sp1 . '"><span class=""><b style="color:white;font-size:18px;margin-left:-3px;">Réserver</b></span></a></div></td>'
                                            . '</tr>';
                                    }
                                }
                            } else if (($df_month == "08" && $df_day >= "01" && $dt_month == "08" && $dt_day <= "29")) {
                                // dd($r);
                                // dd($range);
                                $sp2 = $days * (($r->price2 + (int)70) * ((100 - $disc) / 100));
                                $sp1 = $days * ($r->price1 + (int)70) * ((100 - $disc) / 100);

                                if ($str == "tn") {


                                    $output .= '<td> <b><span style="font-weight:900;font-size: 20px;">TND ' . $sp2 . '<span style="font-size:10px">/Total</span></span></b><br><span style="font-size:15px;font-weight:bold;">TND&nbsp;' . $r->price2 . '<span style="font-size:10px">/' . $setting->ppn . '</span></span><br>' . $setting->etax . '<br>';
                                    $output .= '<div class="choose-package" style="color:white;height: 44px;width: 86px;"><a  href="/booknow/' . $package->id . '/' . $request->room_id . '/' . $request->noofrooms . '/' . $sp2 . '"><span class=""><b style="color:white;font-size:18px;margin-left:-3px;">Réserver</b></span></a></div></td>'
                                        . '</tr>';
                                } else {
                                    $output .= '<td> <b><span style="font-weight:900;font-size: 20px;">€ ' . $sp1 . '<span style="font-size:10px">/Total</span></span></b><br><span style="font-size:15px;font-weight:bold;">€&nbsp;' . $r->price1 . '<span style="font-size:10px">/' . $setting->ppn1 . '</span></span><br>' . $setting->etax1 . '<br>';
                                    $output .= '<div class="choose-package" style="color:white;height: 44px;width: 86px;"><a  href="/booknow/' . $package->id . '/' . $request->room_id . '/' . $request->noofrooms . '/' . $sp1 . '"><span class=""><b style="color:white;font-size:18px;margin-left:-3px;">Réserver</b></span></a></div></td>'
                                        . '</tr>';
                                }
                            } else if (($df_month >= "08" && $df_day >= "30") && ($dt_month <= "10" && $dt_day <= "31")) {

                                if (count($range) > 0) {
                                    $sp2 = $days * ($r->price2 + (int)50) * ((100 - $disc) / 100);
                                    $sp1 = $days * ($r->price1 + (int)50) * ((100 - $disc) / 100);
                                    if ($str == "tn") {
                                        $output .= '<td> <b><span style="font-weight:900;font-size: 20px;">TND ' . $sp2 . '<span style="font-size:10px">/Total</span></span></b><br><span style="font-size:15px;font-weight:bold;">TND&nbsp;' . $r->price2 . '<span style="font-size:10px">/' . $setting->ppn . '</span></span><br>' . $setting->etax . '<br>';
                                        $output .= '<div class="choose-package" style="color:white;height: 44px;width: 86px;"><a  href="/booknow/' . $package->id . '/' . $request->room_id . '/' . $request->noofrooms . '/' . $sp2 . '"><span class=""><b style="color:white;font-size:18px;margin-left:-3px;">Réserver</b></span></a></div></td>'
                                            . '</tr>';
                                    } else {
                                        $output .= '<td> <b><span style="font-weight:900;font-size: 20px;">€ ' . $sp1 . '<span style="font-size:10px">/Total</span></span></b><br><span style="font-size:15px;font-weight:bold;">€&nbsp;' . $r->price1 . '<span style="font-size:10px">/' . $setting->ppn1 . '</span></span><br>' . $setting->etax1 . '<br>';
                                        $output .= '<div class="choose-package" style="color:white;height: 44px;width: 86px;"><a  href="/booknow/' . $package->id . '/' . $request->room_id . '/' . $request->noofrooms . '/' . $sp1 . '"><span class=""><b style="color:white;font-size:18px;margin-left:-3px;">Réserver</b></span></a></div></td>'
                                            . '</tr>';
                                    }
                                } else {
                                    $sp2 = $days * ($room->price2 + (int)50) * ((100 - $disc) / 100);
                                    $sp1 = $days * ($room->price1 + (int)50) * ((100 - $disc) / 100);
                                    if ($str == "tn") {
                                        $output .= '<td> <b><span style="font-weight:900;font-size: 20px;">TND ' . $sp2 . '<span style="font-size:10px">/Total</span></span></b><br><span style="font-size:15px;font-weight:bold;">TND&nbsp;' . $room->price2 . '<span style="font-size:10px">/' . $setting->ppn . '</span></span><br>' . $setting->etax . '<br>';
                                        $output .= '<div class="choose-package" style="color:white;height: 44px;width: 86px;"><a  href="/booknow/' . $package->id . '/' . $request->room_id . '/' . $request->noofrooms . '/' . $sp2 . '"><span class=""><b style="color:white;font-size:18px;margin-left:-3px;">Réserver</b></span></a></div></td>'
                                            . '</tr>';
                                    } else {
                                        $output .= '<td> <b><span style="font-weight:900;font-size: 20px;">€ ' . $sp1 . '<span style="font-size:10px">/Total</span></span></b><br><span style="font-size:15px;font-weight:bold;">€&nbsp;' . $room->price1 . '<span style="font-size:10px">/' . $setting->ppn1 . '</span></span><br>' . $setting->etax1 . '<br>';
                                        $output .= '<div class="choose-package" style="color:white;height: 44px;width: 86px;"><a  href="/booknow/' . $package->id . '/' . $request->room_id . '/' . $request->noofrooms . '/' . $sp1 . '"><span class=""><b style="color:white;font-size:18px;margin-left:-3px;">Réserver</b></span></a></div></td>'
                                            . '</tr>';
                                    }
                                }
                            }
                        }
                    }
                } else {
                    $sp2 = $days * ($room->price2 + (int)50) * ((100 - $disc) / 100);
                    $sp1 = $days * ($room->price1 + (int)50) * ((100 - $disc) / 100);
                    if ($str == "tn") {
                        $output .= '<td> <b><span style="font-weight:900;font-size: 20px;">TND ' . $sp2 . '<span style="font-size:10px">/Total</span></span></b><br><span style="font-size:15px;font-weight:bold;">TND&nbsp;' . $room->price2 . '<span style="font-size:10px">/' . $setting->ppn . '</span></span><br>' . $setting->etax . '<br>';
                        $output .= '<div class="choose-package" style="color:white;height: 44px;width: 86px;"><a  href="/booknow/' . $package->id . '/' . $request->room_id . '/' . $request->noofrooms . '/' . $sp2 . '"><span class=""><b style="color:white;font-size:18px;margin-left:-3px;">Réserver</b></span></a></div></td>'
                            . '</tr>';
                    } else {
                        $output .= '<td> <b><span style="font-weight:900;font-size: 20px;">€ ' . $sp1 . '<span style="font-size:10px">/Total</span></span></b><br><span style="font-size:15px;font-weight:bold;">€&nbsp;' . $room->price1 . '<span style="font-size:10px">/' . $setting->ppn1 . '</span></span><br>' . $setting->etax1 . '<br>';
                        $output .= '<div class="choose-package" style="color:white;height: 44px;width: 86px;"><a  href="/booknow/' . $package->id . '/' . $request->room_id . '/' . $request->noofrooms . '/' . $sp1 . '"><span class=""><b style="color:white;font-size:18px;margin-left:-3px;">Réserver</b></span></a></div></td>'
                            . '</tr>';
                    }
                }
            }


            // SUPLIMENT CONDITIONS END




            if ($data['kid1'] == 1 && $data['adults'] <= 2 && $data['kid2'] == 0) {

                // $r = DateRangePackage::where('daterange_id', $range_array->id)->first();

                $range = RangePrice::where('room_id', $room->id)
                    ->where('package_id', $package->id)
                    ->where('datefrom', '<=', $datefrom1)
                    ->where('dateto', '>=', $dateto1)

                    ->get();
                // dd($range);








                $s_p_1 = ($data['adults'] * $room->price1 * $days) + (((($kids * $days * $room->price1)) * ((100 - $discount[0]->discount) / 100) * ((100 - $disc) / 100)));
                $s_p_2 = ($data['adults'] * $room->price2 * $days) + (((($kids * $days * $room->price2)) * ((100 - $discount[0]->discount) / 100) * ((100 - $disc) / 100)));





                $pack_services = PackageService::where('package_id', $package->id)->get();

                // if($request->guest_count <= $package->no_of_guests){
                $output .= '<tr id="packagess" style="border-bottom: 1px solid #e4b248;">' .
                    '<td class="padding"><h2>' . $package->name . '</h2><div class="p_detail">' . $package->detail;

                '</div><h5><b>Facilities</b> </h5>';
                if (!empty($pack_services)) {
                    foreach ($pack_services as $pack_service) {
                        $service = Service::find($pack_service->service_id);
                        if (!empty($service)) {
                            $output .= '<li>' . $service->name . '</li>';
                        }
                    }
                }

                $output .= '</td><td></td>';


                // if (in_array($r->package_id, $arr)) {
                //     break;
                //     }

                $found = 0;
                // dd($range);
                if (count($range) > 0) {
                    foreach ($range as $r) {




                        // $r_p_1 = - ($r->price1 * $persons * $days * $disc) +  ($r->price1 * $persons * $days) - ((($r->price1 * $kid1) * $discount[0]->discount) / 100);
                        // $r_p_2 = - ($r->price2 * $persons * $days * $disc) +  ($r->price2 * $persons * $days) - ((($r->price2 * $kid1) * $discount[0]->discount) / 100);
                        $r_p_1 = ($data['adults'] * $r->price1 * $days) + (($kids * $days * $r->price1) * ((100 - $discount[0]->discount) / 100) * ((100 - $disc) / 100));
                        $r_p_2 = ($data['adults'] * $r->price2 * $days) + (($kids * $days * $r->price2) * ((100 - $discount[0]->discount) / 100) * ((100 - $disc) / 100));


                        if ($datefrom1 >= $r->datefrom  && $dateto1 <= $r->dateto) {

                            if ($discount[0]->discount == null) {
                                $discount[0]->discount = 0;
                            }


                            // dd($arr);
                            // $output.='<p><b> Price : </b> '.($result['country_code'] == "UAE" ? $r->package_price2 * $adult . " TND" : $r->package_price1 * $adult . " €").'</p>';

                            if ($str == "tn") {
                                $output .= '<td> <b><span style="font-weight:900;font-size: 20px;">TND ' . $r_p_2 . '<span style="font-size:10px">/' . $setting->total . '</span></span></b><br><span style="font-size:15px;font-weight:bold;">TND&nbsp;' . $r->price2 . '<span style="font-size:10px">/' . $setting->ppn . '</span></span><br>' . $setting->etax . '<br>';
                                $output .= '<div class="choose-package" style="color:white;height: 44px;width: 86px;"><a  href="/booknow/' . $package->id . '/' . $request->room_id . '/' . $request->noofrooms . '/' . $r_p_2 . '"><span class=""><b style="color:white;font-size:18px;margin-left:-3px;">Réserver</b></span></a></div></td>'
                                    . '</tr>';
                            } else {
                                $output .= '<td> <b><span style="font-weight:900;font-size: 20px;">€' . $r_p_1 . '<span style="font-size:10px">/' . $setting->total1 . '</span></span></b><br><span style="font-size:15px;font-weight:bold;">€&nbsp;' . $r->price1 . '<span style="font-size:10px">/' . $setting->ppn1 . '</span></span><br>' . $setting->etax1 . '<br>';
                                $output .= '<div class="choose-package" style="color:white;height: 44px;width: 86px;"><a  href="/booknow/' . $package->id . '/' . $request->room_id . '/' . $request->noofrooms . '/' . $r_p_1  . '"><span class=""><b style="color:white;font-size:18px;margin-left:-3px;">Réserver</b></span></a></div></td>'
                                    . '</tr>';
                            }
                        } else {

                            if ($str == "tn") {
                                $output .= '<td> <b><span style="font-weight:900;font-size: 20px;">TND ' . $s_p_2 . '<span style="font-size:10px">/' . $setting->total . '</span></span></b><br><span style="font-size:15px;font-weight:bold;">TND&nbsp;' . $room->price2 . '<span style="font-size:10px">/' . $setting->ppn . '</span></span><br>' . $setting->etax . '<br>';
                                $output .= '<div class="choose-package" style="color:white;height: 44px;width: 86px;"><a  href="/booknow/' . $package->id . '/' . $request->room_id . '/' . $request->noofrooms . '/' . $s_p_2 . '"><span class=""><b style="color:white;font-size:18px;margin-left:-3px;"> Réserver</b></span></a></div></td>'
                                    . '</tr>';
                            } else {
                                $output .= '<td> <b><span style="font-weight:900;font-size: 20px;"> €' . $s_p_1 . '<span style="font-size:10px">/' . $setting->total1 . '</span></span></b><br><span style="font-size:15px;font-weight:bold;">€&nbsp;' . $room->price1 . '<span style="font-size:10px">/' . $setting->ppn1 . '</span></span><br>' . $setting->etax1 . '<br>';
                                $output .= '<div class="choose-package" style="color:white;height: 44px;width: 86px;"><a  href="/booknow/' . $package->id . '/' . $request->room_id . '/' . $request->noofrooms . '/' . $s_p_1 . '"><span class="" ><b style="color:white;font-size:18px;margin-left:-3px;"> Réserver</b></span></a></div></td>'
                                    . '</tr><hr>';
                            }
                        }
                    }
                } else {

                    if ($str == "tn") {
                        $output .= '<td> <b><span style="font-weight:900;font-size: 20px;">TND ' . $s_p_2 . '<span style="font-size:10px">/' . $setting->total . '</span></span></b><br><span style="font-size:15px;font-weight:bold;">TND&nbsp;' . $room->price2 . '<span style="font-size:10px">/' . $setting->ppn . '</span></span><br>' . $setting->etax . '<br>';
                        $output .= '<div class="choose-package" style="color:white;height: 44px;width: 86px;"><a  href="/booknow/' . $package->id . '/' . $request->room_id . '/' . $request->noofrooms . '/' . $s_p_2 . '"><span class=""><b style="color:white;font-size:18px;margin-left:-3px;"> Réserver</b></span></a></div></td>'
                            . '</tr>';
                    } else {
                        $output .= '<td> <b><span style="font-weight:900;font-size: 20px;"> €' . $s_p_1 . '<span style="font-size:10px">/' . $setting->total1 . '</span></span></b><br><span style="font-size:15px;font-weight:bold;">€&nbsp;' . $room->price1 . '<span style="font-size:10px">/' . $setting->ppn1 . '</span></span><br>' . $setting->etax1 . '<br>';
                        $output .= '<div class="choose-package" style="color:white;height: 44px;width: 86px;"><a  href="/booknow/' . $package->id . '/' . $request->room_id . '/' . $request->noofrooms . '/' . $s_p_1 . '"><span class="" ><b style="color:white;font-size:18px;margin-left:-3px;"> Réserver</b></span></a></div></td>'
                            . '</tr><hr>';
                    }
                }


                // $output.='<p><b> Price :</b> '.($result['country_code'] == "UAE" ? $r->normal_price2 * $adult . " TND" : $r->normal_price1 * $adult . " €").'</p>';


                $i++;
                // }


                // if (in_array($range_price->package_id, $arr)) {
                //     break;
                // }
                // array_push($arr, $range_price->package_id);









                // 2nd CONDITION FOR DISCOUNT
            } else if ($data['kid2'] == 1 && $data['kid1'] == 0 && $data['adults'] <= 2) {
                $range = RangePrice::where('room_id', $room->id)
                    ->where('package_id', $package->id)
                    ->where('datefrom', '<=', $datefrom1)
                    ->where('dateto', '>=', $dateto1)

                    ->get();


                // dd($range);

                if (!empty($discount[1]->discount)) {
                    $s_p_1 = ($data['adults'] * $room->price1 * $days) + (((($kids * $days * $room->price1)) * ((100 - $discount[1]->discount) / 100) * ((100 - $disc) / 100)));
                    $s_p_2 = ($data['adults'] * $room->price2 * $days) + (((($kids * $days * $room->price2)) * ((100 - $discount[1]->discount) / 100) * ((100 - $disc) / 100)));
                } else {
                    $s_p_1 = ($data['adults'] * $room->price1 * $days) + (((($kids * $days * $room->price1)) * ((100 - 0) / 100) * ((100 - $disc) / 100)));
                    $s_p_2 = ($data['adults'] * $room->price2 * $days) + (((($kids * $days * $room->price2)) * ((100 - 0) / 100) * ((100 - $disc) / 100)));
                }


                // dd(($room->price1 * $kid1) - (($room->price1 * $kid1) * $discount[0]->discount)/100);




                $pack_services = PackageService::where('package_id', $package->id)->get();

                // if($request->guest_count <= $package->no_of_guests){
                $output .= '<tr id="packagess" style="border-bottom: 1px solid #e4b248;">' .
                    '<td class="padding"><h2>' . $package->name . '</h2><div class="p_detail">' . $package->detail;

                '</div><b>Facilities</b> </h5>';
                foreach ($pack_services as $pack_service) {
                    $service = Service::find($pack_service->service_id);
                    if (!empty($service)) {
                        $output .= '<li>' . $service->name . '</li>';
                    }
                }
                $output .= '</td><td></td>';


                // if (in_array($r->package_id, $arr)) {
                //     break;
                //     }

                $found = 0;
                if (count($range) > 0) {
                    foreach ($range as $r) {




                        if (!empty($discount[3]->discount)) {
                            $r_p_1 = ($data['adults'] * $r->price1 * $days) + (((($kids * $days * $r->price1)) * ((100 - $discount[1]->discount) / 100) * ((100 - $disc) / 100)));
                            $r_p_2 = ($data['adults'] * $r->price2 * $days) + (((($kids * $days * $r->price2)) * ((100 - $discount[1]->discount) / 100) * ((100 - $disc) / 100)));
                        } else {
                            $r_p_1 = ($data['adults'] * $room->price1 * $days) + (((($kids * $days * $r->price1)) * ((100 - 0) / 100) * ((100 - $disc) / 100)));
                            $r_p_2 = ($data['adults'] * $r->price2 * $days) + (((($kids * $days * $r->price2)) * ((100 - 0) / 100) * ((100 - $disc) / 100)));
                        }

                        if ($datefrom1 >= $r->datefrom  && $dateto1 <= $r->dateto) {

                            if ($discount[1]->discount == null) {
                                $discount[1]->discount = 0;
                            }


                            // dd($arr);
                            // $output.='<p><b> Price : </b> '.($result['country_code'] == "UAE" ? $r->package_price2 * $adult . " TND" : $r->package_price1 * $adult . " €").'</p>';

                            if ($str == "tn") {
                                $output .= '<td> <b><span style="font-weight:900;font-size: 20px;">TND ' . $r_p_2 . '<span style="font-size:10px">/' . $setting->total . '</span></span></b><br><span style="font-size:15px;font-weight:bold;">TND&nbsp;' . $r->price2 . '<span style="font-size:10px">/' . $setting->ppn . '</span></span><br>' . $setting->etax . '<br>';
                                $output .= '<div class="choose-package" style="color:white;height: 44px;width: 86px;"><a  href="/booknow/' . $package->id . '/' . $request->room_id . '/' . $request->noofrooms . '/' . $r_p_2 . '"><span class=""><b style="color:white;font-size:18px;margin-left:-3px;">Réserver</b></span></a></div></td>'
                                    . '</tr>';
                            } else {
                                $output .= '<td> <b><span style="font-weight:900;font-size: 20px;">€' . $r_p_1 . '<span style="font-size:10px">/' . $setting->total1 . '</span></span></b><br><span style="font-size:15px;font-weight:bold;">€&nbsp;' . $r->price1 . '<span style="font-size:10px">/' . $setting->ppn1 . '</span></span><br>' . $setting->etax1 . '<br>';
                                $output .= '<div class="choose-package" style="color:white;height: 44px;width: 86px;"><a  href="/booknow/' . $package->id . '/' . $request->room_id . '/' . $request->noofrooms . '/' . $r_p_1  . '"><span class=""><b style="color:white;font-size:18px;margin-left:-3px;">Réserver</b></span></a></div></td>'
                                    . '</tr>';
                            }
                        } else {

                            if ($str == "tn") {
                                $output .= '<td> <b><span style="font-weight:900;font-size: 20px;">TND ' . $s_p_2 . '<span style="font-size:10px">/' . $setting->total . '</span></span></b><br><span style="font-size:15px;font-weight:bold;">TND&nbsp;' . $room->price2 . '<span style="font-size:10px">/' . $setting->ppn . '</span></span><br>' . $setting->etax . '<br>';
                                $output .= '<div class="choose-package" style="color:white;height: 44px;width: 86px;"><a  href="/booknow/' . $package->id . '/' . $request->room_id . '/' . $request->noofrooms . '/' . $s_p_2 . '"><span class=""><b style="color:white;font-size:18px;margin-left:-3px;"> Réserver</b></span></a></div></td>'
                                    . '</tr>';
                            } else {
                                $output .= '<td> <b><span style="font-weight:900;font-size: 20px;"> €' . $s_p_1 . '<span style="font-size:10px">/' . $setting->total1 . '</span></span></b><br><span style="font-size:15px;font-weight:bold;">€&nbsp;' . $room->price1 . '<span style="font-size:10px">/' . $setting->ppn1 . '</span></span><br>' . $setting->etax1 . '<br>';
                                $output .= '<div class="choose-package" style="color:white;height: 44px;width: 86px;"><a  href="/booknow/' . $package->id . '/' . $request->room_id . '/' . $request->noofrooms . '/' . $s_p_1 . '"><span class="" ><b style="color:white;font-size:18px;margin-left:-3px;"> Réserver</b></span></a></div></td>'
                                    . '</tr><hr>';
                            }
                        }
                    }
                } else {
                    if ($str == "tn") {
                        $output .= '<td> <b><span style="font-weight:900;font-size: 20px;">TND ' . $s_p_2 . '<span style="font-size:10px">/' . $setting->total . '</span></span></b><br><span style="font-size:15px;font-weight:bold;">TND&nbsp;' . $room->price2 . '<span style="font-size:10px">/' . $setting->ppn . '</span></span><br>' . $setting->etax . '<br>';
                        $output .= '<div class="choose-package" style="color:white;height: 44px;width: 86px;"><a  href="/booknow/' . $package->id . '/' . $request->room_id . '/' . $request->noofrooms . '/' . $s_p_2 . '"><span class=""><b style="color:white;font-size:18px;margin-left:-3px;"> Réserver</b></span></a></div></td>'
                            . '</tr>';
                    } else {
                        $output .= '<td> <b><span style="font-weight:900;font-size: 20px;"> €' . $s_p_1 . '<span style="font-size:10px">/' . $setting->total1 . '</span></span></b><br><span style="font-size:15px;font-weight:bold;">€&nbsp;' . $room->price1 . '<span style="font-size:10px">/' . $setting->ppn1 . '</span></span><br>' . $setting->etax1 . '<br>';
                        $output .= '<div class="choose-package" style="color:white;height: 44px;width: 86px;"><a  href="/booknow/' . $package->id . '/' . $request->room_id . '/' . $request->noofrooms . '/' . $s_p_1 . '"><span class="" ><b style="color:white;font-size:18px;margin-left:-3px;"> Réserver</b></span></a></div></td>'
                            . '</tr><hr>';
                    }
                }

                // 3rd CONDITION FOR DISCOUNT
            } else if (($data['kid2'] == 1 || $data['kid2'] == 2) && ($data['kid1'] == 0 && $data['adults'] == 1)) {

                $range = RangePrice::where('room_id', $room->id)
                    ->where('package_id', $package->id)
                    ->where('datefrom', '<=', $datefrom1)
                    ->where('dateto', '>=', $dateto1)

                    ->get();

                // dd($range);

                if (!empty($discount[2]->discount)) {
                    $s_p_1 = ($data['adults'] * $room->price1 * $days) + (((($kids * $days * $room->price1)) * ((100 - $discount[2]->discount) / 100) * ((100 - $disc) / 100)));
                    $s_p_2 = ($data['adults'] * $room->price2 * $days) + (((($kids * $days * $room->price2)) * ((100 - $discount[2]->discount) / 100) * ((100 - $disc) / 100)));
                } else {
                    $s_p_1 = ($data['adults'] * $room->price1 * $days) + (((($kids * $days * $room->price1)) * ((100 - 0) / 100) * ((100 - $disc) / 100)));
                    $s_p_2 = ($data['adults'] * $room->price2 * $days) + (((($kids * $days * $room->price2)) * ((100 - 0) / 100) * ((100 - $disc) / 100)));
                }




                $pack_services = PackageService::where('package_id', $package->id)->get();

                // if($request->guest_count <= $package->no_of_guests){
                $output .= '<tr id="packagess" style="border-bottom: 1px solid #e4b248;">' .
                    '<td class="padding"><h2>' . $package->name . '</h2><div class="p_detail">' . $package->detail;

                '</div><b>Facilities</b> </h5>';
                foreach ($pack_services as $pack_service) {
                    $service = Service::find($pack_service->service_id);
                    if (!empty($service)) {
                        $output .= '<li>' . $service->name . '</li>';
                    }
                }
                $output .= '</td><td></td>';


                // if (in_array($r->package_id, $arr)) {
                //     break;
                //     }

                $found = 0;
                if (count($range) > 0) {
                    foreach ($range as $r) {


                        if (!empty($discount[3]->discount)) {
                            $r_p_1 = ($data['adults'] * $r->price1 * $days) + (((($kids * $days * $r->price1)) * ((100 - $discount[2]->discount) / 100) * ((100 - $disc) / 100)));
                            $r_p_2 = ($data['adults'] * $r->price2 * $days) + (((($kids * $days * $r->price2)) * ((100 - $discount[2]->discount) / 100) * ((100 - $disc) / 100)));
                        } else {
                            $r_p_1 = ($data['adults'] * $r->price1 * $days) + (((($kids * $days * $r->price1)) * ((100 - 0) / 100) * ((100 - $disc) / 100)));
                            $r_p_2 = ($data['adults'] * $r->price2 * $days) + (((($kids * $days * $r->price2)) * ((100 - 0) / 100) * ((100 - $disc) / 100)));
                        }

                        if ($datefrom1 >= $r->datefrom  && $dateto1 <= $r->dateto) {

                            if ($discount[0]->discount == null) {
                                $discount[0]->discount = 0;
                            }


                            // dd($arr);
                            // $output.='<p><b> Price : </b> '.($result['country_code'] == "UAE" ? $r->package_price2 * $adult . " TND" : $r->package_price1 * $adult . " €").'</p>';

                            if ($str == "tn") {
                                $output .= '<td> <b><span style="font-weight:900;font-size: 20px;">TND ' . $r_p_2 . '<span style="font-size:10px">/' . $setting->total . '</span></span></b><br><span style="font-size:15px;font-weight:bold;">TND&nbsp;' . $r->price2 . '<span style="font-size:10px">/' . $setting->ppn . '</span></span><br>' . $setting->etax . '<br>';
                                $output .= '<div class="choose-package" style="color:white;height: 44px;width: 86px;"><a  href="/booknow/' . $package->id . '/' . $request->room_id . '/' . $request->noofrooms . '/' . $r_p_2 . '"><span class=""><b style="color:white;font-size:18px;margin-left:-3px;">Réserver</b></span></a></div></td>'
                                    . '</tr>';
                            } else {
                                $output .= '<td> <b><span style="font-weight:900;font-size: 20px;">€' . $r_p_1 . '<span style="font-size:10px">/' . $setting->total1 . '</span></span></b><br><span style="font-size:15px;font-weight:bold;">€&nbsp;' . $r->price1 . '<span style="font-size:10px">/' . $setting->ppn1 . '</span></span><br>' . $setting->etax1 . '<br>';
                                $output .= '<div class="choose-package" style="color:white;height: 44px;width: 86px;"><a  href="/booknow/' . $package->id . '/' . $request->room_id . '/' . $request->noofrooms . '/' . $r_p_1  . '"><span class=""><b style="color:white;font-size:18px;margin-left:-3px;">Réserver</b></span></a></div></td>'
                                    . '</tr>';
                            }
                        } else {

                            if ($str == "tn") {
                                $output .= '<td> <b><span style="font-weight:900;font-size: 20px;">TND ' . $s_p_2 . '<span style="font-size:10px">/' . $setting->total . '</span></span></b><br><span style="font-size:15px;font-weight:bold;">TND&nbsp;' . $room->price2 . '<span style="font-size:10px">/' . $setting->ppn . '</span></span><br>' . $setting->etax . '<br>';
                                $output .= '<div class="choose-package" style="color:white;height: 44px;width: 86px;"><a  href="/booknow/' . $package->id . '/' . $request->room_id . '/' . $request->noofrooms . '/' . $s_p_2 . '"><span class=""><b style="color:white;font-size:18px;margin-left:-3px;"> Réserver</b></span></a></div></td>'
                                    . '</tr>';
                            } else {
                                $output .= '<td> <b><span style="font-weight:900;font-size: 20px;"> €' . $s_p_1 . '<span style="font-size:10px">/' . $setting->total1 . '</span></span></b><br><span style="font-size:15px;font-weight:bold;">€&nbsp;' . $room->price1 . '<span style="font-size:10px">/' . $setting->ppn1 . '</span></span><br>' . $setting->etax1 . '<br>';
                                $output .= '<div class="choose-package" style="color:white;height: 44px;width: 86px;"><a  href="/booknow/' . $package->id . '/' . $request->room_id . '/' . $request->noofrooms . '/' . $s_p_1 . '"><span class="" ><b style="color:white;font-size:18px;margin-left:-3px;"> Réserver</b></span></a></div></td>'
                                    . '</tr><hr>';
                            }
                        }
                    }
                } else {

                    if ($str == "tn") {
                        $output .= '<td> <b><span style="font-weight:900;font-size: 20px;">TND ' . $s_p_2 . '<span style="font-size:10px">/' . $setting->total . '</span></span></b><br><span style="font-size:15px;font-weight:bold;">TND&nbsp;' . $room->price2 . '<span style="font-size:10px">/' . $setting->ppn . '</span></span><br>' . $setting->etax . '<br>';
                        $output .= '<div class="choose-package" style="color:white;height: 44px;width: 86px;"><a  href="/booknow/' . $package->id . '/' . $request->room_id . '/' . $request->noofrooms . '/' . $s_p_2 . '"><span class=""><b style="color:white;font-size:18px;margin-left:-3px;"> Réserver</b></span></a></div></td>'
                            . '</tr>';
                    } else {
                        $output .= '<td> <b><span style="font-weight:900;font-size: 20px;"> €' . $s_p_1 . '<span style="font-size:10px">/' . $setting->total1 . '</span></span></b><br><span style="font-size:15px;font-weight:bold;">€&nbsp;' . $room->price1 . '<span style="font-size:10px">/' . $setting->ppn1 . '</span></span><br>' . $setting->etax1 . '<br>';
                        $output .= '<div class="choose-package" style="color:white;height: 44px;width: 86px;"><a  href="/booknow/' . $package->id . '/' . $request->room_id . '/' . $request->noofrooms . '/' . $s_p_1 . '"><span class="" ><b style="color:white;font-size:18px;margin-left:-3px;"> Réserver</b></span></a></div></td>'
                            . '</tr><hr>';
                    }
                }

                // }


                // 4th CONDITION FOR DISCOUNT
            } else if (($data['kid2'] == 1 || $data['kid2'] == 2 || $data['kid2'] == 3) && ($data['adults'] < 1 && $data['kid1'] == 0)) {

                $range = RangePrice::where('room_id', $room->id)
                    ->where('package_id', $package->id)
                    ->where('datefrom', '<=', $datefrom1)
                    ->where('dateto', '>=', $dateto1)

                    ->get();

                // dd($range);


                if (!empty($discount[3]->discount)) {
                    $s_p_1 = ($data['adults'] * $room->price1 * $days) + (((($kids * $days * $room->price1)) * ((100 - $discount[3]->discount) / 100) * ((100 - $disc) / 100)));
                    $s_p_2 = ($data['adults'] * $room->price2 * $days) + (((($kids * $days * $room->price2)) * ((100 - $discount[3]->discount) / 100) * ((100 - $disc) / 100)));
                } else {
                    $s_p_1 = ($data['adults'] * $room->price1 * $days) + (((($kids * $days * $room->price1)) * ((100 - 0) / 100) * ((100 - $disc) / 100)));
                    $s_p_2 = ($data['adults'] * $room->price2 * $days) + (((($kids * $days * $room->price2)) * ((100 - 0) / 100) * ((100 - $disc) / 100)));
                }




                $pack_services = PackageService::where('package_id', $package->id)->get();

                // if($request->guest_count <= $package->no_of_guests){
                $output .= '<tr id="packagess" style="border-bottom: 1px solid #e4b248;">' .
                    '<td class="padding"><h2>' . $package->name . '</h2><div class="p_detail">' . $package->detail;

                '</div><b>Facilities</b> </h5>';
                foreach ($pack_services as $pack_service) {
                    $service = Service::find($pack_service->service_id);
                    if (!empty($service)) {
                        $output .= '<li>' . $service->name . '</li>';
                    }
                }
                $output .= '</td><td></td>';


                // if (in_array($r->package_id, $arr)) {
                //     break;
                //     }

                $found = 0;
                if (count($range) > 0) {
                    foreach ($range as $r) {




                        if (!empty($discount[3]->discount)) {
                            $r_p_1 = ($data['adults'] * $r->price1 * $days) + (((($kids * $days * $r->price1)) * ((100 - $discount[3]->discount) / 100) * ((100 - $disc) / 100)));
                            $r_p_2 = ($data['adults'] * $r->price2 * $days) + (((($kids * $days * $r->price2)) * ((100 - $discount[3]->discount) / 100) * ((100 - $disc) / 100)));
                        } else {
                            $r_p_1 = ($data['adults'] * $r->price1 * $days) + (((($kids * $days * $r->price1)) * ((100 - 0) / 100) * ((100 - $disc) / 100)));
                            $r_p_2 = ($data['adults'] * $r->price2 * $days) + (((($kids * $days * $r->price2)) * ((100 - 0) / 100) * ((100 - $disc) / 100)));
                        }

                        if ($datefrom1 >= $r->datefrom  && $dateto1 <= $r->dateto) {

                            if ($discount[0]->discount == null) {
                                $discount[0]->discount = 0;
                            }


                            // dd($arr);
                            // $output.='<p><b> Price : </b> '.($result['country_code'] == "UAE" ? $r->package_price2 * $adult . " TND" : $r->package_price1 * $adult . " €").'</p>';

                            if ($str == "tn") {
                                $output .= '<td> <b><span style="font-weight:900;font-size: 20px;">TND ' . $r_p_2 . '<span style="font-size:10px">/' . $setting->total . '</span></span></b><br><span style="font-size:15px;font-weight:bold;">TND&nbsp;' . $r->price2 . '<span style="font-size:10px">/' . $setting->ppn . '</span></span><br>' . $setting->etax . '<br>';
                                $output .= '<div class="choose-package" style="color:white;height: 44px;width: 86px;"><a  href="/booknow/' . $package->id . '/' . $request->room_id . '/' . $request->noofrooms . '/' . $r_p_2 . '"><span class=""><b style="color:white;font-size:18px;margin-left:-3px;">Réserver</b></span></a></div></td>'
                                    . '</tr>';
                            } else {
                                $output .= '<td> <b><span style="font-weight:900;font-size: 20px;">€' . $r_p_1 . '<span style="font-size:10px">/' . $setting->total1 . '</span></span></b><br><span style="font-size:15px;font-weight:bold;">€&nbsp;' . $r->price1 . '<span style="font-size:10px">/' . $setting->ppn1 . '</span></span><br>' . $setting->etax1 . '<br>';
                                $output .= '<div class="choose-package" style="color:white;height: 44px;width: 86px;"><a  href="/booknow/' . $package->id . '/' . $request->room_id . '/' . $request->noofrooms . '/' . $r_p_1  . '"><span class=""><b style="color:white;font-size:18px;margin-left:-3px;">Réserver</b></span></a></div></td>'
                                    . '</tr>';
                            }
                        } else {

                            if ($str == "tn") {
                                $output .= '<td> <b><span style="font-weight:900;font-size: 20px;">TND ' . $s_p_2 . '<span style="font-size:10px">/' . $setting->total . '</span></span></b><br><span style="font-size:15px;font-weight:bold;">TND&nbsp;' . $room->price2 . '<span style="font-size:10px">/' . $setting->ppn . '</span></span><br>' . $setting->etax . '<br>';
                                $output .= '<div class="choose-package" style="color:white;height: 44px;width: 86px;"><a  href="/booknow/' . $package->id . '/' . $request->room_id . '/' . $request->noofrooms . '/' . $s_p_2 . '"><span class=""><b style="color:white;font-size:18px;margin-left:-3px;"> Réserver</b></span></a></div></td>'
                                    . '</tr>';
                            } else {
                                $output .= '<td> <b><span style="font-weight:900;font-size: 20px;"> €' . $s_p_1 . '<span style="font-size:10px">/' . $setting->total1 . '</span></span></b><br><span style="font-size:15px;font-weight:bold;">€&nbsp;' . $room->price1 . '<span style="font-size:10px">/' . $setting->ppn1 . '</span></span><br>' . $setting->etax1 . '<br>';
                                $output .= '<div class="choose-package" style="color:white;height: 44px;width: 86px;"><a  href="/booknow/' . $package->id . '/' . $request->room_id . '/' . $request->noofrooms . '/' . $s_p_1 . '"><span class="" ><b style="color:white;font-size:18px;margin-left:-3px;"> Réserver</b></span></a></div></td>'
                                    . '</tr><hr>';
                            }
                        }
                    }
                } else {

                    if ($str == "tn") {
                        $output .= '<td> <b><span style="font-weight:900;font-size: 20px;">TND ' . $s_p_2 . '<span style="font-size:10px">/' . $setting->total . '</span></span></b><br><span style="font-size:15px;font-weight:bold;">TND&nbsp;' . $room->price2 . '<span style="font-size:10px">/' . $setting->ppn . '</span></span><br>' . $setting->etax . '<br>';
                        $output .= '<div class="choose-package" style="color:white;height: 44px;width: 86px;"><a  href="/booknow/' . $package->id . '/' . $request->room_id . '/' . $request->noofrooms . '/' . $s_p_2 . '"><span class=""><b style="color:white;font-size:18px;margin-left:-3px;"> Réserver</b></span></a></div></td>'
                            . '</tr>';
                    } else {
                        $output .= '<td> <b><span style="font-weight:900;font-size: 20px;"> €' . $s_p_1 . '<span style="font-size:10px">/' . $setting->total1 . '</span></span></b><br><span style="font-size:15px;font-weight:bold;">€&nbsp;' . $room->price1 . '<span style="font-size:10px">/' . $setting->ppn1 . '</span></span><br>' . $setting->etax1 . '<br>';
                        $output .= '<div class="choose-package" style="color:white;height: 44px;width: 86px;"><a  href="/booknow/' . $package->id . '/' . $request->room_id . '/' . $request->noofrooms . '/' . $s_p_1 . '"><span class="" ><b style="color:white;font-size:18px;margin-left:-3px;"> Réserver</b></span></a></div></td>'
                            . '</tr><hr>';
                    }
                }
            } else if ($data['adults'] != 1) {

                $range = RangePrice::where('room_id', $room->id)
                    ->where('package_id', $package->id)
                    ->where('datefrom', '<=', $datefrom1)
                    ->where('dateto', '>=', $dateto1)

                    ->get();

                // if($s == 2){
                //     dd($package);

                // }
                // $s++;

                $sp1 = ($data['adults'] * $room->price1 * $days) + (((($kids * $days * $room->price1))  * ((100 - $disc) / 100)));
                $sp2 = ($data['adults'] * $room->price2 * $days) + (((($kids * $days * $room->price2)) * ((100 - $disc) / 100)));


                // dd(($room->price1 * $kid1) - (($room->price1 * $kid1) * $discount[0]->discount)/100);




                $pack_services = PackageService::where('package_id', $package->id)->get();

                // if($request->guest_count <= $package->no_of_guests){
                $output .= '<tr id="packagess" style="border-bottom: 1px solid #e4b248;">' .
                    '<td class="padding"><h2>' . $package->name . '</h2><div class="p_detail">' . $package->detail;

                '</div><b>Facilities</b> </h5>';
                foreach ($pack_services as $pack_service) {
                    $service = Service::find($pack_service->service_id);
                    if (!empty($service)) {
                        $output .= '<li>' . $service->name . '</li>';
                    }
                }
                $output .= '</td><td></td>';


                // if (in_array($r->package_id, $arr)) {
                //     break;
                //     }

                $found = 0;
                if (count($range) > 0) {
                    foreach ($range as $r) {




                        $r_p_1 = ($data['adults'] * $r->price1 * $days) + (((($kids * $days * $r->price1))  * ((100 - $disc) / 100)));
                        $r_p_2 = ($data['adults'] * $r->price2 * $days) + (((($kids * $days * $r->price2)) * ((100 - $disc) / 100)));


                        if ($datefrom1 >= $r->datefrom  && $dateto1 <= $r->dateto) {

                            if ($discount[0]->discount == null) {
                                $discount[0]->discount = 0;
                            }


                            // dd($arr);
                            // $output.='<p><b> Price : </b> '.($result['country_code'] == "UAE" ? $r->package_price2 * $adult . " TND" : $r->package_price1 * $adult . " €").'</p>';

                            if ($str == "tn") {
                                $output .= '<td> <b><span style="font-weight:900;font-size: 20px;">TND ' . $r_p_2 . '<span style="font-size:10px">/' . $setting->total . '</span></span></b><br><span style="font-size:15px;font-weight:bold;">TND&nbsp;' . $r->price2 . '<span style="font-size:10px">/' . $setting->ppn . '</span></span><br>' . $setting->etax . '<br>';
                                $output .= '<div class="choose-package" style="color:white;height: 44px;width: 86px;"><a  href="/booknow/' . $package->id . '/' . $request->room_id . '/' . $request->noofrooms . '/' . $r_p_2 . '"><span class=""><b style="color:white;font-size:18px;margin-left:-3px;">Réserver</b></span></a></div></td>'
                                    . '</tr>';
                            } else {
                                $output .= '<td> <b><span style="font-weight:900;font-size: 20px;">€' . $r_p_1 . '<span style="font-size:10px">/' . $setting->total1 . '</span></span></b><br><span style="font-size:15px;font-weight:bold;">€&nbsp;' . $r->price1 . '<span style="font-size:10px">/' . $setting->ppn1 . '</span></span><br>' . $setting->etax1 . '<br>';
                                $output .= '<div class="choose-package" style="color:white;height: 44px;width: 86px;"><a  href="/booknow/' . $package->id . '/' . $request->room_id . '/' . $request->noofrooms . '/' . $r_p_1  . '"><span class=""><b style="color:white;font-size:18px;margin-left:-3px;">Réserver</b></span></a></div></td>'
                                    . '</tr>';
                            }
                        } else {

                            if ($str == "tn") {
                                $output .= '<td> <b><span style="font-weight:900;font-size: 20px;">TND ' . $sp2 . '<span style="font-size:10px">/Total</span></span></b><br><span style="font-size:15px;font-weight:bold;">TND&nbsp;' . $room->price2 . '<span style="font-size:10px">/' . $setting->ppn . '</span></span><br>' . $setting->etax . '<br>';
                                $output .= '<div class="choose-package" style="color:white;height: 44px;width: 86px;"><a  href="/booknow/' . $package->id . '/' . $request->room_id . '/' . $request->noofrooms . '/' . $sp2 . '"><span class=""><b style="color:white;font-size:18px;margin-left:-3px;"> Réserver</b></span></a></div></td>'
                                    . '</tr>';
                            } else {
                                $output .= '<td> <b><span style="font-weight:900;font-size: 20px;"> € ' . $sp1 . '<span style="font-size:10px">/Total</span></span></b><br><span style="font-size:15px;font-weight:bold;">€&nbsp;' . $room->price1 . '<span style="font-size:10px">/' . $setting->ppn1 . '</span></span><br>' . $setting->etax1 . '<br>';
                                $output .= '<div class="choose-package" style="color:white;height: 44px;width: 86px;"><a  href="/booknow/' . $package->id . '/' . $request->room_id . '/' . $request->noofrooms . '/' . $sp1 . '"><span class="" ><b style="color:white;font-size:18px;margin-left:-3px;"> Réserver</b></span></a></div></td>'
                                    . '</tr><hr>';
                            }
                        }
                    }
                } else {

                    if ($str == "tn") {
                        $output .= '<td> <b><span style="font-weight:900;font-size: 20px;">TND ' . $sp2 . '<span style="font-size:10px">/Total</span></span></b><br><span style="font-size:15px;font-weight:bold;">TND&nbsp;' . $room->price2 . '<span style="font-size:10px">/' . $setting->ppn . '</span></span><br>' . $setting->etax . '<br>';
                        $output .= '<div class="choose-package" style="color:white;height: 44px;width: 86px;"><a  href="/booknow/' . $package->id . '/' . $request->room_id . '/' . $request->noofrooms . '/' . $sp2 . '"><span class=""><b style="color:white;font-size:18px;margin-left:-3px;"> Réserver</b></span></a></div></td>'
                            . '</tr>';
                    } else {
                        $output .= '<td> <b><span style="font-weight:900;font-size: 20px;"> € ' . $sp1 . '<span style="font-size:10px">/Total</span></span></b><br><span style="font-size:15px;font-weight:bold;">€&nbsp;' . $room->price1 . '<span style="font-size:10px">/' . $setting->ppn1 . '</span></span><br>' . $setting->etax1 . '<br>';
                        $output .= '<div class="choose-package" style="color:white;height: 44px;width: 86px;"><a  href="/booknow/' . $package->id . '/' . $request->room_id . '/' . $request->noofrooms . '/' . $sp1 . '"><span class="" ><b style="color:white;font-size:18px;margin-left:-3px;"> Réserver</b></span></a></div></td>'
                            . '</tr><hr>';
                    }
                }
            }

            // dd($s. '      s33333');
            // dd($output);

        }
        $response = array(
            'status' => 'success',
            'msg'    => 'success',
            'data' => $output
        );

        return json_encode($response);
    }


    public function addCouponPrice(Request $request)
    {

        // dd($request->coupon);
        $key = 'bdELPYQYzlqCYrKewn0cwN9tTOjxXvVK';
        $qualityScore = new IPQualityScore($key);
        $ip_address = \Request::ip();
        $result1 = $qualityScore->IPAddressVerification->getResponse($ip_address);
        $result = $result1->data;
        $coupon = PMCoupon::where('coupon', $request->coupon)->first();
        $price = 0;
        session()->put('coupon_name', $coupon->coupon);
        if (!empty($coupon) && $coupon->enable == 1 && $coupon->valid == 1) {
            if ($str == "tn") {
                $price = $request->pricee - (($request->pricee * $coupon->coupon_price2) / 100);
                session()->put('coupon-value', $price);
            } else {
                $price = $request->pricee - (($request->pricee * $coupon->coupon_price2) / 100);
                session()->put('coupon-value', $price);
            }


            $response = array(
                'status' => 'success',
                'msg'    => 'success',
                'price' => $price
            );
        } else {
            session()->put('coupon-value', $request->pricee);
            $response = array(
                'status' => 'fail',
                'msg'    => 'fail',
                'price' => $price
            );
        }


        return json_encode($response);
    }

    public function removeCouponPrice(Request $request)
    {

        // dd($request->coupon);
        $key = 'bdELPYQYzlqCYrKewn0cwN9tTOjxXvVK';
        $qualityScore = new IPQualityScore($key);
        $ip_address = \Request::ip();
        $result1 = $qualityScore->IPAddressVerification->getResponse($ip_address);
        $result = $result1->data;
        $coupon = PMCoupon::where('coupon', $request->coupon)->first();
        $price = 0;
        session()->put('coupon_name', []);
        if (!empty($coupon) && $coupon->enable == 1 && $coupon->valid == 1) {
            if ($str == "tn") {
                $price = $request->pricee + (($request->pricee * $coupon->coupon_price2) / 100);
                session()->put('coupon-value', []);
            } else {
                $price = $request->pricee + (($request->pricee * $coupon->coupon_price2) / 100);
                session()->put('coupon-value', []);
            }


            $response = array(
                'status' => 'success',
                'msg'    => 'success',
                'price' => $price
            );
        } else {
            session()->put('coupon-value', $request->pricee);
            $response = array(
                'status' => 'fail',
                'msg'    => 'fail',
                'price' => $price
            );
        }


        return json_encode($response);
    }





    public function bookNow($id, $room_id, $room_price, $noofrooms = null)
    {

        // dd($id);
        $data = session()->get('array_data');
        $order_no = time() . rand(0, 100);


        $package = Package::find($id);
        $room = Room::find($room_id);
        $pack_services = PackageService::where('package_id', $package->id)->get();
        $services = Service::all();
        $serv_array = array();
        $services_array = array();



        foreach ($pack_services as $pack_service) {

            array_push($services_array, $pack_service->service_id);
        }

        foreach ($services as $service) {
            if (!in_array($service->id, $services_array)) {
                array_push($serv_array, $service->id);
            }
        }


        $settings = BookNowSetting::all();
        $setting = $settings[0];

        $payment_methods = PaymentMethod::all();
        $cc = $payment_methods[0];
        $bt = $payment_methods[1];
        $in_person = $payment_methods[2];


        $key = 'bdELPYQYzlqCYrKewn0cwN9tTOjxXvVK';
        $qualityScore = new IPQualityScore($key);
        $ip_address = \Request::ip();
        $result1 = $qualityScore->IPAddressVerification->getResponse($ip_address);
        $result = $result1->data;
        // dd($result);
        // dd($services);



        $all_booking_data = [
            'serv_array' => $serv_array,
            'data' => $data,
            'order_no' => $order_no,
            'package' => $package,
            'room' => $room,
            'noofrooms' => $noofrooms,
            'result' => $result,
            'room_price' => $room_price,
            'cc' => $cc,
            'bt' => $bt,
            'in_person' => $in_person,
            'room_price' => $room_price,
            'pack_id' => $id,
            'room_id' => $room_id
        ];

        session()->put('all_booking_data', $all_booking_data);
        $all_data = session()->get('all_booking_data');
        if (auth()->user()) {
            return view('customer-side.booknow', [
                'serv_array' => $serv_array,
                'data' => $data,
                'order_no' => $order_no,
                'package' => $package,
                'room' => $room,
                'noofrooms' => $noofrooms,
                'result' => $result,
                'room_price' => $room_price,
                'cc' => $cc,
                'bt' => $bt,
                'in_person' => $in_person,
                'room_price' => $room_price,
                'pack_id' => $id,
                'room_id' => $room_id,
                'setting' => $setting
            ]);
        } else {
            return view('customer-side.booknow', [
                'serv_array' => $serv_array,
                'data' => $data,
                'order_no' => $order_no,
                'package' => $package,
                'room' => $room,
                'noofrooms' => $noofrooms,
                'result' => $result,
                'room_price' => $room_price,
                'cc' => $cc,
                'bt' => $bt,
                'in_person' => $in_person,
                'room_price' => $room_price,
                'pack_id' => $id,
                'room_id' => $room_id,
                'setting' => $setting

            ]);
        }
    }





    // booking complete

    public function completeBooking(Request $request)
    {

        $input = $request->all();
        // dd($data);
        $data = session()->get('array_data');
        $adults = $data['adults'];
        $childs = $data['kid1'] + $data['kid2'];

        $days = $data['no_of_days'];
        $Atax = 0;
        $CTax = 0;
        $total_tax = 0;

        $response = Http::get('https://nominatim.openstreetmap.org/reverse?format=geojson&lat=36.7394816&lon=10.2039552');

        $str = $response->json()['features'][0]['properties']['address']['country_code'];

        $settings = Confirmation::all();
        $setting = $settings[0];

        $key = 'bdELPYQYzlqCYrKewn0cwN9tTOjxXvVK';
        $qualityScore = new IPQualityScore($key);
        $ip_address = \Request::ip();
        // $ip = "41.62.255.255";
        $result1 = $qualityScore->IPAddressVerification->getResponse($ip_address);
        $result = $result1->data;

        if ($str == "tn") {
            if ($days <= 7) {
                $Atax = $days * 3;
            } else {
                $Atax = 7 * 3;
            }


            if ($days <= 7) {
                $Ctax = 0;
            } else {
                $Ctax = 7 * 3;
            }

            $total_tax = $Atax + $Ctax;
        } else {
            $total_tax = $days * 1;
        }

        $booking = Booking::where('booking_no', $input['order_no'])->first();
        if (!empty($booking)) {
            return redirect('/');
        }

        // return redirect($url_get[0]);

        if ($input['paymentmethod'] == 'paybycreditcard') {


            $order = rand(40000, 8000000);
            if ($str == "tn") {
                $response = 'https://test.clictopay.com/payment/rest/register.do?currency=788&amount=' . str_replace('.', '', $request->pricee . '&orderNumber=' . $request->order_no . '&password=k5IyyD21G&returnUrl=http://www.clictopay.com.tn/clictopay-check-payment' . '&userName=0502422017');
                //  = redirect("https://ipay.clictopay.com/payment/rest/register.do?amount=". $request->pricee."&currency=788&language=en&orderNumber=". $order ."&password=". $request->password ."&returnUrl=finish.html&userName=".$request->username."&pageView=MOBILE&expirationDate=2023-09-08T14:14:14");

            } else {
                // $response = redirect("https://ipay.clictopay.com/payment/rest/register.do?amount=". $request->pricee."&currency=978&language=en&orderNumber=". $order ."&password=". $request->password ."&returnUrl=finish.html&userName=".$request->username."&pageView=MOBILE&expirationDate=2023-09-08T14:14:14");
                $response = 'https://test.clictopay.com/payment/rest/register.do?currency=978&amount=' . str_replace('.', '', $request->pricee . '&orderNumber=' .  $order . '&password=08ou5WJKz&returnUrl=http://www.clictopay.com.tn/clictopay-check-payment' . '&userName=0503050015');
            }





            $url_get = explode("&j", $response);
            $res =  file_get_contents($response);

            $res1 = json_decode($res);

            $order_id = $res1->orderId;

            $form_url = $res1->formUrl;

            $room = Room::find($request->room_id);

            if (auth()->user()) {
                $user = User::find(auth()->user()->id);
                $user->fname = $input['fname'];
                $user->lname = $input['lname'];
                $user->mobno = $input['mobno'];
                $user->request = $input['request'];

                $user->save();
            } else {
                $user = new User();
                $user->name = $request->fname . " " . $request->lname;

                $user->password = Hash::make(123456);
                $user->email = $request->email;
                $user->mobno = $input['mobno'];
                $user->request = $input['request'];

                $user->save();
                $user->assignRole('Customer');

                Auth::login($user);
            }
            // dd($form_url);

            $booking = new Booking();
            $booking->booking_no = $input['order_no'];
            if (auth()->user()) {
                $booking->user_id = auth()->user()->id;
            } else {
                $booking->user_id = $user->id;
            }


            $booking->room_id = $request->room_id;
            $booking->package_id = $request->package_id;
            $booking->booking_date_from = $data['datefrom'];
            $booking->booking_date_to = $data['dateto'];
            $booking->no_of_days = $data['no_of_days'];
            $booking->price = $request->pricee + $total_tax;
            $booking->fullprice = "Paid";
            $booking->status = "Confirmed";

            $booking->save();


            $room->status = 1;
            $room->inventory = (int)$room->inventory - (int)1;
            $room->save();

            return redirect($form_url);
        } else if ($input['paymentmethod'] == 'paybybank') {

            $room = Room::find($request->room_id);

            if (auth()->user()) {
                $user = User::find(auth()->user()->id);
                $user->fname = $input['fname'];
                $user->lname = $input['lname'];
                $user->mobno = $input['mobno'];
                $user->request = $input['request'];

                $user->save();

                Mail::to($user->email)->send(new PasswordSent('hhgjhg'));
                // dd($res);

            } else {
                $user = new User();
                $user->name = $request->fname . " " . $request->lname;

                $user->password = Hash::make(123456);
                $user->email = $request->email;
                $user->mobno = $input['mobno'];
                $user->request = $input['request'];


                $user->save();
                $password = "123456";
                $user->assignRole('Customer');
                Mail::to($user->email)->send(new PasswordSent($password));

                Auth::login($user);
            }
            $booking = new Booking();
            $booking->booking_no = $input['order_no'];
            if (auth()->user()) {
                $booking->user_id = auth()->user()->id;
            } else {
                $booking->user_id = $user->id;
            }
            $booking->room_id = $request->room_id;
            $booking->package_id = $request->package_id;
            $booking->booking_date_from = $data['datefrom'];
            $booking->booking_date_to = $data['dateto'];
            $booking->no_of_days = $data['no_of_days'];
            $booking->price = $request->pricee + $total_tax;
            $booking->advancepay = $room->payadvance;
            $booking->arrivalpay = $room->payonarrival;
            $booking->status = "Confirmed";


            $booking->save();





            $room->status = 1;
            $room->inventory = (int)$room->inventory - (int)1;
            $room->save();

            $details = PaymentMethod::find(2);





            $password = "123456";
            $method = "Pay By Bank";
            // session()->put('array_data',[]);
            return view('customer-side.confirmation_page', [
                'booking' => $booking,
                'details' => $details,
                'password' => $password,
                'method' => $method,
                'tax' => $total_tax,
                'Total_price' => $request->pricee,
                'setting' => $setting
            ]);
        } else if ($input['paymentmethod'] == 'payinperson') {

            if (auth()->user()) {
                $user = User::find(auth()->user()->id);
                $user->fname = $input['fname'];
                $user->lname = $input['lname'];
                $user->mobno = $input['mobno'];
                $user->request = $input['request'];

                $user->save();

                $res = Mail::to($user->email)->send(new PasswordSent('hhgjhg'));
                // dd($res);
            } else {
                $user = new User();
                $user->name = $request->fname . " " . $request->lname;
                $password = "123456";
                $user->password = Hash::make(123456);
                $user->email = $request->email;
                $user->mobno = $input['mobno'];
                $user->request = $input['request'];

                $user->save();
                $user->assignRole('Customer');
                Mail::to($user->email)->send(new PasswordSent($password));

                Auth::login($user);
            }

            $room = Room::find($request->room_id);
            $room->status = 1;
            $room->inventory = (int)$room->inventory - (int)1;
            $room->save();
            $booking = new Booking();
            $booking->booking_no = $input['order_no'];
            if (auth()->user()) {
                $booking->user_id = auth()->user()->id;
            } else {
                $booking->user_id = $user->id;
            }
            $booking->room_id = $request->room_id;
            $booking->package_id = $request->package_id;
            $booking->booking_date_from = $data['datefrom'];
            $booking->booking_date_to = $data['dateto'];
            $booking->no_of_days = $data['no_of_days'];
            $booking->price = $request->pricee + $total_tax;
            $booking->fullprice = "Not Paid";
            $booking->arrivalpay = $room->payonarrival;
            $booking->advancepay = $room->payadvance;
            $booking->status = "Pending";
            $booking->save();




            // // dd($room);
            // $room->no_of_rooms = $room->no_of_rooms - $request->noofrooms;
            // $room->save();
            // session()->put('array_data',[]);
            $password = "123456";
            $method = "Pay on Arrival";
            return view('customer-side.confirmation_page', [
                'booking' => $booking,
                // 'details' => $details,
                'password' => $password,
                'method' => $method,
                'tax' => $total_tax,
                'Total_price' => $request->pricee,
                'setting' => $setting

            ]);
        }

        // session()->put('all_booking_data',[]);




    }

    public function showpolicy()
    {

        return view('showpolicy');
    }

    public function emailExist(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        // dd($request->all());
        // dd($request->all());
        if (!empty($user)) {
            $response = [
                'message' => "Email Already Exist",
                'status' => 'success'
            ];

            return json_encode($response);
        } else {
            $response = [
                'message1' => "Email Available",
                'status' => 'fail'
            ];

            return json_encode($response);
        }
    }


    public function latLong(Request $request)
    {

        // dd($request->all());

        $latlong1 = [
            'lat' => $request->lat,
            'long' => $request->long,
        ];

        // session()->put('latlong',$latlong1);


        $ip = \Request::ip();

        $latlong = LatLong::where('ip', $ip)
            ->first();

        if ($latlong != null) {
            $latlong->lat = $request->lat;
            $latlong->longg = $request->long;
            $latlong->ip = $ip;

            $latlong->save();
        } else {
            $latlong = new LatLong();
            $latlong->lat = $request->lat;
            $latlong->longg = $request->long;
            $latlong->ip = $ip;

            $latlong->save();
        }





        session()->put('latlong', $latlong1);

        $response = [
            'message' => 'saved'
        ];

        return json_encode($response);
    }
    public function getPrice(Request $request)
    {

        $rate_price = Rate::where('room_id', $request->room_id)
            ->where('package_id', $request->package_id)
            ->first();
        $price = 0;

        if ($request->text == "Non Refundable") {
            if ($request->symbol == "TND") {
                $price = $rate_price->non_refundable2;
            } else {
                $price = $rate_price->non_refundable1;
            }
        } else if ($request->text == "Package Standard") {
            if ($request->symbol == "TND") {
                $price = $rate_price->price_per_night2;
            } else {
                $price = $rate_price->price_per_night1;
            }
        } else if ($request->text == "Modifiable") {
            if ($request->symbol == "TND") {
                $price = $rate_price->modifiable2;
            } else {
                $price = $rate_price->modifiable1;
            }
        } else if ($request->text == "prepayment") {
            if ($request->symbol == "TND") {
                $price = $rate_price->prepayment2;
            } else {
                $price = $rate_price->prepayment1;
            }
        } else if ($request->text == "noadvance") {
            if ($request->symbol == "TND") {
                $price = $rate_price->no_advance2;
            } else {
                $price = $rate_price->no_advance1;
            }
        }


        if (!empty($price)) {
            return response()->json([
                'success' => true,
                'data' => $price,
            ]);
        }
    }
    
    public function badges(Request $request)
    {

        $badges = [];
        $p_badges = BadgePackage::where('package_id', $request->package_id)->get();
        foreach ($p_badges as $b) {
            $badge = Badge::find($b->badge_id);
            array_push($badges, $badge);
        }

        if (count($badges) > 0) {
            return response()->json([
                'success' => true,
                'data' => $badges,
            ]);
        } else {
            return response()->json([
                'success' => true,
                'message' => "No badges available",
            ]);
        }
    }
    public function activities(Request $request)
    {
    
        $activities = ExtraActivity::all();

        if (count($activities) > 0) {
            return response()->json([
                'success' => true,
                'data' => $activities,
            ]);
        } else {
            return response()->json([
                'success' => true,
                'data' => "No Activities available",
            ]);
        }
    }
    public function signIn(Request $request)
    {
        

        if (!empty($request->email) && !empty($request->password)) {
            $role = "";

            $user = User::where('email', $request->email)->first();
            if (!empty($user)) {
                $a =  Auth::attempt(['email' => $request->email, 'password' => $request->password]);
                // $token =  $user->createToken('MyApp')->accessToken;

                if ($a == true) {
                    $u = auth()->user();
                    if ($u->hasRole("Admin")) {
                        $role = "Admin";
                    } elseif ($u->hasRole("Customer")){
                        $role = "Customer";
                    }else{
                        $role = "Guest";
                    }

                    $data = [
                        'role' => $role,
                        'user' => $u
                    ];

                    return response()->json([
                        'success' => true,
                        'data' => $data,
                        
                    ]);
                } else {
                    return response()->json([
                        'error' => true,
                        'data' => "Unauthorized"
                    ]);
                }
            } else {
                return response()->json([
                    'error' => true,
                    'data' => "Record Does Not Exits"
                ]);
            }
        } else {
            return response()->json([
                'error' => true,
                'data' => "Email and Password are both required"
            ]);
        }
    }
    public function signUp(Request $request)
    {


        if (!empty($request->email) && !empty($request->confirmemail) && !empty($request->confirmpassword) && !empty($request->password) && !empty($request->f_name) && !empty($request->l_name) && !empty($request->phone) && !empty($request->privacy) && !empty($request->account)) {

            if ($request->password != $request->confirmpassword) {
                return response()->json([
                    'error' => true,
                    'data' => "Both Passwords are not matched"
                ]);
            }

            if ($request->email != $request->confirmemail) {
                return response()->json([
                    'error' => true,
                    'data' => "Both Emails are not matched"
                ]);
            }

            $user = new User();
            $user->fname = $request->f_name;
            $user->lname = $request->l_name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->mobno = $request->phone;
            $user->name = $request->f_name.' '.$request->l_name;


            $user->save();

            return response()->json([
                'success' => true,
                'message' => "Account Created Successfully",
                'data' => $user
            ]);
        } else {
            return response()->json([
                'error' => true,
                'message' => "All Fields are required"
            ]);
        }
    }
    
    
    public function homePageSetting(Request $request)
    {


        $setting = NewHomeSetting::first();
            
        if(!empty($setting)){
            return response()->json([
                'success' => true,
                
                'data' => $setting
            ]);
        } else {
            return response()->json([
                'error' => true,
                'message' => "No data available"
            ]);
        }
    }
    
     public function RoomDetail(Request $request)
    {

        $room = Room::find($request->id);

        if (!empty($room)) {
            return response()->json([
                'success' => true,
                'data' => $room,
            ]);
        } else {
            return response()->json([
                'success' => true,
                'data' => "No Detail available",
            ]);
        }
    }


    public function PackageDetail(Request $request)
    {

        $package = Package::join('rates','rates.package_id','packages.id')
                            ->where('rates.package_id',$request->p_id)
                            ->where('rates.room_id',$request->r_id)
                            ->first();

        if (!empty($package)) {
            return response()->json([
                'success' => true,
                'data' => $package,
            ]);
        } else {
            return response()->json([
                'success' => true,
                'data' => "No Detail available",
            ]);
        }
    }


    public function getCoupon(Request $request)
    {

        $coupon = PMCoupon::where('coupon',$request->name)->where('valid',1)->first();

        if (!empty($coupon)) {
            return response()->json([
                'success' => true,
                'data' => $coupon,
            ]);
        } else {
            return response()->json([
                'error' => true,
                'data' => "Please enter a valid coupon code",
            ]);
        }
    }
    
    
    
    public function bookingInfo(Request $request){

        $input = $request->all();
        $number = rand(243678,99999999);
        $user = User::find($request->user_id);
        $response = Http::get('https://nominatim.openstreetmap.org/reverse?format=geojson&lat=36.7394816&lon=10.2039552');

        $str = $request->country_code;
        
        $status = "";

        if ($request->payment == 'card') {

            $response = Http::get('https://nominatim.openstreetmap.org/reverse?format=geojson&lat=36.7394816&lon=10.2039552');

            $str = $response->json()['features'][0]['properties']['address']['country_code'];


        


            $total_price = explode('.',$request->totalprice);
            if ($str == "tn") {
                $response = 'https://test.clictopay.com/payment/rest/register.do?currency=788&amount=' .$total_price[0] . '&orderNumber=' . $number . '&password=k5IyyD21G&returnUrl=https://booking.djerbaplaza.com/cache' . '&userName=0502422017';
                //  = redirect("https://ipay.clictopay.com/payment/rest/register.do?amount=". $request->pricee."&currency=788&language=en&orderNumber=". $order ."&password=". $request->password ."&returnUrl=finish.html&userName=".$request->username."&pageView=MOBILE&expirationDate=2023-09-08T14:14:14");
    
            } else {
                // $response = redirect("https://ipay.clictopay.com/payment/rest/register.do?amount=". $request->pricee."&currency=978&language=en&orderNumber=". $order ."&password=". $request->password ."&returnUrl=finish.html&userName=".$request->username."&pageView=MOBILE&expirationDate=2023-09-08T14:14:14");
                $response = 'https://test.clictopay.com/payment/rest/register.do?currency=978&amount=' .$total_price[0] . '&orderNumber=' .  $number . '&password=08ou5WJKz&returnUrl=https://booking.djerbaplaza.com/cache' . '&userName=0503050015';
            }


        
        $url_get = explode("&j", $response);
            $res =  file_get_contents($response);

            $res1 = json_decode($res);

            // $order_id = $res1->orderId;
            $form_url = $res1->formUrl;

            // return redirect($form_url);

            $user_id = 0;
            if ($user) {
                
                $user_id = $user->id;
                $user->country_code = strtoupper($str);
                $user->save();
                if($user->hasRole("Admin")){
                    $status = "Admin";
                }else{
                    $status = "Customer";
                }

                // Mail::to($user->email)->send(new PasswordSent('hhgjhg'));
                // dd($res);

            } else {
                if(!empty($request->guest)){
                    $newuser = new User();
                    $newuser->name = $request->fname . " " . $request->lname;
                    $newuser->fname = $request->fname;
                    $newuser->lname = $request->lname;
    
    
                    
                    $newuser->email = $request->email;
                    $newuser->mobno = $input['mobno'];
                    $newuser->notes = $input['notes'];
                    $newuser->country_code = strtoupper($str);
                   
    
    
    
                    $newuser->save();
    
                    $user_id = $newuser->id;
    
                    $password = "123456";
                    $newuser->assignRole('Guest');

                    $status = "Guest";
                }else{
                    $newuser = new User();
                    $newuser->name = $request->fname . " " . $request->lname;
                    $newuser->fname = $request->fname;
                    $newuser->lname = $request->lname;
    
    
                    $newuser->password = Hash::make($request->password);
                    $newuser->email = $request->email;
                    $newuser->mobno = $input['mobno'];
                    $newuser->notes = $input['notes'];
    
    
                    $newuser->country_code = strtoupper($str);
                    
                    $newuser->save();
    
                    $user_id = $newuser->id;
    
                    $password = "123456";
                    $newuser->assignRole('Customer');

                    Auth::login($newuser);

                    $status = "Customer";
                }
            }

            $booking = new Booking();
            $booking->booking_no = $number;
            $booking->user_id = $user_id;

            $booking->total_price = $request->totalprice;
            $booking->status = "Confirmed";

            $booking->save();

            foreach($request->room_tax as $d){
                $r_data = new Tax();
                $r_data->unique_id = $d['unique_id'];
                $r_data->booking_no = $number;
                $r_data->room_id = $d['room_id'];
                $r_data->package_id = $d['package_id'];
                $r_data->tax = $d['tax'];
                $r_data->save();

            }  
            foreach($request->room_data as $d){
                $r_data = new RoomData();
                $r_data->user_id = $user_id;
                $r_data->booking_no = $number;
                $r_data->unique_id = $d['unique_id'];
    
                $r_data->room_id = $d['room_id'];
                $r_data->package_id = $d['package_id'];
                $r_data->room_name = $d['room_name'];
                $r_data->package_name = $d['name'];
                $r_data->price = $d['price'];
                $r_data->total_price = $d['totalPrice'];
                $r_data->datefrom = $d['from'];
                $r_data->dateto = $d['to'];
                $r_data->adults = $d['adults'];
                $r_data->kid1 = $d['kid1'];
                $r_data->kid2 = $d['kid2'];
                $r_data->daydiff = $d['diff_days'];
                $r_data->save();

                $room = Room::find($d['room_id']);
                if($room->no_of_rooms > 0){
                    $room->no_of_rooms = (int)$room->no_of_rooms - (int)1;
                    $room->save();
                }

            }

            foreach($request->room_service as $d){
                $r_s_data = new RoomServiceData();
                $r_s_data->user_id = $user_id;
                $r_s_data->booking_no = $number;
                $r_s_data->unique_id = $d['unique_id'];
                $r_s_data->room_id = $d['room_id'];
                $r_s_data->package_id = $d['package_id'];
                $r_s_data->service_id = $d['room_service_id'];
                $r_s_data->title = $d['room_service_title'];
                $r_s_data->price = $d['room_service_price'];
                $r_s_data->save();
            }
            

            foreach($request->room_activity as $d){
                $r_a_data = new RoomActivityData();
                $r_a_data->user_id = $user_id;
                $r_a_data->booking_no = $number;
                $r_a_data->room_id = $d['room_id'];
                $r_a_data->unique_id = $d['unique_id'];
                $r_a_data->package_id = $d['package_id'];
                $r_a_data->activity_id = $d['activity_id'];
                $r_a_data->title = $d['activity_title'];
                $r_a_data->price = $d['activity_price'];
                $r_a_data->save();
                
            }

            $response = [
                'success' => "url",
                'data' => $form_url
            ];
            
            return response()->json($response);
        }
        else if ($request->payment == 'bank') {

            

            $user_id = 0;
            
           
            if ($user) {
                
                $user_id = $user->id;
                $user->country_code = strtoupper($str);
                $user->save();
                if($user->hasRole("Admin")){
                    $status = "Admin";
                }else{
                    $status = "Customer";
                }

                // Mail::to($user->email)->send(new PasswordSent('hhgjhg'));
                // dd($res);

            } else {
                if(!empty($request->guest)){
                    $newuser = new User();
                    $newuser->name = $request->fname . " " . $request->lname;
                    $newuser->fname = $request->fname;
                    $newuser->lname = $request->lname;
    
    
                    
                    $newuser->email = $request->email;
                    $newuser->mobno = $input['mobno'];
                    $newuser->notes = $input['notes'];
                    $newuser->country_code = strtoupper($str);
                   
    
    
    
                    $newuser->save();
    
                    $user_id = $newuser->id;
    
                    $password = "123456";
                    $newuser->assignRole('Guest');

                    $status = "Guest";
                }else{
                    $newuser = new User();
                    $newuser->name = $request->fname . " " . $request->lname;
                    $newuser->fname = $request->fname;
                    $newuser->lname = $request->lname;
    
    
                    $newuser->password = Hash::make($request->password);
                    $newuser->email = $request->email;
                    $newuser->mobno = $input['mobno'];
                    $newuser->notes = $input['notes'];
    
    
                    $newuser->country_code = strtoupper($str);
                    
                    $newuser->save();
    
                    $user_id = $newuser->id;
    
                    $password = "123456";
                    $newuser->assignRole('Customer');

                    Auth::login($newuser);

                    $status = "Customer";
                }
            }

            $booking = new Booking();
            $booking->booking_no = $number;
            $booking->user_id = $user_id;

            $booking->total_price = $request->totalprice;
            $booking->status = "Pending";
            $booking->save();


            foreach($request->room_tax as $d){
                $r_data = new Tax();
                $r_data->unique_id = $d['unique_id'];
                $r_data->booking_no = $number;
                $r_data->room_id = $d['room_id'];
                $r_data->package_id = $d['package_id'];
                $r_data->tax = $d['tax'];
                $r_data->save();

            }  

            foreach($request->room_data as $d){
                $r_data = new RoomData();
                $r_data->user_id = $user_id;
                $r_data->booking_no = $number;
                $r_data->unique_id = $d['unique_id'];
    
                $r_data->room_id = $d['room_id'];
                $r_data->package_id = $d['package_id'];
                $r_data->room_name = $d['room_name'];
                $r_data->package_name = $d['name'];
                $r_data->price = $d['price'];
                $r_data->total_price = $d['totalPrice'];
                $r_data->datefrom = $d['from'];
                $r_data->dateto = $d['to'];
                $r_data->adults = $d['adults'];
                $r_data->kid1 = $d['kid1'];
                $r_data->kid2 = $d['kid2'];
                $r_data->daydiff = $d['diff_days'];
                $r_data->save();


                $room = Room::find($d['room_id']);
                if($room->no_of_rooms > 0){
                    $room->no_of_rooms = (int)$room->no_of_rooms - (int)1;
                    $room->save();
                }
            }

            foreach($request->room_service as $d){
                $r_s_data = new RoomServiceData();
                $r_s_data->user_id = $user_id;
                $r_s_data->booking_no = $number;
                $r_s_data->unique_id = $d['unique_id'];
                $r_s_data->room_id = $d['room_id'];
                $r_s_data->package_id = $d['package_id'];
                $r_s_data->service_id = $d['room_service_id'];
                $r_s_data->title = $d['room_service_title'];
                $r_s_data->price = $d['room_service_price'];
                $r_s_data->save();
            }
            

            foreach($request->room_activity as $d){
                $r_a_data = new RoomActivityData();
                $r_a_data->user_id = $user_id;
                $r_a_data->booking_no = $number;
                $r_a_data->room_id = $d['room_id'];
                $r_a_data->unique_id = $d['unique_id'];
                $r_a_data->package_id = $d['package_id'];
                $r_a_data->activity_id = $d['activity_id'];
                $r_a_data->title = $d['activity_title'];
                $r_a_data->price = $d['activity_price'];
                $r_a_data->save();
                
            }


            $response = [
                'success' => "booking",
                'data' => "Booking is completed",
                'data1' => $status,
                'bookingno' => $number,
               
            ];
            
            return response()->json($response);
            
        }else if ($request->payment == 'arrival') {

            
            $user_id = 0;
            if ($user) {
                
                $user_id = $user->id;
                $user->country_code = strtoupper($str);
                $user->save();
                if($user->hasRole("Admin")){
                    $status = "Admin";
                }else{
                    $status = "Customer";
                }

                // Mail::to($user->email)->send(new PasswordSent('hhgjhg'));
                // dd($res);

            } else {
                if(!empty($request->guest)){
                    $newuser = new User();
                    $newuser->name = $request->fname . " " . $request->lname;
                    $newuser->fname = $request->fname;
                    $newuser->lname = $request->lname;
    
    
                    
                    $newuser->email = $request->email;
                    $newuser->mobno = $input['mobno'];
                    $newuser->notes = $input['notes'];
                    $newuser->country_code = strtoupper($str);
                   
    
    
    
                    $newuser->save();
    
                    $user_id = $newuser->id;
    
                    $password = "123456";
                    $newuser->assignRole('Guest');

                    $status = "Guest";
                }else{
                    $newuser = new User();
                    $newuser->name = $request->fname . " " . $request->lname;
                    $newuser->fname = $request->fname;
                    $newuser->lname = $request->lname;
    
    
                    $newuser->password = Hash::make($request->password);
                    $newuser->email = $request->email;
                    $newuser->mobno = $input['mobno'];
                    $newuser->notes = $input['notes'];
    
    
                    $newuser->country_code = strtoupper($str);
                    
                    $newuser->save();
    
                    $user_id = $newuser->id;
    
                    $password = "123456";
                    $newuser->assignRole('Customer');

                    Auth::login($newuser);

                    $status = "Customer";
                }
            }
            $booking = new Booking();
            $booking->booking_no = $number;
            $booking->user_id = $user_id;

            $booking->total_price = $request->totalprice;
            $booking->status = "Pending";
            $booking->save();


            foreach($request->room_tax as $d){
                $r_data = new Tax();
                $r_data->unique_id = $d['unique_id'];
                $r_data->booking_no = $number;
                $r_data->room_id = $d['room_id'];
                $r_data->package_id = $d['package_id'];
                $r_data->tax = $d['tax'];
                $r_data->save();
            }  


            foreach($request->room_data as $d){
                $r_data = new RoomData();
                $r_data->user_id = $user_id;
                $r_data->booking_no = $number;
                $r_data->unique_id = $d['unique_id'];
    
                $r_data->room_id = $d['room_id'];
                $r_data->package_id = $d['package_id'];
                $r_data->room_name = $d['room_name'];
                $r_data->package_name = $d['name'];
                $r_data->price = $d['price'];
                $r_data->total_price = $d['totalPrice'];
                $r_data->datefrom = $d['from'];
                $r_data->dateto = $d['to'];
                $r_data->adults = $d['adults'];
                $r_data->kid1 = $d['kid1'];
                $r_data->kid2 = $d['kid2'];
                $r_data->daydiff = $d['diff_days'];
                $r_data->save();

                $room = Room::find($d['room_id']);
                if($room->no_of_rooms > 0){
                    $room->no_of_rooms = (int)$room->no_of_rooms - (int)1;
                    $room->save();
                }
            }

            foreach($request->room_service as $d){
                $r_s_data = new RoomServiceData();
                $r_s_data->user_id = $user_id;
                $r_s_data->booking_no = $number;
                $r_s_data->unique_id = $d['unique_id'];
                $r_s_data->room_id = $d['room_id'];
                $r_s_data->package_id = $d['package_id'];
                $r_s_data->service_id = $d['room_service_id'];
                $r_s_data->title = $d['room_service_title'];
                $r_s_data->price = $d['room_service_price'];
                $r_s_data->save();
            }
            

            foreach($request->room_activity as $d){
                $r_a_data = new RoomActivityData();
                $r_a_data->user_id = $user_id;
                $r_a_data->booking_no = $number;
                $r_a_data->room_id = $d['room_id'];
                $r_a_data->unique_id = $d['unique_id'];
                $r_a_data->package_id = $d['package_id'];
                $r_a_data->activity_id = $d['activity_id'];
                $r_a_data->title = $d['activity_title'];
                $r_a_data->price = $d['activity_price'];
                $r_a_data->save();
                
            }
            


            $response = [
                'success' => "booking",
                'data' => "Booking is completed",
                'data1' => $status,
                'bookingno' => $number
            ];
            
            return response()->json($response);
        }
    }


    public function getBooking(Request $request)
    {

        $booking = Booking::latest()->take(1)->first();
        $user = User::find($booking->user_id);
        $room_tax = Tax::where('booking_no',$booking->booking_no)->get();
        $payment_method = PaymentMethod::find(2);

        $r_data = RoomData::where('booking_no',$booking->booking_no)->where('user_id',$request->id)->get();
        $r_s_data = RoomServiceData::where('booking_no',$booking->booking_no)->where('user_id',$request->id)->get();
        $r_a_data = RoomActivityData::where('booking_no',$booking->booking_no)->where('user_id',$request->id)->get();

        Mail::to($user->email)->send(new ConfirmationEmail($r_data,$r_a_data,$r_s_data,$booking));

        $all_data = [
            'room_tax' => $room_tax,
            'booking' => $booking,
            'room_data' => $r_data,
            'room_service_data' => $r_s_data,
            'room_activity_data' => $r_a_data,
            'bank' => $payment_method

        ];

       
            return response()->json([
                'success' => true,
                'data' => $all_data,
            ]);
       
    }

    public function getMinPrice(Request $request)
    {

        $date = \Carbon\Carbon::now();
        $day = [];
        for($i=1;$i <= 90; $i++){
           
            $ldate = explode('T',$date);
            $newdate = explode(' ',$ldate[0]);

            $packages = Package::join('rates','rates.package_id','packages.id')
                                ->where('start_date',$newdate[0])
                                ->orWhere('end_date',$newdate[0])->max('rates.price_per_night1');
            // $d = $date->addDays($i);

            if(!empty($packages)){
                array_push($day,[$packages,$newdate[0]]);
            }
            
            $date = $date->addDays(1);
            
        }

        

        if (count($day) > 0) {
            return response()->json([
                'success' => true,
                'data' => $day,
            ]);
        } else {
            return response()->json([
                'error' => true,
                'data' => "No data",
            ]);
        }
    }
    public function getTax(Request $request)
    {

        $days = $request->days;
        $Atax = 0;
        $CTax = 0;
        $total_tax = 0;
            if ($days <= 7) {
                $Atax = $days * 3;
            } else {
                $Atax = 7 * 3;
            }


            if ($days <= 7) {
                $Ctax = 0;
            } else {
                $Ctax = 7 * 3;
            }
    
            $total_tax = $Atax + $Ctax;
            
                // $total_tax = $days * 1;
           

        if (!empty($total_tax)) {
            return response()->json([
                'success' => true,
                'data' => $total_tax,
            ]);
        }
    }


    public function getServices(Request $request)
    {

        $services = Service::all();

        if (count($services)) {
            return response()->json([
                'success' => true,
                'data' => $services,
            ]);
        } else {
            return response()->json([
                'error' => true,
                'data' => "No Services",
            ]);
        }
    }

    public function getPolicy(Request $request)
    {

        $cpolicy = CancelPolicy::first();

        if (!empty($cpolicy)) {
            return response()->json([
                'success' => true,
                'data' => $cpolicy,
            ]);
        } else {
            return response()->json([
                'error' => true,
                'data' => "No Policy",
            ]);
        }
    }


    public function enable(){
        $response = Http::get('https://nominatim.openstreetmap.org/reverse?format=geojson&lat=36.7394816&lon=10.2039552');

        $str = $response->json()['features'][0]['properties']['address']['country_code'];


        $cc = PaymentMethod::find(1);
        $bank = PaymentMethod::find(2);
        $arrival = PaymentMethod::find(3);

        $c1 = "";
        $b1 = "";
        $a1 = "";

        if($str == "tn"){
            $str = "TN";
            if($cc->enable == 1){
                $c = PMCountry::where('country_code',$str)->where('cc','!=',0)->first();
                if($c){
                    $c1 = "enabled";
                }
            }
        }else{
            $str = "other";
            if($cc->enable == 1){
                $c = PMCountry::where('country_code',$str)->where('cc','!=',0)->first();
                if($c){
                    $c1 = "enabled";
                }
            }
        }


        if($str == "tn"){
            $str = "TN";
            if($bank->enable == 1){
                $c = PMCountry::where('country_code',$str)->where('bank_transfer','!=',0)->first();
                if($c){
                    $b1 = "enabled";
                }
            }
        }else{
            $str = "other";
            if($bank->enable == 1){
                $c = PMCountry::where('country_code',$str)->where('bank_transfer','!=',0)->first();
                if($c){
                    $b1 = "enabled";
                }
            }
        }

        if($str == "tn"){
            $str = "TN";
            if($arrival->enable == 1){
                $c = PMCountry::where('country_code',$str)->where('in_person','!=',0)->first();
                if($c){
                    $a1 = "enabled";
                }
            }
        }else{
            $str = "other";
            if($arrival->enable == 1){
                $c = PMCountry::where('country_code',$str)->where('in_person','!=',0)->first();
                if($c){
                    $a1 = "enabled";
                }
            }
        }

        $data = [
            'cc' => $c1,
            'bank' => $b1,
            'arrival' => $a1,

        ];

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function getFlatRate()
    {
        $flatrate = FlatRate::first();
        if(!empty($flatrate)){
            return response()->json([
                'success' => true,
                'data' => $flatrate,
            ]);
        }else{
            return response()->json([
                'error' => true,
                'data' => "No Flat Rate",
            ]);
        }


    }


    public function Footer()
    {
        $footer = HeaderFooter::first();
        if(!empty($footer)){
            return response()->json([
                'success' => true,
                'data' => $footer,
            ]);
        }else{
            return response()->json([
                'error' => true,
                'data' => "No Flat Rate",
            ]);
        }

    }


    public function allPackages()
    {
        $packages = Package::all();
        if(count($packages) > 0){
            return response()->json([
                'success' => true,
                'data' => $packages,
            ]);
        }else{
            return response()->json([
                'error' => true,
                'data' => "No Package",
            ]);
        }

    }

    public function allFacilities()
    {
        $facilities = Facility::all();
        if(count($facilities) > 0){
            return response()->json([
                'success' => true,
                'data' => $facilities,
            ]);
        }else{
            return response()->json([
                'error' => true,
                'data' => "No Data",
            ]);
        }

    }


    public function orderPrices(Request $request)
    {
        $price = $request->total;
        $str = $request->country_code;
        $cc = 0;
        $bt = 0;
        $inp = 0;
        if($str == "tn" || $str == "TN"){
            
            $p = PMOrderPrice::first();
            if($p->tnd_price_1 <= $price && $p->tnd_price_2 >= $price){
                
                if($p->cc != 0){
                    $cc = 1;
                }
                if($p->in_person != 0){
                    $inp = 1;
                }
                if($p->bank_transfer != 0){
                    
                    $bt = 1;
                }
            }
        }else{
            $p = PMOrderPrice::first();
            if($p->euro_price_1 <= $price && $p->euro_price_2 >= $price){
                if($p->cc != 0){
                    $cc = 1;
                }
                if($p->in_person != 0){
                    $inp = 1;
                }
                if($p->bank_transfer != 0){
                    $bt = 1;
                }
            }
        }

        $data = [
            'cc' => $cc,
            'bt' => $bt,
            'in_person' => $inp,
        ];

        
            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        

    }
    
    
}
