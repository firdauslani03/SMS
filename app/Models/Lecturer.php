<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Lecturer extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'lecturer';
    protected $primaryKey = 'staffNum';
    public $incrementing = false;
    protected $keyType = 'string';
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

    protected $hidden = [
        'pass', 'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->pass;
    }

    public function courses()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel, localKey)
        return $this->hasMany(Course::class, 'staffNum', 'staffNum');
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'facCode', 'facCode');
    }
}