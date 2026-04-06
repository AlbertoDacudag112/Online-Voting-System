<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'election_id', 'position_id',
        'candidate_id', 'ip_address', 'voted_at',
    ];

    protected $casts = ['voted_at' => 'datetime'];

    public function user()      { return $this->belongsTo(User::class); }
    public function election()  { return $this->belongsTo(Election::class); }
    public function position()  { return $this->belongsTo(Position::class); }
    public function candidate() { return $this->belongsTo(Candidate::class); }
}