<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    
    use RefreshDatabase;
    
    public function test_customer_and_admin_can_login()
    {
        $user = User::factory()->create();
        $response = $this->post('/api/login',[
            "email" => $user->email,
            "password" => 'password',
            "user_type" => 0
        ]);
        $response->assertJsonFragment(['code'=>200]);

        $response->assertStatus(200);
    }
}
