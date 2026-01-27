<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Programme;

class Student extends Authenticatable
{
    use Notifiable;

    protected $table = 'student';
    protected $primaryKey = 'matricNum';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'matricNum', 'fName', 'lName', 'ic', 'email', 'pass',
        'year', 'semester', 'countryCode', 'phoneOp', 'subNum', 'cgpa', 'facCode', 'progCode'
    ];

    protected $hidden = [
        'pass', 'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->pass;
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'registration', 'matricNum', 'courseCode');
    }

    public function programCourses()
    {
        // Matches Student's progCode with Course's progCode
        return $this->hasMany(Course::class, 'progCode', 'progCode')->orderBy('courseSem');
    }

    public function programme()
    {
        return $this->belongsTo(Programme::class, 'progCode', 'progCode');
    }
}