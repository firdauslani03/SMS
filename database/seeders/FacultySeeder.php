<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed Faculty
        DB::table('faculty')->insertOrIgnore([
            ['facCode' => 'FC', 
             'facName' => 'Faculty of Computing',
             'facDesc' => 'The Faculty of Computing (FC) at Universiti Teknologi Malaysia (UTM) is a leading institution dedicated to excellence in computer science and information technology education, research, and innovation.'],

            ['facCode' => 'FS', 
             'facName' => 'Faculty of Science',
             'facDesc' => 'The Faculty of Science (FS) at Universiti Teknologi Malaysia (UTM) is a prestigious academic division dedicated to advancing scientific knowledge and fostering innovation across various scientific disciplines.'],
        ]);
    }
}