<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// Added to define Eloquent relationships.
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $timestamps  = false;
    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_picture',
        'score',
        'is_moderator',
        'is_blocked'
    ];

    protected $primaryKey = 'user_id';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function questions() {
        return $this->hasMany(Question::class, 'author_id');
    }

    public function answers() {
        return $this->hasMany(Answer::class, 'author_id');
    }

    public function isAdmin() {
        return count($this->hasOne(Admin::class, 'admin_id')->get());
    }

    public function followed_questions() {
        return $this->belongsToMany(Question::class, 'follow_question', 'user_id', 'question_id');
    }

    public function followed_tags() {
        return $this->belongsToMany(Tag::class, 'follow_tag', 'user_id', 'tag_id');
    }

    public function follows_question(int $id) {
        return $this->followed_questions()->wherePivot('question_id', $id)->exists();
    }

    public function follows_tag(int $id) {
        return $this->followed_tags()->wherePivot('tag_id', $id)->exists();
    }
    
}
