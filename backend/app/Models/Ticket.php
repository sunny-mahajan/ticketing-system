<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent; // Use alias to avoid conflicts

class Ticket extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'tickets';

    protected $fillable = ['title', 'description', 'status'];

    protected $attributes = [
        'status' => 'open', // Set default status
    ];
}
