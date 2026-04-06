<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
        'role', 'voter_id', 'is_active',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'is_active'         => 'boolean',
    ];

    public function votes()     { return $this->hasMany(Vote::class); }
    public function ballots()   { return $this->hasMany(Ballot::class); }
    public function elections() { return $this->hasMany(Election::class, 'created_by'); }
    public function isAdmin()   { return $this->role === 'admin'; }
}