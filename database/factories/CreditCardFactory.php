<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class CreditCardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $creditCardType = fake()->creditCardType();

        return [
            'cardholder_name' => fake('pt_BR')->unique()->safeEmail(),
            'card_type' => $creditCardType,
            'number' =>  fake()->creditCardNumber($creditCardType),
            'expiration_date' => fake()->creditCardExpirationDateString(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
