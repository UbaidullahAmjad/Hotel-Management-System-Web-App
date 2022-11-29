<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CriteriaEmail extends Mailable
{
    use Queueable, SerializesModels;


    public $m;
    public $s;
    


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($s,$m)
    {
        $this->s = $s;
        
        $this->m = $m;
        // $this->m));

        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('criteriaemail')
             ->subject($this->s)
             ->with([
           
            'mes' => $this->m,
            


            ]);
    }
}
