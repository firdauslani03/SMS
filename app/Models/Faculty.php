<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    // Define the table name (matches your migration)
    protected $table = 'faculty';

    // Define the primary key
    protected $primaryKey = 'facCode';

    // Since 'facCode' is a string (e.g., "FC", "FS"), disable auto-incrementing
    public $incrementing = false;
    protected $keyType = 'string';

    // Migration didn't have timestamps ($table->timestamps()), so disabled
    public $timestamps = false;

    protected $fillable = [
        'facCode',
        'facName',
        'facDesc',
    ];
}