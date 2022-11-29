<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmationEmail extends Mailable
{
    use Queueable, SerializesModels;


    public $r;
    public $rs;
    public $ra;
    public $b;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($r,$ra,$rs,$b)
    {
        $this->r = $r;
        $this->rs = $rs;
        $this->ra = $ra;

        $this->b = $b;

        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('confirmemail')
             ->subject('Booking Confirmation Email')
             ->with([
            'r_data' => $this->r,
            'r_s_data' => $this->rs,
            'r_a_data' => $this->ra,
            'booking' => $this->b,


            ]);
    }
}
