<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Student extends Authenticatable
{
    use Notifiable;

    // Link to your specific table
    protected $table = 'student';

    // Define your custom primary key (since it's not 'id')
    protected $primaryKey = 'matricNum';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    // Allow these columns to be filled
    protected $fillable = [
        'matricNum', 'fName', 'lName', 'ic', 'email', 'pass',
        'year', 'semester', 'countryCode', 'phoneOp', 'subNum', 'cgpa', 'facCode', 'progCode'
    ];

    // Hide the password column from array outputs
    protected $hidden = [
        'pass', 'remember_token',
    ];

    // Tell Laravel that your password column is named 'pass', not 'password'
    public function getAuthPassword()
    {
        return $this->pass;
    }
}