<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ITStaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = Hash::make('password');

        DB::table('it_staff')->insertOrIgnore([
            [
                'staffNum' => 'IT1001',
                'fName' => 'Wriothesley',
                'lName' => 'Duke',
                'ic' => '951123015001',
                'email' => 'wrio.admin@staff.utm.my',
                'pass' => $password,
                'countryCode' => '60',
                'phoneOp' => '11',
                'subNum' => '9988776',
            ],
        ]);
    }
}