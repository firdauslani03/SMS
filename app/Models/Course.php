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
        'courseLocBuilding', 'courseLocRoom', 'coursePreReq', 'courseDate', 'courseTime', 'progCode'
    ];

    /**
     * Get the programme that owns the course.
     */
    public function programme()
    {
        return $this->belongsTo(Programme::class, 'progCode', 'progCode');
    }
}