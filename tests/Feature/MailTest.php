<?php

namespace Tests\Feature;

use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MailTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        //check if send to non-existing email
        ($this->sendMailToAdmin())
            ->assertStatus(400)
            ->assertJson(
                [
                    'success' => false,
                    'error' => [
                        'exception_message' => __('messages.company.error.invalid_email'),
                        'exception_code' => 0
                    ]
                ]
            );

        Company::create([
            'email' => 'admin@email.com',
            'name' => 'Admin',
            'phone' => fake()->phoneNumber(),
            'description' => fake()->text(255),
            'city' => fake()->city,
            'UF' => fake()->stateAbbr
        ]);

        //check if send to existing email
        ($this->sendMailToAdmin())
            ->assertStatus(200)
            ->assertJson(['success' => true, 'jsonData' => []]);
    }

    public function sendMailToAdmin()
    {
        return ($this->postJson(
            '/api/send-mail',
            [
                'email' => 'admin@email.com',
                'subject' => 'Testing email',
                'message' => 'Testing email'
            ]
        ));
    }
}
