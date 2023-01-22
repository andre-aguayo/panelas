<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Address;
use App\Models\CreditCard;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create admin
        User::create([
            'name' => 'iurru',
            'email' => 'iurru@iurru.com',
            'password' =>  Hash::make('iurru'),
            'as_admin' => 1,
        ])->each(function ($admin) {
            CreditCard::factory(1)->create(['user_id' => $admin->id]);

            Address::factory(1)->create(['user_id' => $admin->id]);
        });

        // Create a common user
        User::create([
            'name' => 'iurru',
            'email' => 'user@iurru.com',
            'password' =>  Hash::make('iurru'),
            'as_admin' => 0,
        ])->each(function ($user) {
            CreditCard::factory(1)->create(['user_id' => $user->id]);

            Address::factory(1)->create(['user_id' => $user->id]);
        });
    }
}
