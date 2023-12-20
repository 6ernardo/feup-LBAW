<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVoteAnswer extends Model
{
    use HasFactory;
    protected $table = 'user_vote_answer';
    protected $fillable = ['user_id', 'answer_id', 'vote'];

    public $incrementing = false;
    public $timestamps = false;
    protected $primaryKey = ['user_id', 'answer_id'];


    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function answer(){
        return $this->belongsTo(Answer::class,'answer_id');
    }

    protected function setKeysForSaveQuery($query){
        $query
            ->where('user_id', '=', $this->getAttribute('user_id'))
            ->where('answer_id', '=', $this->getAttribute('answer_id'));
        return $query;
    }
}
