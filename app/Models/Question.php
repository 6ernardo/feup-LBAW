<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model{
    use HasFactory;

    protected $table = 'question';
    protected $primaryKey = 'question_id';
    protected $fillable = ['title', 'description', 'author_id'];

    public $incrementing = true;
    public $timestamps = false;
}
