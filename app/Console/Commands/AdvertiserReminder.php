<?php

namespace App\Console\Commands;

use App\Jobs\RemindAdvertiser;
use App\Models\Ad;
use App\Repositories\AdRepository;
use Illuminate\Console\Command;

class AdvertiserReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'advertiser:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
    public function handle(AdRepository $adRepository)
    {
        $ads = $adRepository->tomorrowAds();
        foreach ($ads as $ad) {
            RemindAdvertiser::dispatch($ad);
        }
    }
}
