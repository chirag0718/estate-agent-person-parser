<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @author Chiragkumar Patel
 */
class Person extends Model
{
    use HasFactory;

    protected $table = 'persons';
    protected $fillable = ['title', 'first_name', 'last_name', 'initial_name'];
}
