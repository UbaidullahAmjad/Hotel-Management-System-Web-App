<?php

namespace App\Http\Controllers\Admin;
use App\Models\Facility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $facilities=Facility::all();
        return view('admin.facilities.index' , compact('facilities'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
     return view('admin.facilities.create');
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
        'title'=>'required',
        
        'price1'=>'required',
        'price2'=>'required'


    ]);

    $facility=new Facility;
 
    $facility->title=$request->title;
    $facility->price1=$request->price1;
    $facility->price2=$request->price2;

       if(!empty($request->image))
       {
           $image = $request->image;
           $name = $image->getClientOriginalName();
           $fileName = time() . $name;
           $image->move(storage_path() . '/app/public/', $fileName);
           $facility->image =   $fileName;
       }

       if($facility->save())
       return redirect()->route('facilities.index')->with('success','Data inserted successfully');
       else
       return redirect()->route('facilities.index')->with('fail','Something went wrong');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
     
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $facility=Facility::find($id);
        return view('admin.facilities.edit' , compact('facility'));
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
            'title'=>'required',
            'price1'=>'required',
            'price2'=>'required'
    
    
        ]);

        try
        {
        
        if(!empty($request->image))
        {
            $image = $request->image;
            $name = $image->getClientOriginalName();
            $fileName = time() . $name;
            $image->move(storage_path() . '/app/public/', $fileName);
            $image =   $fileName;
            Facility::where('id', $id)->update([
                 'image'=>$image
                ]);
        }
      

        Facility::where('id', $id)->update(
            [
               'title'=>$request->title ,
               'price1'=>$request->price1 ,
               'price2'=>$request->price2         
            ]);

            return redirect()->route('facilities.index')->with('success','Data updated successfully!');
        }
        catch(Exception $e)
        {
            return redirect()->route('facilities.index')->with('fail','Something went wrong!');
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
        try
        {
        Facility::find($id)->delete();
        return back()->with('success','Data deleted successfully!');
        }
        catch(Exception $e)
        {
            return back()->with('fail','Something went wrong!');
        }
    }
}
