<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Ortu extends User
{
    use HasFactory, Notifiable, HasApiTokens;
    
    protected $table = 'ortu';
    protected $guarded = [];
}
