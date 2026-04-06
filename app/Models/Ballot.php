<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ballot extends Model
{
    protected $fillable = [
        'user_id', 'election_id', 'has_voted', 'voted_at',
    ];

    protected $casts = [
        'has_voted' => 'boolean',
        'voted_at'  => 'datetime',
    ];

    public function user()     { return $this->belongsTo(User::class); }
    public function election() { return $this->belongsTo(Election::class); }
}