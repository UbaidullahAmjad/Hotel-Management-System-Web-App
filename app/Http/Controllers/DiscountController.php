<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NightDiscount;
use App\Http\Controllers\Controller;

class DiscountController extends Controller
{
    public function index()
    {
        $discounts = NightDiscount::all();
        return view('discount.index', compact('discounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'discount1' => 'required',
            'discount2' => 'required',
            'datefrom' => 'required',
            'dateto' => 'required',

        ]);


        $data = NightDiscount::where('datefrom','<=',$request->datefrom)
                                ->where('dateto','>=',$request->dateto)->first();
        
            if(!empty($data)){
                
                return back()->with('success', 'Date Range cannot be same or in between');
            }else{
                NightDiscount::insert([
                    'discount1' => $request->discount1,
                    'discount2' => $request->discount2,
                    'datefrom' => $request->datefrom,
                    'dateto' => $request->dateto,
                ]);
            }
        

        

        return back()->with('success', 'Discount has been created.');
    }

    public function edit($id)
    {
        $discount = NightDiscount::find($id);
        return response()->json($discount);
    }

    public function update(Request $request, $id)
    {
        NightDiscount::find($request->id)->update([
            'discount1' => $request->discount1,
            'discount2' => $request->discount2,
            'datefrom' => $request->datefrom,
            'dateto' => $request->dateto,
        ]);

        return back()->with('success', $request->name . ' has been Updated.');
    }

    public function destroy($id)
    {
        $discount = NightDiscount::find($id);
        $discount->delete();
        return back()->with('success', $discount->name . ' has been Deleted.');
    }
}
