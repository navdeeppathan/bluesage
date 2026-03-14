<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insight extends Model
{
    use HasFactory;

    protected $table = 'insights';

    protected $fillable = [
        'media_type',
        'media_url',
        'status'
    ];
}