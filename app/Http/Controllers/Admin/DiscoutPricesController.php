<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiscountPrice;
use Illuminate\Http\Request;

class DiscoutPricesController extends Controller
{
    public function index(){

        $prices = DiscountPrice::all();

        return view('admin.discountprices.index',[
            'prices' => $prices
        ]);
    }

    public function edit($id){

        $price = DiscountPrice::find($id);

        return view('admin.discountprices.edit',[
            'price' => $price
        ]);
    }

    public function update(Request $request, $id){

        // dd($request->all());
        $price = DiscountPrice::find($id);

        $price->discount = $request->discount;
        $price->save();

        return redirect()->route('prices.index')->with('success','Price Updated');
    }
}
