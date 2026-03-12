<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blogs';

    protected $fillable = [
        'title',
        'slug',
        'author',
        'category',
        'image',
        'published_date',
        'description'
    ];

    protected $casts = [
        'published_date' => 'date',
    ];
}