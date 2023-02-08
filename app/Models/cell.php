<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cell extends Model
{
    use HasFactory;
    protected $fillable = [
        'row',
        'col',
        'data',
    ];
    protected $hidden = [
        'sid'
    ];
}
