<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

// Added to define Eloquent relationships.
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Question extends Model{
    use HasFactory;

    protected $table = 'question';
    protected $primaryKey = 'question_id';
    protected $fillable = ['title', 'description', 'author_id'];

    public $incrementing = true;
    public $timestamps = false;

    public function author() : BelongsTo {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function answers() : HasMany {
        return $this->hasMany(Answer::class, 'question_id');
    }

    public function tags(){
        return $this->belongsToMany(Tag::class, 'question_tags', 'question_id', 'tag_id');
    }

    public function comments() : HasMany {
        return $this->hasMany(CommentQuestion::class, 'question_id');
    }

    public function correct_answer() : BelongsTo 
    {
        return $this->belongsTo(Answer::class, 'correct_answer_id');
    }

    public function followed_by() {
        return $this->belongsToMany(User::class, 'follow_question', 'question_id', 'user_id');
    }
}
