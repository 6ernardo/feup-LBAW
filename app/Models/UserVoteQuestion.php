<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVoteQuestion extends Model
{
    use HasFactory;
    protected $table = 'user_vote_question';
    protected $fillable = ['user_id','question_id','vote'];

    public $incrementing = false;
    public $timestamps = false;
    protected $primaryKey = ['user_id', 'question_id'];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function question(){
        return $this->belongsTo(Question::class,'question_id');
    }

    protected function setKeysForSaveQuery($query){
        $query
            ->where('user_id', '=', $this->getAttribute('user_id'))
            ->where('question_id', '=', $this->getAttribute('question_id'));
        return $query;
    }
}
