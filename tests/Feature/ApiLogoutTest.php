<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiLogoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_logout_revokes_only_the_current_token(): void
    {
        $user = User::factory()->create();
        $current = $user->createToken('current');
        $other = $user->createToken('other');
        $this->withToken($current->plainTextToken)->postJson('/api/logout')
            ->assertOk()->assertJsonPath('status', 'success');
        $this->assertDatabaseMissing('personal_access_tokens', ['id' => $current->accessToken->id]);
        $this->assertDatabaseHas('personal_access_tokens', ['id' => $other->accessToken->id]);
        app('auth')->forgetGuards();
        $this->withToken($current->plainTextToken)->getJson('/api/user')->assertUnauthorized();
    }

    public function test_invalid_registration_and_login_return_validation_errors(): void
    {
        $this->postJson('/api/register', [])->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'email', 'password']);
        $this->postJson('/api/login', [])->assertUnprocessable()
            ->assertJsonValidationErrors(['email', 'password']);
        $this->postJson('/api/register', [
            'name' => 'Test', 'email' => 'test@example.com',
            'password' => '12345678', 'password_confirmation' => 'different',
        ])->assertUnprocessable()->assertJsonValidationErrors('password');
        $this->assertDatabaseCount('users', 0);
        $this->getJson('/api/user')->assertUnauthorized();
        $this->postJson('/api/logout')->assertUnauthorized();
    }
}
