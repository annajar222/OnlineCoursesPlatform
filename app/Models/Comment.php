<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Course;
use App\Models\Episode;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['comment','course_id','episode_id'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function episode()
    {
        return $this->belongsTo(Episode::class);
    }
}
