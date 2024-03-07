<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $table = 'Events';
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'date',
        'time',
        'venue',
        'seats',
        'ticket_price',
    ];
}
