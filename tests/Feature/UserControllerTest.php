<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserControllerTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_is_registered_and_json_sent()
    {
        $testName = 'testName';
        $testEmail = 'testEmail@gmail.com';
        $password = 'password';

        $response = $this->post('/api/signup', [
            'name' => $testName,
            'email' => $testEmail,
            'password' => $password
        ]);
        $response->assertStatus(200);

        $response->assertJsonFragment(['name' => $testName]);
        $response->assertJsonFragment(['email' => $testEmail]);

        $user = User::query()->latest('created_at')->first();

        $this->assertEquals($testName, $user->name);
        $this->assertEquals($testEmail, $user->email);

    }

    public function test_user_is_logged_in_and_token_sent(){

        $testName = 'testName1';
        $testEmail = 'testEmail1@gmail.com';
        $password = 'password1';
        $tokenKey = 'message';

        $user = User::create([
           'name' => $testName,
           'email' => $testEmail,
           'password' => $password
        ]);

        $response = $this->post('/api/login', [
           'email' => $user->email,
           'password' => $password
        ]);

        $response->assertJsonStructure([$tokenKey]);
        $response->assertStatus(200);

    }

}
