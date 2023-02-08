<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'sname',
        'rows',
        'cols',
    ];
    protected $hidden = [
        'fid'
    ];
}
