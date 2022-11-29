<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\PMCoupon;

class PMCouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons = PMCoupon::paginate(10);

        return view('admin.pmcoupons.index',[
            'coupons' => $coupons
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $payment_methods = PaymentMethod::all();
        $cc = $payment_methods[0];
        $bank_transfer = $payment_methods[1];
        $in_person = $payment_methods[2];


        return view('admin.pmcoupons.create',[
            'cc' => $cc,
            'bank_transfer' => $bank_transfer,
            'in_person' => $in_person
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
        $request->validate([
            'coupon' => 'required|unique:pm_promotional',
            'coupon_price1' => 'required',
            'coupon_price2' => 'required',

        ]);
        $coupon = new PMCoupon();
            $coupon->create($request->only($coupon->getFillable()));

            return redirect()->route('coupons.index')->with('success','Coupon Created Successfully');




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
        $coupon = PMCoupon::find($id);
        $payment_methods = PaymentMethod::all();
        $cc = $payment_methods[0];
        $bank_transfer = $payment_methods[1];
        $in_person = $payment_methods[2];


        return view('admin.pmcoupons.edit',[
            'coupon' => $coupon,
            'cc' => $cc,
            'bank_transfer' => $bank_transfer,
            'in_person' => $in_person
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
        $request->validate([
            'coupon' => 'required',
            'coupon_price1' => 'required',
            'coupon_price2' => 'required',

        ]);
            $coupon = PMCoupon::find($id);

            $coupon->update($request->only($coupon->getFillable()));

            return redirect()->route('coupons.index')->with('success','Coupon Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PMCoupon::find($id)->delete();
        return redirect()->route('coupons.index')->with('success','Coupon Deleted Successfully');

    }
}
