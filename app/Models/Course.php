<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'course';
    protected $primaryKey = 'courseCode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'courseCode', 'courseName', 'courseDesc', 'courseSem', 'courseCreds',
        'courseLocBuilding', 'courseLocRoom', 'coursePreReq', 'courseDate', 'courseTime', 'progCode', 'staffNum'
    ];

    /**
     * Get the programme that owns the course.
     */
    public function programme()
    {
        return $this->belongsTo(Programme::class, 'progCode', 'progCode');
    }

    /**
     * Get the lecturer that teaches the course.
     */
    public function lecturer()
    {
        // links 'staffNum' in course table to 'staffNum' in lecturer table
        return $this->belongsTo(Lecturer::class, 'staffNum', 'staffNum');
    }
}