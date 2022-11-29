<?php

use App\Models\PackageRoom;
use IPQualityScore\IPQualityScore;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DiscountController;
use Stichoza\GoogleTranslate\GoogleTranslate;
use App\Http\Controllers\Admin\RoomsController;
use App\Http\Controllers\Admin\CouponsController;
use App\Http\Controllers\Admin\PackagesController;
use App\Http\Controllers\Admin\PMCouponController;
use App\Http\Controllers\Admin\ServicesController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PMSeasonsController;
use App\Http\Controllers\EmailController;



use App\Http\Controllers\Admin\RoomtypesController;
use App\Http\Controllers\Admin\FacilityController;
use App\Http\Controllers\Admin\RateController;



use App\Http\Controllers\Admin\PMCountriesController;

use App\Http\Controllers\Admin\PMOrderPriceController;
use App\Http\Controllers\Admin\PaymentMethodsController;
use App\Http\Controllers\Admin\CancelationPolicyController;
use App\Http\Controllers\Admin\CustomersController;
use App\Http\Controllers\Auth\GoogleController;


use App\Http\Controllers\BadgesController;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\ExtraActivityController;
use App\Models\HomePageSetting;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\FbController;


use App\Mail\ReminderEmail;
use App\Mail\WelcomeEmail;
use App\Models\User;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('auth/google/callback', [App\Http\Controllers\Auth\GoogleController::class, 'handleGoogleCallback']);
Route::get('auth/google', [App\Http\Controllers\Auth\GoogleController::class, 'redirectToGoogle']);




Route::get('auth/facebook', [FbController::class, 'redirectToFacebook']);

Route::get('auth/facebook/callback', [FbController::class, 'facebookSignin']);


Route::get('form', function (Request $request) {
    $number = rand(243678,99999999);
    $response = Http::get('https://nominatim.openstreetmap.org/reverse?format=geojson&lat=36.7394816&lon=10.2039552');

    $str = $response->json()['features'][0]['properties']['address']['country_code'];
        if ($str == "tn") {
            $response = 'https://test.clictopay.com/payment/rest/register.do?currency=788&amount=20000&orderNumber=' . $number . '&password=k5IyyD21G&returnUrl=http://localhost:8000/cache' . '&userName=0502422017';
            //  = redirect("https://ipay.clictopay.com/payment/rest/register.do?amount=". $request->pricee."&currency=788&language=en&orderNumber=". $order ."&password=". $request->password ."&returnUrl=finish.html&userName=".$request->username."&pageView=MOBILE&expirationDate=2023-09-08T14:14:14");

        } else {
            // $response = redirect("https://ipay.clictopay.com/payment/rest/register.do?amount=". $request->pricee."&currency=978&language=en&orderNumber=". $order ."&password=". $request->password ."&returnUrl=finish.html&userName=".$request->username."&pageView=MOBILE&expirationDate=2023-09-08T14:14:14");
            $response = 'https://test.clictopay.com/payment/rest/register.do?currency=978&amount=30000&orderNumber=' .  $number . '&password=08ou5WJKz&returnUrl=http://localhost:8000/cache' . '&userName=0503050015';
        }



        $url_get = explode("&j", $response);
        $res =  file_get_contents($response);

        $res1 = json_decode($res);

        // $order_id = $res1->orderId;
        $form_url = $res1->formUrl;

        // return response()->json($form_url);
        return redirect($form_url);


});

Route::get('cache', function (Request $request) {
    // Artisan::call('config:cache');
    // return "done";
    // dd($request->all());
    return redirect('https://test.clictopay.com/payment/rest/deposit.do?amount=20000&currency=788&language='.$request->lang.'&orderId='.$request->orderId.'&password=k5IyyD21G&userName=0503050015');


});

Route::get('/', function () {

    $ip_address = \Request::ip();

    $users = User::join('bookings','bookings.user_id','users.id')
                ->get();
    foreach($users as $user){
        $now = date('Y-m-d');
        $d = explode(" ",$user->created_at);

        if($now < $d[0]){
            $date1 = DateTime::createFromFormat('Y-m-d', $now);
            $date2 = DateTime::createFromFormat('Y-m-d', $d[0]);
            $datefrom = $date1->format('Y-m-d');
            $dateto = $date2->format('Y-m-d');
            $datediff = strtotime($dateto) - strtotime($datefrom);
            $days = (int)round($datediff / (60 * 60 * 24));
    
            if($days == 7){
                Mail::to($user->email)->send(new ReminderEmail($user->booking_no));
            }
    
            if($days == 0){
                Mail::to($user->email)->send(new WelcomeEmail());
            }
        }
       

    }

    // dd($str);

    // if()
    // dd($position);


    // if ($position = Location::get('41.62.255.255')) {
    //     // Successfully retrieved position.
    //     echo $position->countryName;
    // } else {
    //     // Failed retrieving position.
    // }
    // dd($position);

    $rooms = App\Models\Room::where('active', 1)->get();
    $key = 'bdELPYQYzlqCYrKewn0cwN9tTOjxXvVK';

    $qualityScore = new IPQualityScore($key);
    $ip_address = \Request::ip();
    $result1 = $qualityScore->IPAddressVerification->getResponse($ip_address);
    // dd($result1);
    $result = $result1->data;
    $user = auth()->user();



    // dd($tr->setTarget('fr'));
    // dd($tr);

    $settings = HomePageSetting::all();
    $setting = $settings[0];

    // if($user->hasRole('Admin')){
    //     return redirect()->route('dashboard');
    // }else{
    // $response = Http::get('https://nominatim.openstreetmap.org/reverse?format=geojson&lat=33.5513806&lon=73.1247913');
    //     dd($response->json());
    $all_data = session()->get('all_booking_data');
    $data = session()->get('array_data');


    return view('main-home', [
        'rooms' => $rooms,
        'result' => $result,
        'setting' => $setting,
        // 'str' => $str
    ]);

    // }

});

// Route::post('/rooms-search', [App\Http\Controllers\HomeController::class, 'searchRooms'])->name('searchRooms');


Route::group(['middleware' => ['auth', 'role:Customer']], function () {
    Route::get('/customerbookings', [App\Http\Controllers\BookingsController::class, 'bookings'])->name('customer-bookings');
    Route::get('/viewcustomerbooking/{id}', [App\Http\Controllers\BookingsController::class, 'viewBooking'])->name('customer-view-booking');
    Route::get('/bookingshistory', [App\Http\Controllers\BookingsController::class, 'bookingHistory'])->name('booking-history');

    Route::get('/profile', [App\Http\Controllers\CustomerProfileSettings::class, 'viewProfile'])->name('view-profile');
    Route::post('/updateprofile', [App\Http\Controllers\CustomerProfileSettings::class, 'updateProfile'])->name('update-profile');

    Route::get('/review-view/{id}', [App\Http\Controllers\BookingsController::class, 'reviewView'])->name('review-view');
    Route::post('/give-review/{id}', [App\Http\Controllers\BookingsController::class, 'giveReview'])->name('give-review');

    Route::get('/ratings', [App\Http\Controllers\BookingsController::class, 'Ratings'])->name('ratings');
});
Route::group(['middleware' => ['auth', 'role:Admin|Customer']], function () {




    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/getrooms', [App\Http\Controllers\HomeController::class, 'getRooms'])->name('getRooms');
});

Route::get('/addcouponprice', [App\Http\Controllers\HomeController::class, 'addCouponPrice'])->name('couponprice');
Route::get('/removecouponprice', [App\Http\Controllers\HomeController::class, 'removeCouponPrice'])->name('remcouponprice');


Route::post('/complete-booking', [App\Http\Controllers\HomeController::class, 'completeBooking'])->name('complete-booking');
Route::get('/booknow/{pack_id}/{room_id}/{noofrooms?}/{room_price}', [App\Http\Controllers\HomeController::class, 'bookNow'])->name('booknow');
Route::get('/choosepackage', [App\Http\Controllers\HomeController::class, 'choosePackage'])->name('choosepack');
Auth::routes();


Route::resource('rooms', RoomsController::class);

Route::group(['middleware' => ['auth', 'role:Admin']], function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);

    Route::resource('packages', PackagesController::class);
    Route::resource('services', ServicesController::class);
    Route::resource('room_types', RoomtypesController::class);

    Route::resource('activities', ExtraActivityController::class);
    Route::resource('badges', BadgesController::class);
    Route::resource('customers', CustomersController::class);

    Route::resource('roles', RoleController::class);


    Route::get('/removeservice', [PackagesController::class, 'removeService'])->name('removeservice');

    // cms
    Route::get('/homepageedit', [DashboardController::class, 'homePageForm'])->name('setting.home');
    Route::post('/homepageupdate/{id}', [DashboardController::class, 'homePageUpdate'])->name('setting.update.home');

    Route::get('/bookpageedit', [DashboardController::class, 'bookPageForm'])->name('setting.booknow');
    Route::post('/bookpageupdate/{id}', [DashboardController::class, 'bookPageUpdate'])->name('setting.update.booknow');

    Route::get('/confirmpageedit', [DashboardController::class, 'confirmPageForm'])->name('setting.confirm');
    Route::post('/confirmpageupdate/{id}', [DashboardController::class, 'confirmPageUpdate'])->name('setting.update.confirm');

    Route::get('/headerpageedit', [DashboardController::class, 'headerPageForm'])->name('setting.header');
    Route::post('/headerpageupdate/{id}', [DashboardController::class, 'headerPageUpdate'])->name('setting.update.header');

    Route::get('/logregpageedit', [DashboardController::class, 'logregPageForm'])->name('setting.logreg');
    Route::post('/logregpageupdate/{id}', [DashboardController::class, 'logregPageUpdate'])->name('setting.update.logreg');
    
    
    Route::get('/newhomepage', [DashboardController::class, 'newHomePageForm'])->name('setting.newhome');
    Route::post('/newhomepage/{id}', [DashboardController::class, 'newhomePageUpdate'])->name('setting.update.newhome');



    // coupons routes
    Route::get('/couponss', [CouponsController::class, 'index'])->name('couponss.index');
    Route::get('/addcoupon', [CouponsController::class, 'create'])->name('coupons.create');
    Route::post('/storecoupon', [CouponsController::class, 'store'])->name('coupons.store');
    Route::get('/editcoupon/{id}', [CouponsController::class, 'edit'])->name('coupons.edit');
    Route::post('/updatecoupon/{id}', [CouponsController::class, 'update'])->name('coupons.update');
    Route::get('/deletecoupon/{id}', [CouponsController::class, 'destroy'])->name('coupons.delete');

    // payment methods
    Route::resource('payment_methods', PaymentMethodsController::class);
    Route::post('/details', [App\Http\Controllers\Admin\PaymentMethodsController::class, 'details'])->name('details.upload');


    // Countries
    Route::resource('countries', PMCountriesController::class);

    // order price
    Route::resource('order_prices', PMOrderPriceController::class);

    // seasons
    Route::resource('seasons', PMSeasonsController::class);

    // promotionals
    Route::resource('coupons', PMCouponController::class);

    // cancel policy
    Route::resource('policy', CancelationPolicyController::class);
    Route::post('/uploadpolicy', [App\Http\Controllers\Admin\CancelationPolicyController::class, 'policy'])->name('policy.upload');



    Route::get('/bookings', [App\Http\Controllers\Admin\BookingController::class, 'bookings'])->name('bookings');
    Route::get('/viewbooking/{id}', [App\Http\Controllers\Admin\BookingController::class, 'viewBooking'])->name('view-booking');

    Route::post('/changestatus/{id}', [App\Http\Controllers\Admin\BookingController::class, 'changeStatus'])->name('changestatus');

    Route::get('/discountprices', [App\Http\Controllers\Admin\DiscoutPricesController::class, 'index'])->name('prices.index');
    Route::get('/editprices/{id}', [App\Http\Controllers\Admin\DiscoutPricesController::class, 'edit'])->name('prices.edit');
    Route::post('/updateprices/{id}', [App\Http\Controllers\Admin\DiscoutPricesController::class, 'update'])->name('prices.update');


    Route::get('/facilities/create', [FacilityController::class, 'create'])->name('facilities.create');
    Route::post('/facilities', [FacilityController::class, 'store'])->name('facilities.store');
    Route::get('/facilities', [FacilityController::class, 'index'])->name('facilities.index');
    Route::get('/facilities/{id}/edit', [FacilityController::class, 'edit'])->name('facilities.edit');
    Route::put('/facilities/{id}', [FacilityController::class, 'update'])->name('facilities.update');
    Route::get('/facilities/destroy/{id}', [FacilityController::class, 'destroy'])->name('facilities.destroy');

    Route::get('/rates/create', [RateController::class, 'create'])->name('rates.create');
    Route::post('/rates', [RateController::class, 'store'])->name('rates.store');
    Route::get('/rates', [RateController::class, 'index'])->name('rates.index');
    Route::get('/rates/{id}/edit', [RateController::class, 'edit'])->name('rates.edit');
    Route::put('/rates/{id}', [RateController::class, 'update'])->name('rates.update');
    Route::get('/rates/destroy/{id}', [RateController::class, 'destroy'])->name('rates.destroy');

    Route::get('/flatrates', [RateController::class, 'getFlatRate'])->name('flatrates.index');
    Route::get('/flatrates/{id}/edit', [RateController::class, 'editFlatRate'])->name('flatrates.edit');
    Route::post('/flatrates/{id}', [RateController::class, 'updateFlatRate'])->name('flatrates.update');


    //Email Management
    Route::get('/emailindex', [EmailController::class, 'index'])->name('emails.index');
    Route::post('/viewsendemail', [EmailController::class, 'view'])->name('emails.view');
    Route::post('/sendemail', [EmailController::class, 'send'])->name('emails.send');

    Route::get('/emailview/{id}', [EmailController::class, 'viewEmail'])->name('emails.vieww');
    Route::post('/resendemail', [EmailController::class, 'resend'])->name('resend');

    Route::get('/change', [BookingsController::class, 'change'])->name('change');





});

Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('do-logout');

Route::get('/showpolicy', [App\Http\Controllers\HomeController::class, 'showpolicy'])->name('showpolicy');
Route::get('/checkemail', [App\Http\Controllers\HomeController::class, 'emailExist'])->name('email-exist');




//Start Admin Role
Route::get('discount', [DiscountController::class, 'index'])->name('admin.discount');
Route::post('discount', [DiscountController::class, 'store'])->name('admin.discount');
Route::get('discount/{id}/edit', [DiscountController::class, 'edit'])->name('admin.discount.edit');
Route::put('discount/update/{id}', [DiscountController::class, 'update'])->name('admin.discount.update');
Route::delete('discount/{id}', [DiscountController::class, 'destroy'])->name('admin.discount.destroy');


Route::get('/addlatlong', [App\Http\Controllers\HomeController::class, 'latLong'])->name('latlong');






    // End Admin Role
