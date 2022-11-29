<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function bookings(){

        $bookings = Booking::orderBy('id', 'DESC')->get();
        // dd($bookings);
        return view('admin.bookings.bookings',[
            'bookings' => $bookings
        ]);
    }

    public function viewBooking($booking_id){

        $booking = Booking::find($booking_id);
        // dd($bookings);
        return view('admin.bookings.view-booking',[
            'booking' => $booking
        ]);
    }

    public function changeStatus(Request $request,$id){

        $booking = Booking::find($id);
        $room = Room::find($booking->room_id);
        if($request->bookingstatus == "Completed"){
            $booking->status = $request->bookingstatus;
            $room->inventory = $room->inventory + 1;
            $booking->save();
            $room->save();
        }else{
            $booking->status = $request->bookingstatus;
            $booking->save();
        }



        return redirect()->route('bookings')->with('success','Status changed');
    }
}
