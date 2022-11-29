<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\PMSeason;

class PMSeasonsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $seasons = PMSeason::paginate(10);

        return view('admin.seasons.index',[
            'seasons' => $seasons
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


        return view('admin.seasons.create',[
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
            'date1' => 'required',
            'date2' => 'required',
        ]);
        $season = new PMSeason();

            $season->create($request->only($season->getFillable()));

            return redirect()->route('seasons.index')->with('success','Season Created Successfully');


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
        $season = PMSeason::find($id);
        $payment_methods = PaymentMethod::all();
        $cc = $payment_methods[0];
        $bank_transfer = $payment_methods[1];
        $in_person = $payment_methods[2];


        return view('admin.seasons.edit',[
            'season' => $season,
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
            'date1' => 'required',
            'date2' => 'required',
        ]);
        $season = PMSeason::find($id);

        $season->update($request->only($season->getFillable()));

        return redirect()->route('seasons.index')->with('success','Season Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PMSeason::find($id)->delete();
        return redirect()->route('seasons.index')->with('success','Season Deleted Successfully');

    }
}
