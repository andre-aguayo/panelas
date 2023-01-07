<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Address;
use App\Models\CreditCard;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'iurru',
            'email' => 'iurru@iurru.com',
            'password' =>  Hash::make('iurru'),
            'as_admin' => 1,
        ]);

        CreditCard::factory(1)->create(['user_id' => $admin->id]);

        Address::factory(1)->create(['user_id' => $admin->id]);

        $user = User::create([
            'name' => 'user',
            'email' => 'user@iurru.com',
            'password' =>  Hash::make('user'),
            'as_admin' => 0,
        ]);

        CreditCard::factory(1)->create(['user_id' => $user->id]);

        Address::factory(1)->create(['user_id' => $user->id]);
    }
}
