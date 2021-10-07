<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Car;
use App\Models\User;
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
        // \App\Models\User::factory(10)->create();


        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => 'password'
        ]);

        $audi = Brand::create([
            'name' => 'Audi',
            'created_by' => $admin->id
        ]);
        $opel = Brand::create([
            'name' => 'Opel',
            'created_by' => $admin->id
        ]);

        $a6 = Car::create([
           'brand_id' => $audi->id,
           'name' => 'a6',
            'created_by' => $admin->id
        ]);

        $r8 = Car::create([
            'brand_id' => $audi->id,
            'name' => 'r8',
            'created_by' => $admin->id
        ]);

        $corsa = Car::create([
            'brand_id' => $opel->id,
            'name' => 'Corsa',
            'created_by' => $admin->id
        ]);

        $astra = Car::create([
            'brand_id' => $opel->id,
            'name' => 'Astra',
            'created_by' => $admin->id
        ]);

    }
}
