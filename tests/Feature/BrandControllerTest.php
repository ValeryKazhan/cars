<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BrandControllerTest extends TestCase
{
    use RefreshDatabase;

    const BRAND_JSON_STRUCTURE = ['name', 'created_by'];

    public function setUp(): void
    {
        parent::setUp();

        $name = 'admin';
        $email = 'admin@gmail.com';
        $password = 'password';

        $admin = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password
        ]);

        $token = $this->post('/api/login', [
            'email' => $admin->email,
            'password' => $password
        ])->json('message');

        $this->withHeader('Authorization', $token);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_brand_created_and_json_returned()
    {
        $brandName = 'volksvagen';

        $creator = User::factory()->create();

        $brandJson = $this->post('/api/brands', [
            'name' => $brandName,
            'created_by' => $creator->id
        ]);

        $brandJson->assertOk();

        $brand = Brand::query()->latest('created_at')->first();

        $this->assertModelExists($brand);

        $this->assertEquals($brandName, $brand->name);
        $this->assertEquals($creator->id, $brand->created_by);

        $brandJson->assertJsonStructure(self::BRAND_JSON_STRUCTURE);

        $brandJson->assertJsonFragment(['name' => $brandName])
            ->assertJsonFragment(['created_by' => $creator->id]);
    }

    public function test_brand_name_updated_and_json_returned()
    {
        $brand = Brand::factory()->create();
        $newName = 'name-changed';

        $brandJson = $this->patch('/api/brands/' . $brand->id, [
            'name' => $newName
        ]);
        $brandJson->assertOk();
        $brand = $brand->fresh();

        $brandJson->assertJsonStructure(self::BRAND_JSON_STRUCTURE);

        $brandJson->assertJsonFragment(['name' => $newName])
            ->assertJsonFragment(['created_by' => $brand->created_by]);

        $this->assertEquals($newName, $brand->name);
    }

    public function test_brand_deleted_and_bool_returned()
    {
        $brand = Brand::factory()->create();

        $response = $this->delete('/api/brands/'.$brand->id);
        $brand = $brand->fresh();
        $response->assertOk();

        $this->assertTrue((bool)$response->content());
        $this->assertFalse(isset($brand));
    }

    public function test_brands_are_sent_in_json()
    {
        Brand::factory(10)->create();

        $response = $this->get('/api/brands');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    "id",
                    "created_by",
                    "name",
                    "created_at",
                    "updated_at"
                ]
            ]
        ]);
        $response->assertStatus(200);
    }
}
