<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login_redirect_to_homepage_successfullly()
    {
        User::factory()->create([
            'name' => 'TestUser',
            'email' => 'testuser@gmail.com',
            'password' => Hash::make('12345678'),
            'status' => 'buyer',
        ]);

        $response = $this->post('/login', [
            'name' => 'TestUser',
            'email' => 'testuser@gmail.com',
            'password' => '12345678',
            'status' => 'buyer',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/');
    }
}
