<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Course;

class Video extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'video_url', 'course_id', 'duration'];
    public function course() {
        return $this->belongsTo(Course::class) ;
    }

    public function user() {
        return $this->belongsTo(User::class) ;
    }
}
