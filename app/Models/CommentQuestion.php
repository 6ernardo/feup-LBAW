<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Added to define Eloquent relationships.
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommentQuestion extends Model
{
    use HasFactory;

    public $timestamps  = false;
    protected $table = 'comment_question';

    protected $fillable = [
        'author_id',
        'question_id',
        'content'
    ];

    protected $primaryKey = 'comment_id';

    public function question() : BelongsTo {
        return $this->belongsTo(Question::class, 'question_id');
    }

    public function author() : BelongsTo {
        return $this->belongsTo(User::class, 'author_id');
    }
}
