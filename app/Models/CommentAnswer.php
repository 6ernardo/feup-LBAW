<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentAnswer extends Model
{
    use HasFactory;

    public $timestamps  = false;
    protected $table = 'comment_answer';

    protected $fillable = [
        'author_id',
        'answer_id',
        'content'
    ];

    protected $primaryKey = 'comment_id';

    public function answer() : BelongsTo {
        return $this->belongsTo(Answer::class, 'answer_id');
    }

    public function author() : BelongsTo {
        return $this->belongsTo(User::class, 'author_id');
    }
}
