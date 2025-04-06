<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInterview extends Model
{
    protected $fillable =
    [
        'user_id',
        'interview_id',
        'interview_level'
    ];

    public function user()
    {
        return $this->belongsTo(User::class , 'user_id');
    }

    public function interview()
    {
        return $this->belongsTo(interview::class , 'interview_id');
    }
}
