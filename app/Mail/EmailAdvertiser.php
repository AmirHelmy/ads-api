<?php

namespace App\Mail;

use App\Models\Ad;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailAdvertiser extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $ad;

    public function __construct(Ad $ad)
    {
        $this->ad = $ad;
    }


    public function build()
    {
        return $this
        ->subject($this->ad->title . ' Will Start Tomorrow')
        ->markdown('emails.advertiser_reminder');
    }
}
