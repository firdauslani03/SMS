<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    use HasFactory;

    // 1. Define the table name (since it is singular 'lecturer', not plural 'lecturers')
    protected $table = 'lecturer';

    // 2. Define the primary key
    protected $primaryKey = 'staffNum';

    // 3. Disable auto-incrementing (since staffNum is a string like 'L1001')
    public $incrementing = false;

    // 4. Set the key type to string
    protected $keyType = 'string';

    // 5. Disable timestamps (unless you added $table->timestamps() to your migration manually)
    public $timestamps = false;

    protected $fillable = [
        'staffNum',
        'fName',
        'lName',
        'ic',
        'email',
        'pass',
        'countryCode',
        'phoneOp',
        'subNum',
        'department',
        'officeBuilding',
        'officeFloor',
        'officeRoom',
        'qualification',
        'facCode',
    ];

    /**
     * Relationship: A lecturer teaches many courses.
     */
    public function courses()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel, localKey)
        return $this->hasMany(Course::class, 'staffNum', 'staffNum');
    }

    /**
     * Relationship: A lecturer belongs to a faculty.
     */
    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'facCode', 'facCode');
    }
}