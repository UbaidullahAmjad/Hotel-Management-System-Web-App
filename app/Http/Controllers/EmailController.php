<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PMCountry;
use App\Models\Booking;
use App\Models\RoomData;
use App\Models\User;
use App\Models\Email;

use App\Mail\CriteriaEmail;


use Illuminate\Support\Facades\Mail;




class EmailController extends Controller
{
    public function index(){
        $all_dates = [];
        // $users = User::join('bookings','bookings.user_id','users.id')
        $countries = PMCountry::all();
        $emails = Email::paginate(5);
        return view('admin.emails.index',compact('countries','emails'));
    }

    public function view(Request $request){
       
        $date = null;
        $countries = null;
        if(count($request->country) > 0){
            $countries = json_encode($request->country);
        }
        if(!empty($request->date)){
            $date = $request->date;
        }
        return view('admin.emails.send',compact('countries','date'));
    }

    public function send(Request $request){
  
       $subject = $request->subject;
       $message = $request->message;

       $all_users = [];
    //    dd(html_entity_decode($message));
       $users = User::all();
       if($request->countres != null){
            $countries = json_decode($request->countres[0]);
            foreach($users as $u){

                if($u->country_code != null && in_array($u->country_code,$countries)){
                    array_push($all_users,$u->id);
                    Mail::to($u->email)->send(new CriteriaEmail($subject,$message));
                }
            }
       }

       if($request->date != null){
        
        foreach($users as $u){
            $booking = Booking::where('user_id',$u->id)->latest()->first();
            if(!empty($booking)){
                $d = explode(" ",$booking->created_at);
                if($request->date == $d[0]){
                    array_push($all_users,$u->id);
                    Mail::to($u->email)->send(new CriteriaEmail($subject,$message));
                }
            }
        }
        }

        if(count($all_users) > 0){
            $e = new Email();
            $e->subject = $subject;
            $e->message = $message;
            $e->users = json_encode(array_unique($all_users));
    
            $e->save();
        }
       

        return redirect()->route('emails.index');
        
    }



    public function resend(Request $request){
  
        // dd($request->all());
        $userids = json_decode($request->userids);
        $subject = $request->subject;
        $message = $request->message;
     //    dd(html_entity_decode($message));
        $users = User::all();
        
 
        if(count($userids) > 0){
         
         foreach($users as $u){
             
                 if(in_array($u->id,$userids)){
                     Mail::to($u->email)->send(new CriteriaEmail($subject,$message));
                 }
            }
         }
        
 
         return redirect()->route('emails.index');
         
     }

    public function viewEmail($id){
        $email = Email::find($id);

        return view('admin.emails.view',compact('email'));
    }
}
