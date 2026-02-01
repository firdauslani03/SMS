<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class ITStaff extends Authenticatable
{
    use Notifiable;

    protected $table = 'it_staff';
    protected $primaryKey = 'staffNum';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'staffNum', 'fName', 'lName', 'ic', 'email', 'pass', 'countryCode', 'phoneOp', 'subNum'
    ];

    protected $hidden = [
        'pass',
    ];

    // Map 'pass' to Laravel's expected 'password' field
    public function getAuthPassword()
    {
        return $this->pass;
    }
}