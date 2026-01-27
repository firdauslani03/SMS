<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Programme extends Model
{
    protected $table = 'programme';
    protected $primaryKey = 'progCode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'progCode', 'progName', 'progYears', 'facCode'
    ];
}