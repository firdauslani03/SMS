<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $table = 'registration';

    // DISABLE timestamps to fix the "Unknown column 'updated_at'" error
    public $timestamps = false; 

    protected $primaryKey = ['courseCode', 'matricNum'];
    public $incrementing = false;

    protected $fillable = [
        'courseCode',
        'matricNum',
        'status',
        'registrationDate',
        'registrationTime',
        'modifyCourseCode'
    ];
}