<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use Faker\Generator as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        for ($i=0; $i < 10; $i++) { 
            $role = $faker->randomElement(['superadmin', 'manager', 'supervisor', 'operator']);
            $gender = $faker->randomElement(['male', 'female']);
            DB::table('users')->insert([
                'name' => $faker->name($gender),
                'email' => $faker->safeEmail(),
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => $role,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        
    }
}
