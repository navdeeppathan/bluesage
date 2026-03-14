<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientTestimonial extends Model
{
    use HasFactory;

    protected $table = 'client_testimonials';

    protected $fillable = [
        'name',
        'designation',
        'message',
        'image',
        'status'
    ];
}