<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'user_id',
        'answer',
    ];

    public function question()
    {
        return $this->belongsTo(ForumQuestion::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
