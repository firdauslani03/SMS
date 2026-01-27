<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgrammeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed Programmes
        DB::table('programme')->insertOrIgnore([
            [
                'progCode' => 'SECPH',
                'progName' => 'Bachelor of Computer Science (Data Engineering)',
                'progYears' => 4,
                'facCode' => 'FC',
            ],
            [
                'progCode' => 'SECBH',
                'progName' => 'Bachelor of Computer Science (Bioinformatics)',
                'progYears' => 4,
                'facCode' => 'FC',
            ],
            [
                'progCode' => 'SSCAH',
                'progName' => 'Bachelor of Science (Chemistry)',
                'progYears' => 4,
                'facCode' => 'FS',
            ],
            [
                'progCode' => 'SSCEH',
                'progName' => 'Bachelor of Science (Mathematics)',
                'progYears' => 4,
                'facCode' => 'FS',
            ],
        ]);
    }
}