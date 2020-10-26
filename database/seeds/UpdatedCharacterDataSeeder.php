<?php

use Illuminate\Database\Seeder;

class UpdatedCharacterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('updated_character_data')->insert([
            [
                'name'               => 'C-3PO',
                'height'             => '167',
                'mass'               => '75',
                'hair_color'         => 'n/a',
                'birth_year'         => '112BBY',
                'gender'             => 'female',
                'homeworld_name'     => 'Geonosis',
                'species_name'       => 'Kangaroo',
            ],
            [
                'name'               => 'R2-D2',
                'height'             => '96',
                'mass'               => '32',
                'hair_color'         => 'n/a',
                'birth_year'         => '33BBY',
                'gender'             => 'female',
                'homeworld_name'     => 'Naboo',
                'species_name'       => 'Gungan',
            ],
            [
                'name'               => 'Chewbacca',
                'height'             => '228',
                'mass'               => 'testing!',
                'hair_color'         => 'brown',
                'birth_year'         => '200BBY',
                'gender'             => 'male',
                'homeworld_name'     => 'Mars',
                'species_name'       => 'Wookiee',
            ],
            [
                'name'               => 'Yoda',
                'height'             => '23',
                'mass'               => '17',
                'hair_color'         => 'purple',
                'birth_year'         => '896BBY',
                'gender'             => 'male',
                'homeworld_name'     => 'Malastare',
                'species_name'       => 'Dug',
            ],
        ]);
    }
}
