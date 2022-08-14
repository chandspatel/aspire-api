<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoansTest extends TestCase
{
    use RefreshDatabase;

    
    public function test_check_user_get_loan_list()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get('/api/loans');
        $response->assertJsonFragment(['code'=>200]);

        $response->assertStatus(200);
    }


    public function test_create_user_loan()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->post('/api/create-loan', [
            'loan_amount' => 1500,
            'loan_term' => 10
        ]);
        $response->assertJsonFragment(['code'=>200]);
        $response->assertStatus(200);
    }


    public function test_admin_can_approve_user_loan()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->post('/api/approve-loans', [
            'loan_id' => 1
        ]);
        $response->assertJsonFragment(['code'=>200]);
        $response->assertStatus(200);
    }
}
