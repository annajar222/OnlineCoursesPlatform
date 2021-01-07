<?php

namespace App\Models;


use App\Models\Episode;
use App\Models\Comment;
use App\Models\User;
use App\Models\Vote;
use App\Models\Category;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    use Authorizable;

    protected $fillable = ['title','description','category_id'];

    protected $appends = ['update','delete'];

    protected static function booted(){
        static::creating(function ($course){
            $course->user_id = auth()->id();
        });
    }

    public function getUpdateAttribute(){
        return $this->can('update-course',$this);
    }

    public function getDeleteAttribute(){
        return $this->can('delete-course',$this);
    }

    public function episodes(){
        return $this->hasMany(Episode::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}
