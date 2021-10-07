<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Car;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CarControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    const CAR_JSON_STRUCTURE = ['brand_id', 'name', 'created_by'];

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
    public function test_car_created_and_json_returned()
    {
        $carName = 'testCarName';

        $creator = User::factory()->create();
        $brand = Brand::factory()->create();

        $brandJson = $this->post('/api/cars', [
            'brand_id' => $brand->id,
            'name' => $carName,
            'created_by' => $creator->id
        ]);

        $brandJson->assertOk();

        $car = Car::query()->latest('created_at')->first();

        $this->assertModelExists($car);

        $this->assertEquals($brand->id, $car->brand->id);
        $this->assertEquals($carName, $car->name);
        $this->assertEquals($creator->id, $car->created_by);

        $brandJson->assertJsonStructure(self::CAR_JSON_STRUCTURE);

        $brandJson->assertJsonFragment(['brand_id' => $brand->id])
            ->assertJsonFragment(['name' => $carName])
            ->assertJsonFragment(['created_by' => $creator->id]);
    }

    public function test_car_name_updated_and_json_returned()
    {
        $brand = Brand::factory()->create();
        $car = Car::factory()->create(['brand_id' => $brand->id]);
        $newName = 'name-changed';

        $brandJson = $this->patch('/api/cars/' . $car->id, [
            'name' => $newName
        ]);
        $brandJson->assertOk();
        $car = $car->fresh();

        $brandJson->assertJsonStructure(self::CAR_JSON_STRUCTURE);

        $brandJson->assertJsonFragment(['brand_id' => $brand->id])
            ->assertJsonFragment(['name' => $newName])
            ->assertJsonFragment(['created_by' => $car->created_by]);

        $this->assertEquals($newName, $car->name);
    }

    public function test_car_deleted_and_bool_returned()
    {
        $car = Car::factory()->create();
        $response = $this->delete('/api/cars/'.$car->id);
        $car = $car->fresh();
        $response->assertOk();


        $this->assertTrue((bool)$response->content());
        $this->assertFalse(isset($car));
    }

}
