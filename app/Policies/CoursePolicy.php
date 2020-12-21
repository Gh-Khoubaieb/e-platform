<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Course $course){
        //la mise a jour (modificatoin) de formation ne fait que par l'utilisateur qui crééé cette formation
        return $user->id === $course->user_id;
    }
}
