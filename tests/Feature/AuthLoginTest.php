<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Http\Requests\LoginRequest;
use Database\Seeders\UserDatabaseSeeder;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(UserDatabaseSeeder::class);
    }

    /**
     *@test Login admin test.
     */
    public function login_admin_test()
    {
        $loginRequest = new LoginRequest(['email' => 'iurru@iurru.com', 'password' => 'iurru']);

        $response = $this->postJson('/api/login', $loginRequest->all());

        $response->assertStatus(200);

        $response
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->where('success', true)
                    ->has('data.Authentication')
            );

        $adminToken = explode('|', json_decode($response->content())->data->Authentication)[1];

        //check if access admin routes
        $response = $this->getJson('api/admin/isconnected', ['Authorization' => "Bearer " . $adminToken]);
        $response->assertStatus(200);
        $response->assertJson(fn ($json) => $json->where('success', true)->where('data.isconnected', true));
        //check if access user routes
        $response = $this->getJson('api/user/isconnected', ['Authorization' => "Bearer " . $adminToken]);
        $response->assertStatus(200);
        $response->assertJson(fn ($json) => $json->where('success', true)->where('data.isconnected', true));
    }

    /**
     *@test Login user test.
     */
    public function login_user_test()
    {

        $loginRequest = new LoginRequest(['email' => 'user@iurru.com', 'password' => 'iurru']);

        $response = $this->postJson('/api/login', $loginRequest->all());

        $response->assertStatus(200);

        $response
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->where('success', true)
                    ->has('data.Authentication')
            );

        $userToken = explode('|', json_decode($response->content())->data->Authentication)[1];
        //check if not access admin routes
        $response = $this->getJson('api/admin/isconnected', ['Authorization' => "Bearer " . $userToken]);
        $response->assertStatus(401);
        $response->assertJson(fn ($json) => $json->where('success', false)->where('error', __('auth.unauthorized')));
        //check if access user routes
        $response = $this->getJson('api/user/isconnected', ['Authorization' => "Bearer " . $userToken]);
        $response->assertStatus(200);
        $response->assertJson(fn ($json) => $json->where('success', true)->where('data.isconnected', true));
    }

    /**
     *@test Login user test.
     */
    public function login_error_test()
    {
        $loginRequest = new LoginRequest(['email' => 'noBody@iurru.com', 'password' => 'incorrect_password']);

        $response = $this->postJson('/api/login', $loginRequest->all());

        $response->assertStatus(500);

        $response
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->where('success', false)
                    ->where('error', __('auth.failed'))
            );
    }

    /**
     * @test Test the loginRequest
     */
    public function login_request_without_email_test()
    {
        $response = $this->postJson('/api/login', ['password' => 'any_password']);

        $response->assertStatus(422);

        $response
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->where('success', false)
                    ->has('error.email')
            );
    }

    /**
     * @test Test the loginRequest
     */
    public function login_request_invalid_email_test()
    {
        $response = $this->postJson('/api/login', ['email' => 'invalid_email', 'password' => 'any_password']);

        $response->assertStatus(422);

        $response
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->where('success', false)
                    ->has('error.email')
            );
    }

    /**
     * @test Test the loginRequest
     */
    public function login_request_without_password_test()
    {
        $response = $this->postJson('/api/login', ['email' => 'any@iurru.com']);

        $response->assertStatus(422);

        $response
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->where('success', false)
                    ->has('error.password')
            );
    }

    /**
     * @test Test the loginRequest
     */
    public function login_request_invalid_password_test()
    {
        $response = $this->postJson('/api/login', ['email' => 'any@iurru.com', 'password' => '']);

        $response->assertStatus(422);

        $response
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->where('success', false)
                    ->has('error.password')
            );
    }
}
