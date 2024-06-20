<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    
    use HasFactory, Notifiable;

    protected $fillable = [
        'id_indicator',
        'name',
        'cpfcnpj',
        'profile_picture',
        'address',
        'phone',
        'date_of_birth',
        'email',
        'password',
        'role',
        'preferences',
        'token',
        'wallet',
        'customer',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
