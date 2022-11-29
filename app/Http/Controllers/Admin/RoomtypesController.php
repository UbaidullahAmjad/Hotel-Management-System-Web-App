<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoomType;
use App\Models\Room;
use App\Models\PackageRoom;
use App\Models\RangePrice;
use App\Models\Package;

use Illuminate\Http\Request;

class RoomtypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $room_types = RoomType::all();
        return view('admin.room_types.index',[
            'room_types' => $room_types,

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $packages = Package::all();

        return view('admin.room_types.create',[
            'packages' => $packages
        ]);
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

        $room_type = new RoomType();
        $r_type = $room_type->create($request->only($room_type->getFillable()));

        if(!empty($request->price1) && !empty($request->package_id) && !empty($request->price1) && !empty($request->package_price1) && !empty($request->package_price2)){
            for($i = 0 ; $i < count($request->price1); $i++){
                $package_room = new PackageRoom();
                $package_room->room_type_id = $r_type->id;
                $package_room->package_id = $request->package_id[$i];
                $package_room->normal_price1 = $request->price1[$i];
                $package_room->normal_price2 = $request->price2[$i];
                $package_room->package_price1 = $request->package_price1[$i];
                $package_room->package_price2 = $request->package_price2[$i];
                $package_room->onarrival = $request->onarrival;
                $package_room->advance_price = $request->advance_price;
                $package_room->fullprice = $request->fullprice;
                $package_room->save();
            }

        }

        // dd($request->all());
        if(!empty($request->datefrom) && !empty($request->dateto) && !empty($request->rangeprice1) && !empty($request->rangeprice2)){
            for($i = 0 ; $i < count($request->datefrom); $i++){
                $range_price = new RangePrice();
                $range_price->room_type_id = $r_type->id;
                $range_price->package_id = $request->package_id[$i];
                $range_price->datefrom = $request->datefrom[$i];
                $range_price->dateto = $request->dateto[$i];
                $range_price->price1 = $request->rangeprice1[$i];
                $range_price->price2 = $request->rangeprice2[$i];

                $range_price->save();
            }
        }
        return redirect()->route('room_types.index')->with('success','Room Type Created Successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $room_type = RoomType::find($id);
        return view('admin.room_types.show',[
            'room_type' => $room_type
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $package_ids = array();
        $pack_rooms = PackageRoom::where('room_type_id',$id)->get();

        foreach($pack_rooms as $pack_room){
            array_push($package_ids,$pack_room->package_id);
        }

        $packages = Package::all();



        $range_prices = RangePrice::where('room_id',$id)->get();

        $room_type = RoomType::find($id);
        return view('admin.room_types.edit',[
            'room_type' => $room_type,
            'packages' => $packages,
            'range_prices' => $range_prices,
            'package_ids' => $package_ids,
            'pack_rooms' => $pack_rooms
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $room_type = RoomType::find($id);
        $room_type->update($request->only($room_type->getFillable()));


        $package_ids = array();
        $pack_rooms = PackageRoom::where('room_id',$id)->get();

        foreach($pack_rooms as $pack_room){
            array_push($package_ids,$pack_room->package_id);
        }

        if(!empty($request->price1) && !empty($request->package_id) && !empty($request->price2) && !empty($request->package_price1) && !empty($request->package_price2)){
            for($i = 0 ; $i < count($request->package_id); $i++){

                $package_room = PackageRoom::where('room_id',$id)->where('package_id',$request->package_id[$i])->first();
                // dd($package_room);
                if($package_room){
                    $package_room->room_type_id = $id;
                    $package_room->package_id = $request->package_id[$i];
                    $package_room->normal_price1 = $request->price1[$i];
                    $package_room->normal_price2 = $request->price2[$i];
                    $package_room->package_price1 = $request->package_price1[$i];
                    $package_room->package_price2 = $request->package_price2[$i];
                    $package_room->save();
                }else{

                    $package_room = new PackageRoom();
                    $package_room->room_type_id = $id;
                    $package_room->package_id = $request->package_id[$i];
                    $package_room->normal_price1 = $request->price1[$i];
                    $package_room->normal_price2 = $request->price2[$i];
                    $package_room->package_price1 = $request->package_price1[$i];
                    $package_room->package_price2 = $request->package_price2[$i];
                    $package_room->save();
                }

            }

        }




        if(!empty($request->datefrom1) && !empty($request->dateto1) && !empty($request->rangeprice11) && !empty($request->rangeprice22)){
            // dd( count($request->datefrom));
            for($i = 0 ; $i < count($request->package_id); $i++){
                // dd($request->package_id);
                $range_price = RangePrice::where('room_id',$id)->where('package_id',$request->package_id[$i])->get();
                // dd($range_price);
                if(count($range_price) > 0){
                    $range_price[$i]->room_type_id = $id;
                    $range_price[$i]->package_id = $request->package_id[$i];
                    $range_price[$i]->datefrom = $request->datefrom[$i];
                    $range_price[$i]->dateto = $request->dateto[$i];
                    $range_price[$i]->price1 = $request->rangeprice1[$i];
                    $range_price[$i]->price2 = $request->rangeprice2[$i];

                    $range_price[$i]->save();
                }else{

                    $range_price = new RangePrice();
                    $range_price->room_type_id = $id;
                    $range_price->package_id = $request->package_id[$i];
                    $range_price->datefrom = $request->datefrom1[$i];
                    $range_price->dateto = $request->dateto1[$i];
                    $range_price->price1 = $request->rangeprice11[$i];
                    $range_price->price2 = $request->rangeprice22[$i];

                    $range_price->save();
                }

            }
        }


        return redirect()->route('room_types.index')->with('success','Room Type Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Room::where('room_type_id',$id)->delete();
        PackageRoom::where('room_type_id',$id)->delete();
        RangePrice::where('room_type_id',$id)->delete();
        RoomType::find($id)->delete();

        return redirect()->route('room_types.index')->with('success','Room Type Deleted Successfully');

    }
}
