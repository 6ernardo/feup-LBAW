<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Added to define Eloquent relationships.
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Answer extends Model
{
    use HasFactory;

    public $timestamps  = false;
    protected $table = 'answer';

    protected $fillable = [
        'author_id',
        'question_id',
        'description'
    ];

    protected $primaryKey = 'answer_id';

    public function question() : BelongsTo {
        return $this->belongsTo(Question::class, 'question_id');
    }

    public function author() : BelongsTo {
        return $this->belongsTo(User::class, 'author_id');
    }
}
