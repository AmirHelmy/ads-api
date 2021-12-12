<?php

namespace Tests\Unit;

use App\Models\Ad;
use App\Models\Tag;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class AdTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_list_ads()
    {
        Ad::factory(9)
            ->for(User::factory()->create(), 'advertiser')
            ->has(Tag::factory()->count(3), 'tags')
            ->typed()
            ->create();

        $response = $this->get('api/ads');
        $response->assertOk();
        $response->assertJsonCount(9, 'data');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'description',
                    'start_date',
                    'type'
                ]
            ]
        ]);
    }

    public function test_list_ads_with_filters()
    {
        Ad::factory(9)
            ->for(User::factory()->create(), 'advertiser')
            ->has(Tag::factory()->count(3), 'tags')
            ->typed()
            ->create();

        $response = $this->get('api/ads?filter[category_id]=1&filter[tags.id]=2&includes[]=category&includes[]=tags&includes[]=advertiser');
        $response->assertOk();

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'description',
                    'start_date',
                    'type',
                    'tags' => [
                        '*' => [
                            'id',
                            'name'
                        ],
                    ],
                    'category' => [
                        'id',
                        'name'
                    ],
                    'advertiser' => [
                        'id',
                        'name'
                    ]
                ]
            ]
        ]);
    }
}
