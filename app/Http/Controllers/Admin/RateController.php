<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Rate;
use App\Models\ChildrenRate;
use App\Models\DiscountRoom;
use App\Models\Room;
use App\Models\Package;
use App\Models\RoomRate;
use Illuminate\Http\Request;
use App\Models\FlatRate;


class RateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $rates = RoomRate::join('rates', 'rates.rate_id', 'room_rates.id')->get();
        $rates = RoomRate::all();

        // dd($rates);
        return view('admin.rates.index', compact('rates'))->with('room')->with('package');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rooms = Room::all();
        $packages = Package::all();
        return view('admin.rates.create', compact('rooms', 'packages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());

        // $request->validate([
        //     'room' => 'required',
        //     'start_date' => 'required',
        //     'end_date' => 'required',
        //     'package' => 'required',
        //     'price_per_night1' => 'required',
        //     'price_per_night2' => 'required',
        //     'non_refundable1' => 'required',
        //     'non_refundable2' => 'required',
        //     'prepayment1' => 'required',
        //     'prepayment2' => 'required',
        //     'no_advance1' => 'required',
        //     'no_advance2' => 'required',
        //     'modifiable1' => 'required',
        //     'modifiable2' => 'required',

        // ]);


        try {

            if (
                !empty($request->start_date) &&
                !empty($request->end_date) &&
                !empty($request->package) &&
                !empty($request->price_per_night1) &&
                !empty($request->price_per_night2) &&
                !empty($request->non_refundable1) &&
                !empty($request->non_refundable2) &&
                !empty($request->prepayment1) &&
                !empty($request->prepayment2) &&
                !empty($request->no_advance1) &&
                !empty($request->no_advance2) &&
                !empty($request->modifiable1) &&
                !empty($request->modifiable2)

            ) {
                $room_rate = new RoomRate();
                $room_rate->save();

                for ($i = 0; $i < count($request->start_date); $i++) {
                    $rate = Rate::insertGetId([
                        'package_id' => $request->package[$i],
                        'room_id' => $request->room,
                        'rate_id' => $room_rate->id,
                        'start_date' => $request->start_date[$i],
                        'end_date' => $request->end_date[$i],
                        'price_per_night1' => $request->price_per_night1[$i],
                        'price_per_night2' => $request->price_per_night2[$i],
                        'non_refundable1' => $request->non_refundable1[$i],
                        'non_refundable2' => $request->non_refundable2[$i],
                        'prepayment1' => $request->prepayment1[$i],
                        'prepayment2' => $request->prepayment2[$i],
                        'no_advance1' => $request->no_advance1[$i],
                        'no_advance2' => $request->no_advance2[$i],
                        'modifiable1' => $request->modifiable1[$i],
                        'modifiable2' => $request->modifiable2[$i]
                    ]);
                    // dd($rate);

                }
            }


            if (!empty($request->discounts)) {
                for ($i = 0; $i < count($request->discounts); $i++) {
                    $discount_price = new DiscountRoom();

                    $discount_price->room_id = $request->room;
                    $discount_price->discount = $request->discounts[$i];

                    $discount_price->save();
                }
            }
            return redirect()->route('rates.index')->with('success', 'Data inserted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('rates.index')->with('fail', 'Something went wrong!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roomrate = RoomRate::find($id);
        $room = RoomRate::join('rates', 'rates.rate_id', 'room_rates.id')
                        ->join('rooms', 'rooms.id', 'rates.room_id')
                        ->where('room_rates.deleted_at',NULL)
                        ->where('rates.rate_id',$id)
            ->select('rooms.*')->first();
        $rooms = Room::all();
        $packages = Package::all();
        $rates = RoomRate::join('rates', 'rates.rate_id', 'room_rates.id')
                        ->where('room_rates.deleted_at',NULL)
            ->where('rates.rate_id',$id)->get();
        

        return view('admin.rates.edit', compact('roomrate', 'packages', 'rooms', 'room', 'rates'));
    }

   
    public function update(Request $request, $id)
    {
        // dd($request->all());

        $rate_id = $id;
        $discount_prices = DiscountRoom::where('room_id', $request->room)->get();
        // dd($request->discounts);
        if (!empty($request->discounts)) {
            for ($i = 0; $i < count($discount_prices); $i++) {

                $discount_prices[$i]->room_id = $request->room;
                $discount_prices[$i]->discount = $request->discounts[$i];

                $discount_prices[$i]->save();
            }
        }

        try {
            if (
                !empty($request->start_date) &&
                !empty($request->end_date) &&
                !empty($request->package) &&
                !empty($request->price_per_night1) &&
                !empty($request->price_per_night2) &&
                !empty($request->non_refundable1) &&
                !empty($request->non_refundable2) &&
                !empty($request->prepayment1) &&
                !empty($request->prepayment2) &&
                !empty($request->no_advance1) &&
                !empty($request->no_advance2) &&
                !empty($request->modifiable1) &&
                !empty($request->modifiable2)

            ) {
                for ($i = 0; $i < count($request->start_date); $i++) {
                    $room_rate = RoomRate::find($id);

                    $rate = Rate::insertGetId([
                        'room_id'               => $request->room,
                        'start_date' => $request->start_date[$i],
                        'end_date' => $request->end_date[$i],
                        'package_id' => $request->package[$i],
                        'rate_id' => $room_rate->id,

                        'price_per_night1' => $request->price_per_night1[$i],
                        'price_per_night2' => $request->price_per_night2[$i],
                        'non_refundable1' => $request->non_refundable1[$i],
                        'non_refundable2' => $request->non_refundable2[$i],
                        'prepayment1' => $request->prepayment1[$i],
                        'prepayment2' => $request->prepayment2[$i],
                        'no_advance1' => $request->no_advance1[$i],
                        'no_advance2' => $request->no_advance2[$i],
                        'modifiable1' => $request->modifiable1[$i],
                        'modifiable2' => $request->modifiable2[$i]
                    ]);
                }
            }

            if (
                !empty($request->start_date1) &&
                !empty($request->end_date1) &&
                !empty($request->package1) &&
                !empty($request->price_per_night11) &&
                !empty($request->price_per_night22) &&
                !empty($request->non_refundable11) &&
                !empty($request->non_refundable22) &&
                !empty($request->prepayment11) &&
                !empty($request->prepayment22) &&
                !empty($request->no_advance11) &&
                !empty($request->no_advance22) &&
                !empty($request->modifiable11) &&
                !empty($request->modifiable22)

            ) {
                $rate_room = RoomRate::find($id);

                for ($i = 0; $i < count($request->start_date1); $i++) {
                    $rate = Rate::where('rate_id', $rate_room->id)
                        ->where('package_id', $request->package1[$i])->update([
                            'room_id'               => $request->room,
                            'start_date' => $request->start_date1[$i],
                            'end_date' => $request->end_date1[$i],
                            'package_id' => $request->package1[$i],
                            'rate_id' => $rate_room->id,
                            'price_per_night1' => $request->price_per_night11[$i],
                            'price_per_night2' => $request->price_per_night22[$i],
                            'non_refundable1' => $request->non_refundable11[$i],
                            'non_refundable2' => $request->non_refundable22[$i],
                            'prepayment1' => $request->prepayment11[$i],
                            'prepayment2' => $request->prepayment22[$i],
                            'no_advance1' => $request->no_advance11[$i],
                            'no_advance2' => $request->no_advance22[$i],
                            'modifiable1' => $request->modifiable11[$i],
                            'modifiable2' => $request->modifiable22[$i]
                        ]);
                }
            }






            return redirect()->route('rates.index')->with('success', 'Data inserted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('rates.index')->with('fail', 'Something went wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        // Rate::where('rate_id',$id)->delete();
        RoomRate::find($id)->delete();
        return redirect()->route('rates.index')->with('success', 'Data removed successfully!');
    }



    public function getFlatRate()
    {
        $flatrate = FlatRate::first();


        return view('admin.rates.flatrateindex', compact('flatrate'));
    }

    public function editFlatRate($id)
    {
        $flatrate = FlatRate::find($id);


        return view('admin.rates.editflatrate', compact('flatrate'));
    }

   
    public function updateFlatRate(Request $request, $id)
    {
        // dd($request->all());
        $flatrate = FlatRate::find($id);
        if(!empty($request->name)){
            $flatrate->name = $request->name;
        }

        if(!empty($request->discount)){
            $flatrate->discount = $request->discount;
        }

        $flatrate->save();

        
        return redirect()->route('flatrates.index')->with('success', 'Data Updated successfully!');
        
    }
}
