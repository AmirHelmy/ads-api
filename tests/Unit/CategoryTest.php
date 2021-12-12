<?php

namespace Tests\Unit;

use App\Models\Ad;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;

    public function test_list_categories()
    {
        $categories = Category::factory(9)->create();
        $response = $this->json('get', 'api/category');
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

    public function test_create_category()
    {
        $category = Category::factory()->create();

        $response = $this->json('get', "api/category/{$category->id}");
        $response->assertOk();

        $response->assertSee($category->name);
    }

    public function test_updata_category()
    {
        $category = Category::factory()->create();
        $newName = $category->name . ' updated';

        $response = $this->json('patch', "api/category/{$category->id}", [
            'name' => $newName
        ]);
        $response->assertOk();
        $this->assertEquals($newName, $response['data']['name']);
    }

    public function test_delete_category()
    {
        $category = Category::factory()->create();
        $this->json('delete', "api/category/{$category->id}");
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);


        $linkedCategory = Category::factory()->create();

        Ad::factory(1)
            ->for(User::factory()->create(), 'advertiser')
            ->for($linkedCategory)
            ->typed()
            ->create();

        $response = $this->json('delete', "api/category/{$linkedCategory->id}");
        $response->assertStatus(409);
    }
}
