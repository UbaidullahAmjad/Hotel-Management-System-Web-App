<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class CustomerProfileSettings extends Controller
{
    public function viewProfile(){
        return view('customer-side.profilesettings.profile');
    }

    public function updateProfile(Request $request){

        $request->validate([

            'name' => 'required'
        ]);



        $user = User::find(auth()->user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        if(!empty($request->password) && !empty($request->repassword)){
            if($request->password != $request->repassword){
                return redirect()->route('view-profile')->with('success','Passwords not matched');
            }

            $user->password = $request->password;
        }


        if(!empty($request->profile)){
            $image = $request->profile;
            $name = $image->getClientOriginalName();

            $fileName = time() . $name;
            $attachment = $image->move(storage_path() . '/app/public/', $fileName);
            $user->avatar = $fileName;
            // dd('here');
        }

        $user->save();

        return redirect()->route('view-profile')->with('success','Profile Updated Successfully');
    }
}
