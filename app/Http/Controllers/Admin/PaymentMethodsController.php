<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;

class PaymentMethodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $payment_methods = PaymentMethod::all();

        return view('admin.paymentmethods.index',[
            'payment_methods' => $payment_methods
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


    public function details(Request $request){

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

    public function edit($id){
        $payment_method = PaymentMethod::find($id);

        return view('admin.paymentmethods.edit',[
            'payment_method' => $payment_method
        ]);
    }

    public function update(Request $request,$id){
        $payment_method = PaymentMethod::find($id);
        $method = $payment_method->update($request->only($payment_method->getFillable()));

        if(!empty($request->details)){
            $payment_method->details = $request->details;
            $payment_method->save();
        }

        return redirect()->route('payment_methods.index')->with('success','PaymentMethod Updated Successfully');
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
