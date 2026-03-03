<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use League\CommonMark\CommonMarkConverter;

class Answer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'question_id',
        'body',
        'is_best',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function votes()
    {
        return $this->morphMany(Vote::class, 'voteable');
    }

    public function getBodyHtmlAttribute()
    {
        $converter = new CommonMarkConverter();
        return $converter->convert($this->body);
    }
}
