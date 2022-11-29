<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CancelPolicy;
use Illuminate\Http\Request;

class CancelationPolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $policies = CancelPolicy::all();

        return view('admin.cancelpolicy.index',[
            'policies'=> $policies
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $policy = CancelPolicy::find($id);

        return view('admin.cancelpolicy.edit',[
            'policy'=> $policy
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function policy(Request $request){

        if($request->hasFile('upload')){
            $name = $request->file('upload')->getClientOriginalName();
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = time(). $name;
             $request->file('upload')->move(storage_path() . '/app/public/', $fileName);
             $filename_store = $fileName;
            session()->put('filename',$fileName);
             $ckeditorfuncname = $request->input('CKEditorFuncNum');
             $url = asset("storage/". $fileName);
             $msg ="Image uploaded succesfully";

            return '<script>window.parent.CKEDITOR.tools.callFunction
            ('.$ckeditorfuncname.', "'.$url.'", "'.$msg.'")</script>';
            }
    }
    public function update(Request $request, $id)
    {
        $policy = CancelPolicy::find($id);

        // $policy = new CancelPolicy();
        $policy->title = $request->title;
        $policy->policy = $request->policy;
        $policy->save();

        return redirect()->route('policy.index')->with('success','Policy Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
