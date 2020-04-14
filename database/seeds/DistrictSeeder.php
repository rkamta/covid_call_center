<?php

use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        for ($i=1; $i < 23; $i++) { 
            $j = rand(2, 5);
            for ($k=0; $k<$j; $k++) {

                DB::table('districts')->insert([
                    'name' => $faker->name,
                    'state_id' => $i,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
}
