<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponsController extends Controller
{
    // Coupons code
    public function index(){
        $coupons = Coupon::all();

        return view('admin.coupons.index',[
            'coupons' => $coupons
        ]);
    }

    public function create(){


        return view('admin.coupons.create');
    }

    public function store(Request $request){
        $coupon = new Coupon();
        $coupon->create($request->only($coupon->getFillable()));

        return redirect()->route('coupons.index')->with('success','Coupon Created Successfully');
    }

    public function edit($id){
        $coupon = Coupon::find($id);

        return view('admin.coupons.edit',[
            'coupon' => $coupon
        ]);
    }

    public function update(Request $request,$id){
        $coupon = Coupon::find($id);
        $coupon->update($request->only($coupon->getFillable()));

        return redirect()->route('coupons.index')->with('success','Coupon Updated Successfully');
    }

    public function destroy($id){
        // dd($id);
        $coupon = Coupon::find($id)->delete();

        return redirect()->route('coupons.index')->with('success','Coupon Deleted Successfully');

    }
}
