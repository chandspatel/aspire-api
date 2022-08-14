<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    
    public function test_customer_and_admin_can_register()
    {

        $response = $this->post('/api/register',[
            "name" => 'chands',
            "email" => 'chands@gmail.com',
            "password" => 'password',
            "password_confirmation" => 'password',
            "user_type" => 1
        ]);
        $response->assertJsonFragment(['code'=>200]);

        $response->assertStatus(200);
    }

}
