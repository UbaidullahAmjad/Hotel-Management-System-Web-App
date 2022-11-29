<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\ReminderEmail;
use App\Mail\WelcomeEmail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;


class SendEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booking:bookingstatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Booking status to every one via email';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::join('bookings','bookings.user_id','users.id')
                ->get();
    foreach($users as $user){
        $now = date('Y-m-d');
        $d = explode(" ",$user->created_at);

        if($now < $d[0]){
            $date1 = DateTime::createFromFormat('Y-m-d', $now);
            $date2 = DateTime::createFromFormat('Y-m-d', $d[0]);
            $datefrom = $date1->format('Y-m-d');
            $dateto = $date2->format('Y-m-d');
            $datediff = strtotime($dateto) - strtotime($datefrom);
            $days = (int)round($datediff / (60 * 60 * 24));
    
            if($days == 7){
                Mail::to($user->email)->send(new ReminderEmail($user->booking_no));
            }
    
            if($days == 0){
                Mail::to($user->email)->send(new WelcomeEmail());
            }
        }
       

    }
    }
}
