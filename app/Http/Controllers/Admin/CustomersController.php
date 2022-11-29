<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RoomData;
use App\Models\RoomServiceData;
use App\Models\RoomActivityData;
use App\Models\Booking;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;





class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = User::with('roles')->paginate(5);
        // $customers = [];
        // foreach($cust as $c){
        //     if($c->hasRole('Admin')){

        //     }else{
        //         array_push($customers,$c);
        //     }
        // }
        // dd($customers);

        return view('admin.customers.index',compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::orderBy('id','DESC')->where('name','!=','Admin')->get();

        return view('admin.customers.create',compact('roles'));

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
        $this->validate($request,[
            'email' => 'required|unique:users'
        ]);

        $user = User::create([
            'fname' => $request->f_name,
            'lname' => $request->l_name,
            'name' => $request->f_name . " ".$request->l_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'mobno' => $request->phone,

        ]);

        $user->assignRole($request->role);

        return redirect()->route('customers.index')->with('success','User Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = User::find($id);

        return view('admin.customers.show',compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = User::find($id);
        $roles = Role::orderBy('id','DESC')->where('name','!=','Admin')->get();

        return view('admin.customers.edit',compact('customer','roles'));
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
        $customer = User::find($id);
        
        if(!empty($request->password)){
            $customer->password = Hash::make($request->password);
        }
        if(!empty($request->f_name)){
            $customer->fname = $request->f_name;
        }
        if(!empty($request->l_name)){
            $customer->lname = $request->l_name;
        }
        if(!empty($request->email)){
            $customer->email = $request->email;
        }
        if(!empty($request->phone)){
            $customer->mobno = $request->phone;
        }

        if(!empty($request->role)){
            $customer->roles()->detach();
            $customer->assignRole($request->role);
        }

        if(!empty($request->f_name) && !empty($request->l_name)){
            $customer->name = $request->f_name . " ".$request->l_name;

        }

        $customer->save();

       

        return redirect()->route('customers.index')->with('success','User Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $booking = Booking::where('user_id',$id)->get();

        $r_data = RoomData::where('user_id',$id)->get();
        $r_s_data = RoomServiceData::where('user_id',$id)->get();
        $r_a_data = RoomActivityData::where('user_id',$id)->get();


        if(count($r_data) > 0){
            foreach($r_data as $r){
                $r->delete();
            }
        }

        if(count($r_s_data) > 0){
            foreach($r_s_data as $r){
                $r->delete();
            }
        }

        if(count($r_a_data) > 0){
            foreach($r_a_data as $r){
                $r->delete();
            }
        }

        if(count($booking) > 0){
            foreach($booking as $r){
                $r->delete();
            }
        }


        User::find($id)->delete();

        return redirect()->route('customers.index')->with('success','Customer Deletd Successfully');



    }


    public function updateProfile(Request $request){

        $customer = User::find($request->id);
        // return response(json_encode($request->email));
        
        if(!empty($request->password)){
            $customer->password = Hash::make($request->password);
        }
        if(!empty($request->l_name) && !empty($request->f_name)){
            $customer->name = $request->f_name." ".$request->l_name;
        }

        if(!empty($request->l_name)){
            $customer->lname = $request->l_name;
        }

        if(!empty($request->f_name)){
            $customer->fname = $request->f_name;
        }
        if(!empty($request->email)){
            $customer->email = $request->email;
        }
        if(!empty($request->phone)){
            $customer->mobno = $request->phone;
        }

        if($customer->save()){
            $response = [
                'success' => "true",
                'data' => "Profile Updated"
            ];

            return response(json_encode($response));
        }else{
            $response = [
                'error' => "true",
                'data' => "Something wrong"
            ];

            return response(json_encode($response));
        }
    }
}
