<?php

namespace Database\Seeders;

use App\Models\Ad;
use App\Models\Tag;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Ad::factory(30)
            ->for(User::factory()->create(), 'advertiser')
            ->has(Tag::factory()->count(3), 'tags')
            ->typed()
            ->create();
    }
}
