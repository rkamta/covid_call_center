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
        DB::table('users')->insert([
            'name' => '$faker->name($gender)',
            'email' => 'superadmin@pngcovid-19.live',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'superadmin',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('users')->insert([
            'name' => '$faker->name($gender)',
            'email' => 'manager@pngcovid-19.live',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'manager',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('users')->insert([
            'name' => '$faker->name($gender)',
            'email' => 'supervisor@pngcovid-19.live',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'supervisor',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('users')->insert([
            'name' => '$faker->name($gender)',
            'email' => 'operator@pngcovid-19.live',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'operator',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        for ($i=0; $i < 10; $i++) { 
            $role = $faker->randomElement(['manager', 'supervisor', 'operator']);
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
