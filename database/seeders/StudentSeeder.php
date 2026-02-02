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

        // Define which Faculty each Program belongs to
        $programs = [
            'SECPH' => 'FC',
            'SECBH' => 'FC',
            'SSCAH' => 'FS',
            'SSCEH' => 'FS'
        ];

        // Semesters to populate
        $semesters = [1, 2, 3];

        foreach ($programs as $progCode => $facCode) {
            foreach ($semesters as $sem) {
                // Constraint: Make sure courses have at least 4 and max 14 students.
                // explicitly set SECPH Semester 2 to have 14 students.
                if ($progCode === 'SECPH' && $sem === 2) {
                    $numberOfStudents = 14;
                } else {
                    $numberOfStudents = rand(4, 14);
                }

                // Get courses offered for this Program and Semester
                $courses = DB::table('course')
                            ->where('progCode', $progCode)
                            ->where('courseSem', $sem)
                            ->pluck('courseCode');

                if ($courses->isEmpty()) {
                    continue;
                }

                for ($i = 0; $i < $numberOfStudents; $i++) {
                    $facultyPrefix = ($facCode === 'FC') ? 'CS' : 'FS';

                    // Generate Matric Num: A25 + FacultyPrefix + 4 random digits
                    $matricNum = 'A25' . $facultyPrefix . $faker->unique()->numberBetween(1000, 9999);
                    
                    $fName = $faker->firstName;
                    $lName = $faker->lastName;
                    $email = strtolower($fName . '.' . $lName . $faker->numberBetween(1, 999) . '@graduate.utm.my');
                    $yearOfStudy = ceil($sem / 2);
                    
                    // 1. Create Student
                    DB::table('student')->insertOrIgnore([
                        'matricNum' => $matricNum,
                        'fName' => $fName,
                        'lName' => $lName,
                        'ic' => $faker->unique()->numerify('############'),
                        'email' => $email,
                        'pass' => Hash::make('password'),
                        'year' => $yearOfStudy,
                        'semester' => $sem,
                        'countryCode' => 'MAS',
                        'phoneOp' => '01',
                        'subNum' => $faker->numerify('########'),
                        'cgpa' => $faker->randomFloat(2, 2.00, 4.00),
                        'facCode' => $facCode,
                        'progCode' => $progCode,
                    ]);

                    // 2. Register Student for Available Courses with 'Approved' status
                    foreach ($courses as $courseCode) {
                    // A. Get the current capacity info for this specific course
                    $course = DB::table('course')->where('courseCode', $courseCode)->first();

                    // B. Count how many students are ALREADY registered
                    $currentCount = DB::table('registration')
                        ->where('courseCode', $courseCode)
                        ->where('status', 'Approved')
                        ->count();

                    // C. Check if there is space (assuming the column is named 'capacity')
                    if ($course && $currentCount < $course->capacity) {
                        
                        DB::table('registration')->insertOrIgnore([
                            'courseCode' => $courseCode,
                            'matricNum' => $matricNum,
                            'status' => 'Approved',
                            'registrationDate' => $faker->date(),
                            'registrationTime' => $faker->time(),
                            'modifyCourseCode' => null,
                        ]);

                    } else {
                        // Optional: You could register them with 'Rejected' status if full
                        // or just skip them (do nothing).
                    }
                }
            }
        }
    }
}
}