<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Added to define Eloquent relationships.
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Tag extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'tag';
    protected $primaryKey = 'tag_id';
    protected $fillable = ['tag_id','name', 'description'];

    public function questions(){
        return $this->belongsToMany(Question::class, 'question_tags', 'tag_id', 'question_id');
    }
}
