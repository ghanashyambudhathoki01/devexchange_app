<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use League\CommonMark\CommonMarkConverter;

class Question extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'body',
        'views_count',
        'is_answered',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($question) {
            $question->slug = Str::slug($question->title) . '-' . Str::random(5);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function votes()
    {
        return $this->morphMany(Vote::class, 'voteable');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('title', 'like', '%' . $search . '%')
            ->orWhere('body', 'like', '%' . $search . '%');
    }

    public function scopeFilter($query, $filter)
    {
        switch ($filter) {
            case 'most-upvoted':
                return $query->withCount(['votes as upvotes_count' => function ($q) {
                    $q->where('type', 1);
                }])->orderByDesc('upvotes_count');
            case 'most-answered':
                return $query->withCount('answers')->orderByDesc('answers_count');
            case 'unanswered':
                return $query->has('answers', '=', 0);
            case 'latest':
            default:
                return $query->latest();
        }
    }

    public function getBodyHtmlAttribute()
    {
        $converter = new CommonMarkConverter();
        return $converter->convert($this->body);
    }
}
