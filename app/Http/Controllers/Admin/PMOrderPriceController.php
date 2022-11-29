<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PMOrderPrice;
use App\Models\PaymentMethod;

class PMOrderPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order_prices = PMOrderPrice::paginate(10);

        return view('admin.orderprices.index',[
            'order_prices' => $order_prices
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


        return view('admin.orderprices.create',[
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
        // dd($request->all());

        $request->validate([
            'euro_price_1' => 'required',
            'euro_price_2' => 'required',
            'tnd_price_1' => 'required',
            'tnd_price_1' => 'required',

        ]);
        $order_price = new PMOrderPrice();
        if($request->euro_price_1 < $request->euro_price_2 && $request->tnd_price_1 < $request->tnd_price_2){
            $order_price->create($request->only($order_price->getFillable()));

            return redirect()->route('order_prices.index')->with('success','Order Price Created Successfully');
        }else{
            return redirect()->route('order_prices.create')->with('success','price 1 should be less than price 2');

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
        $order_price = PMOrderPrice::find($id);
        $payment_methods = PaymentMethod::all();
        $cc = $payment_methods[0];
        $bank_transfer = $payment_methods[1];
        $in_person = $payment_methods[2];


        return view('admin.orderprices.edit',[
            'order_price' => $order_price,
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
            'euro_price_1' => 'required',
            'euro_price_2' => 'required',
            'tnd_price_1' => 'required',
            'tnd_price_1' => 'required',

        ]);
        $order_price = PMOrderPrice::find($id);

        $order_price->update($request->only($order_price->getFillable()));

        return redirect()->route('order_prices.index')->with('success','Order Price Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PMOrderPrice::find($id)->delete();
        return redirect()->route('order_prices.index')->with('success','Order Price Deleted Successfully');

    }
}
