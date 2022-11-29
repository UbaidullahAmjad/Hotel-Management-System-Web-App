<?php

namespace App\Http\Controllers;

use App\Models\ExtraActivity;
use Illuminate\Http\Request;

class ExtraActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activities = ExtraActivity::all();

        return view('admin.extraactivities.index',compact('activities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {


        return view('admin.extraactivities.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $image = $request->image;
        $name = $image->getClientOriginalName();

        $fileName = time() . $name;
        $image->move(storage_path() . '/app/public/', $fileName);

        $activity = new ExtraActivity();
        $act = $activity->create($request->only($activity->getFillable()));

        $act->image = $fileName;
       
        $act->save();

        return redirect()->route('activities.index')->with('success', 'Activity Created Successfully');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $activity = ExtraActivity::find($id);

        return view('admin.extraactivities.show',compact('activity'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $activity = ExtraActivity::find($id);

        return view('admin.extraactivities.edit',compact('activity'));
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



        $activity = ExtraActivity::find($id);
        $act = $activity->update($request->only($activity->getFillable()));
        if(!empty($request->image)){
            $image = $request->image;
            $name = $image->getClientOriginalName();

            $fileName = time() . $name;
            $image->move(storage_path() . '/app/public/', $fileName);
            $activity->image = $fileName;
            $activity->save();
        }

       
        $activity->save();

        return redirect()->route('activities.index')->with('success', 'Activity Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ExtraActivity::find($id)->delete();

        return redirect()->route('activities.index')->with('success', 'Activity Deleted Successfully');

    }
}
