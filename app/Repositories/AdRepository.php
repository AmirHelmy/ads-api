<?php

namespace App\Repositories;

use App\Models\Ad;

class AdRepository extends BaseRepository
{

    public function __construct(Ad $model)
    {
        $this->model = $model;
        $this->extactFilters = ['category_id', 'tags.id'];
    }

    public function tomorrowAds()
    {
        return $this->model
            ->where('start_date', today()->addDay())
            ->with('advertiser')
            ->get();
    }
}
