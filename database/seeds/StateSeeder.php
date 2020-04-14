<?php

use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $provinces = array(
            'Central',
            'Chimbu',
            'Eastern Highlands',
            'East New Britain',
            'East Sepik',
            'Enga',
            'Gulf',
            'Madang',
            'Manus',
            'Milne Bay',
            'Morobe',
            'New Ireland',
            'Oro (Northern)',
            'Autonomous Region of Bougainville',
            'Southern Highlands',
            'Western (Fly)',
            'Western Highlands',
            'West New Britain',
            'Sandaun (West Sepik)',
            'National Capital District',
            'Hela',
            'Jiwaka'
        );
        for ($i=0; $i < count($provinces); $i++) { 
            DB::table('states')->insert([
                'name' => $provinces[$i],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
