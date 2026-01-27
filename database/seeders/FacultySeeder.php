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
             'facDesc' => 'The Faculty of Computing (FC) at Universiti Teknologi Malaysia (UTM) is a leading institution dedicated to excellence in computer science and information technology education, research, and innovation. Established with the mission to advance knowledge and foster technological advancements, FC UTM offers a wide range of undergraduate and postgraduate programs that equip students with the skills and expertise needed to thrive in the rapidly evolving digital landscape. The faculty is renowned for its cutting-edge research initiatives, state-of-the-art facilities, and strong industry collaborations, making it a hub for nurturing future leaders in the field of computing. With a commitment to academic excellence and societal impact, FC UTM continues to contribute significantly to the development of the IT sector both locally and globally.'],

            ['facCode' => 'FS', 
             'facName' => 'Faculty of Science',
             'facDesc' => 'The Faculty of Science (FS) at Universiti Teknologi Malaysia (UTM) is a prestigious academic division dedicated to advancing scientific knowledge and fostering innovation across various scientific disciplines. Established with a commitment to excellence in education and research, FS UTM offers a diverse range of undergraduate and postgraduate programs that equip students with a strong foundation in the sciences. The faculty is known for its cutting-edge research initiatives, state-of-the-art laboratories, and collaborative projects that address real-world challenges. With a focus on interdisciplinary approaches and a commitment to sustainability, FS UTM plays a vital role in shaping the future of science and technology, contributing significantly to both local and global scientific communities.'],
        ]);
    }
}