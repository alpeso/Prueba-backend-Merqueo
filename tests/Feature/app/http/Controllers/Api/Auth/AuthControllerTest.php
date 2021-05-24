<?php

namespace Tests\Feature\app\http\Controllers\Api\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Entities\Users\User;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{    
    use RefreshDatabase;  

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('passport:install');
    }

    public function test_signup(): void
    {
        $response = $this->post(route('signup'), User::factory()->raw(['name', 'email', 'password']) , [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(201);
    }

    public function test_login_unauthorized(): void
    {
        $userFactory = User::factory()->create();

        $response = $this->post(route('login'), [
            'email' => $userFactory->email,
            'password' => '_password_incorrect',
            'remember_me' => true
        ], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401);
    }

    public function test_login_authorized(): void
    {
        $userFactory = User::factory()->create();
        
        $response = $this->post(route('login'), [
            'email' => $userFactory->email,
            'password' => 'password',
            'remember_me' => true
        ], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure(['access_token', 'token_type', 'expires_at']);
        
        $this->assertAuthenticated();
    }
}
