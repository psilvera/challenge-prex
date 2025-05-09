<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Faker\Factory as Faker;

class UserSeeder extends Seeder {

    public function run(): void {

        // uno harcodeado para tests y coleccion de postman

        User::create([
            'name' => 'Prex Challenge',
            'email' => 'prex_challenge@prexcard.com',
            'password' => Hash::make('pr3x1235')
        ]);

        $faker = Faker::create();

        // algunos mas por si se necesitan
        for ($i = 0; $i < 5; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('pr3x1235'),
            ]);
        }
    }
}
