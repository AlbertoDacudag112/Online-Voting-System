<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
    protected $fillable = [
        'title', 'description', 'start_date',
        'end_date', 'status', 'created_by',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date'   => 'datetime',
    ];

    public function creator()    { return $this->belongsTo(User::class, 'created_by'); }
    public function positions()  { return $this->hasMany(Position::class); }
    public function candidates() { return $this->hasMany(Candidate::class); }
    public function votes()      { return $this->hasMany(Vote::class); }
    public function ballots()    { return $this->hasMany(Ballot::class); }
}