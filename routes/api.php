<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/roomssearch', [App\Http\Controllers\HomeController::class, 'searchRooms'])->name('searchRooms');

Route::post('/getprice', [App\Http\Controllers\HomeController::class, 'getPrice'])->name('getPrice');

Route::post('/badges', [App\Http\Controllers\HomeController::class, 'badges'])->name('badges');

Route::get('/activities', [App\Http\Controllers\HomeController::class, 'activities'])->name('activities');

Route::post('/signin', [App\Http\Controllers\HomeController::class, 'signIn']);

Route::post('/signup', [App\Http\Controllers\HomeController::class, 'signUp']);

Route::get('/homesetting', [App\Http\Controllers\HomeController::class, 'homePageSetting']);



Route::post('/roomdetails', [App\Http\Controllers\HomeController::class, 'RoomDetail']);
Route::post('/packagedetails', [App\Http\Controllers\HomeController::class, 'PackageDetail']);

Route::post('/coupon', [App\Http\Controllers\HomeController::class, 'getCoupon']);



Route::get('/getminprice', [App\Http\Controllers\HomeController::class, 'getMinPrice']);

Route::post('/tax', [App\Http\Controllers\HomeController::class, 'getTax']);

Route::get('/getservices', [App\Http\Controllers\HomeController::class, 'getServices']);
Route::get('/getpolicy', [App\Http\Controllers\HomeController::class, 'getPolicy']);

Route::post('/bookinginfo', [App\Http\Controllers\HomeController::class, 'bookingInfo']);
Route::post('/getbooking', [App\Http\Controllers\HomeController::class, 'getBooking']);

Route::post('/enable', [App\Http\Controllers\HomeController::class, 'enable']);
Route::get('/flatrate', [App\Http\Controllers\HomeController::class, 'getFlatRate']);

Route::get('/footer', [App\Http\Controllers\HomeController::class, 'Footer']);

Route::get('/allpacks', [App\Http\Controllers\HomeController::class, 'allPackages']);
Route::get('/allfacilities', [App\Http\Controllers\HomeController::class, 'allFacilities']);

Route::post('/orderprices', [App\Http\Controllers\HomeController::class, 'orderPrices']);







Route::post('/customerbookings', [App\Http\Controllers\BookingsController::class, 'bookings']);
    Route::post('/viewcustomerbooking', [App\Http\Controllers\BookingsController::class, 'viewCustBooking']);
    Route::post('/updateprofile', [App\Http\Controllers\Admin\CustomersController::class, 'updateProfile']);
    Route::get('/pastbookings', [App\Http\Controllers\BookingsController::class, 'pbookingHistory']);


    Route::post('/viewbooking', [App\Http\Controllers\BookingsController::class, 'viewCustAllBooking'])->name('viewbook');
    Route::post('/viewbbooking', [App\Http\Controllers\BookingsController::class, 'viewCustBBooking'])->name('viewbbook');


Route::group(['middleware' => ['auth', 'role:Customer']], function () {
    // Route::get('/viewcustomerbooking/{id}', [App\Http\Controllers\BookingsController::class, 'viewBooking'])->name('customer-view-booking');
    // Route::get('/bookingshistory', [App\Http\Controllers\BookingsController::class, 'bookingHistory'])->name('booking-history');

    // Route::get('/profile', [App\Http\Controllers\CustomerProfileSettings::class, 'viewProfile'])->name('view-profile');
    // Route::post('/updateprofile', [App\Http\Controllers\CustomerProfileSettings::class, 'updateProfile'])->name('update-profile');

    // Route::get('/review-view/{id}', [App\Http\Controllers\BookingsController::class, 'reviewView'])->name('review-view');
    // Route::post('/give-review/{id}', [App\Http\Controllers\BookingsController::class, 'giveReview'])->name('give-review');

    // Route::get('/ratings', [App\Http\Controllers\BookingsController::class, 'Ratings'])->name('ratings');
});







