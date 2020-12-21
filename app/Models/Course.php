<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Video;
use Illuminate\Support\Facades\Gate;


class Course extends Model
{
    use HasFactory;

    protected $fillable =['title', 'description'] ;

    // permission de l'utilisateur de modifier la formation avec policy
    // update = attribut true si l'utilsateur prut modifier la formaton
    protected $appends = ['update'] ;

    protected static function booted()
    {
        static::creating(function ($course) {
            $course->user_id = auth()->id();
        });
    }

    public function videos() {
        return $this->hasMany(Video::class) ;
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function getUpdateAttribute()
    {
        //appel au attribut update-course de Gate
        // $this ===> model en cours
       // dd($this->appends) ;
        return Gate::check('update-course', $this) ;

    }
}
