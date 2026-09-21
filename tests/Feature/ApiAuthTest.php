<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_registered_user_can_login_and_access_their_profile(): void
    {
        $credentials = ['email' => 'auth-test@example.com', 'password' => 'Test-password-123'];

        $this->postJson('/api/register', $credentials + [
            'name' => 'Auth Test',
            'password_confirmation' => $credentials['password'],
        ])->assertCreated()->assertJsonPath('status', 'success');

        $login = $this->postJson('/api/login', $credentials)
            ->assertOk()->assertJsonPath('status', 'success');

        $this->withToken($login->json('token'))->getJson('/api/user')
            ->assertOk()->assertJsonPath('email', $credentials['email'])
            ->assertJsonMissingPath('password');
    }

    public function test_wrong_credentials_are_rejected_without_creating_a_token(): void
    {
        $user = \App\Models\User::factory()->create();

        $this->postJson('/api/login', ['email' => $user->email, 'password' => 'wrong-password'])
            ->assertUnauthorized()->assertJsonPath('status', 'error');
        $this->postJson('/api/login', ['email' => 'missing@example.com', 'password' => 'wrong-password'])
            ->assertUnauthorized();
        $this->assertDatabaseCount('personal_access_tokens', 0);
    }
}
