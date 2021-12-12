<?php

namespace Tests\Unit;

use App\Models\Ad;
use App\Models\Tag;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TagTest extends TestCase
{
    use DatabaseMigrations;

    public function test_list_tags()
    {
        Tag::factory(9)->create();
        $response = $this->json('get', 'api/tag');
        $response->assertOk();
        $response->assertJsonCount(9, 'data');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name'
                ]
            ]
        ]);
    }

    public function test_create_tag()
    {
        $tag = Tag::factory()->create();

        $response = $this->json('get', "api/tag/{$tag->id}");
        $response->assertOk();

        $response->assertSee($tag->name);
    }

    public function test_updata_tag()
    {
        $tag = Tag::factory()->create();
        $newName = $tag->name . ' updated';

        $response = $this->json('patch', "api/tag/{$tag->id}", [
            'name' => $newName
        ]);
        $response->assertOk();
        $this->assertEquals($newName, $response['data']['name']);
    }

    public function test_delete_tag()
    {
        $tag = Tag::factory()->create();
        $this->json('delete', "api/tag/{$tag->id}");
        $this->assertDatabaseMissing('tags', ['id' => $tag->id]);


        $linkedTag = Tag::factory()->create();

        $ad = Ad::factory(1)
            ->for(User::factory()->create(), 'advertiser')
            ->typed()
            ->create();

        $ad->first()->tags()->attach($linkedTag);


        $response = $this->json('delete', "api/tag/{$linkedTag->id}");
        $response->assertStatus(409);
    }
}
