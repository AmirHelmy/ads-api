<?php

namespace App\Jobs;

use App\Models\Ad;
use Illuminate\Bus\Queueable;
use App\Mail\EmailAdvertiser;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class RemindAdvertiser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $ad;

    public function __construct(Ad $ad)
    {
        $this->ad = $ad;
    }

    public function handle()
    {
        Mail::to($this->ad->advertiser->email)
            ->send(new EmailAdvertiser($this->ad));
    }
}
