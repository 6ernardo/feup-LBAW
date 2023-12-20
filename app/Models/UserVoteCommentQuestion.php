<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVoteCommentQuestion extends Model
{
    use HasFactory;
    protected $table = 'user_vote_comment_question'
    protected $fillable = ['user_id','comment_id','vote'];

    public $timestamps = false;
    public $incrementing = false;


    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function comment() {
        return $this->belongsTo(CommentQuestion::class, 'comment_id');
    }


    protected function setKeysForSaveQuery($query){
        $query
            ->where('user_id', '=', $this->getAttribute('user_id'))
            ->where('question_id', '=', $this->getAttribute('question_id'));
        return $query;
    }
}
