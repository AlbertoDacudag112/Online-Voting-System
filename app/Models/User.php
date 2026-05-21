<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    const COURSES = [
        'IT'          => 'Information Technology',
        'CS'          => 'Computer Science',
        'Engineering' => 'Engineering',
        'Nursing'     => 'Nursing',
        'Education'   => 'Education',
        'Business'    => 'Business Administration',
        'Arts'        => 'Arts and Sciences',
    ];

    const YEAR_LEVELS = [
        '1st Year' => '1st Year',
        '2nd Year' => '2nd Year',
        '3rd Year' => '3rd Year',
        '4th Year' => '4th Year',
    ];

    protected $fillable = [
        'first_name', 'middle_name', 'last_name', 'name',
        'email', 'password',
        'role', 'voter_id', 'is_active', 'course', 'year_level',
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

    public function isAdmin(): bool { return $this->role === 'admin'; }

    public function courseName(): string
    {
        if (!$this->course) return 'No course assigned';
        return self::COURSES[$this->course] ?? $this->course;
    }

    public function hasVotedForCourse(int $electionId): bool
    {
        return $this->ballots()
                    ->where('election_id', $electionId)
                    ->where('has_voted', true)
                    ->exists();
    }
}