<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Define which Faculty each Program belongs to (matching ProgrammeSeeder)
        $programs = [
            'SECPH' => 'FC',
            'SECBH' => 'FC',
            'SSCAH' => 'FS',
            'SSCEH' => 'FS'
        ];

        // We only have courses for Semesters 1, 2, and 3 in the CourseSeeder.
        // We will create student cohorts for these semesters to populate those courses.
        $semesters = [1, 2, 3];

        foreach ($programs as $progCode => $facCode) {
            foreach ($semesters as $sem) {
                // Constraint: Make sure courses have at least 4 and max 14 students.
                $numberOfStudents = rand(4, 14);

                // Get courses offered for this Program and Semester
                $courses = DB::table('course')
                            ->where('progCode', $progCode)
                            ->where('courseSem', $sem)
                            ->pluck('courseCode');

                if ($courses->isEmpty()) {
                    continue;
                }

                for ($i = 0; $i < $numberOfStudents; $i++) {
                    // Determine Matric Prefix based on Faculty
                    // FC (Faculty of Computing) -> 'CS'
                    // FS (Faculty of Science)   -> 'FS'
                    $facultyPrefix = ($facCode === 'FC') ? 'CS' : 'FS';

                    // Generate Matric Num: A25 + FacultyPrefix + 4 random digits
                    // Format: A25CSxxxx or A25FSxxxx
                    $matricNum = 'A25' . $facultyPrefix . $faker->unique()->numberBetween(1000, 9999);
                    
                    $fName = $faker->firstName;
                    $lName = $faker->lastName;

                    // Generate Email with @graduate.utm.my domain
                    // We append a random number to the name to ensure uniqueness and realism
                    $email = strtolower($fName . '.' . $lName . $faker->numberBetween(1, 999) . '@graduate.utm.my');

                    $yearOfStudy = ceil($sem / 2);
                    
                    // Create Student
                    DB::table('student')->insertOrIgnore([
                        'matricNum' => $matricNum,
                        'fName' => $fName,
                        'lName' => $lName,
                        'ic' => $faker->unique()->numerify('############'), // 12 digits
                        'email' => $email,
                        'pass' => Hash::make('password'), // Default password
                        'year' => $yearOfStudy,
                        'semester' => $sem,
                        'countryCode' => 'MAS',
                        'phoneOp' => '01',
                        'subNum' => $faker->numerify('########'), // 8 digits
                        'cgpa' => $faker->randomFloat(2, 2.00, 4.00),
                        'facCode' => $facCode,
                        'progCode' => $progCode,
                    ]);

                    // Enroll Student in ALL courses for their current semester
                    foreach ($courses as $courseCode) {
                        DB::table('registration')->insertOrIgnore([
                            'courseCode' => $courseCode,
                            'matricNum' => $matricNum,
                            'status' => 'Active',
                            'registrationDate' => now()->toDateString(),
                            'registrationTime' => now()->toTimeString(),
                            'modifyCourseCode' => null,
                        ]);
                    }
                }
            }
        }
    }
}