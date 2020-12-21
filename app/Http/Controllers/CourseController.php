<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Video;
use App\Youtube\YoutubeServices;
use http\Client\Curl\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CourseController extends Controller
{
    public function index() {
        $userId = auth()->id() ;



        $courses = Course::with('user')->
        select('courses.*', DB::raw(
            '(SELECT count(DISTINCT(user_id))
             FROM completions
             INNER JOIN videos
              ON completions.video_id = videos.id
             WHERE videos.course_id = courses.id
             ) AS participants'

            /*  Ajouter column total_duration et recupérer la sum de duration videos   */
        ))->addSelect(DB::raw(
            '(SELECT SUM(duration)
            FROM videos
            WHERE videos.course_id = courses.id
            ) AS total_duration'
        ))
            ->withCount('videos')->latest()->paginate(5);
        //$courses = Course::paginate(15);
        //dd($courses);
        return inertia::render('Courses/index', [
            'courses' => $courses, 'userId' => $userId
        ]);
    }

    public function show(int $id) {



        $course = Course::where('id' , $id)->with('videos')->first();

        $watched = auth()->user()->videos;
        return inertia::render('Courses/show', [
            'course' => $course, 'watched' => $watched
        ]);
    }

    public function courseProgress( Request $request) {
        $id = $request->input('videoId') ;
        $user = auth()->user();

        $user->videos()->toggle($id);

        return $user->videos ;

    }

    public function store(Request $request, YoutubeServices $ytb) {
       // dd($ytb);

        //validation de formulaire
        $request->validate([
           'title' => 'required',
           'description' => 'required',
           'videos' => ['required','array'],
           'videos.*.title' => 'required',
           'videos.*.description' => 'required',
           'videos.*.video_url' => 'required',

        ]);

       $course = Course::create($request->all());

       //update les video dans la BD
       foreach ($request->input('videos') as $video ) {
           $video['course_id'] = $course->id ;
           // recuperer yrl depuis formulaire et passer au YT service pour recuperer la durée
           $video['duration'] = $ytb->handleYoutubeVideosDuration($video['video_url']) ;

           Video::create($video) ;
       } ;
        return Redirect::route('dashboard')->with('success', 'Félicitaion, la formation a bien été
        mise en ligne.') ;
    }

    public function edit(int $id) {
        $course = Course::where('id', $id)->with('videos')->first() ;

        $this->authorize('update', $course);
        return Inertia::render('Courses/edit', [
            'course' => $course
        ]) ;
    }

    public function update(Request $request, YoutubeServices $ytb)
    {
        $course = Course::where('id', $request->id)->with('videos')->first() ;

       // authorise l'utilisateur connecte de modifier leur formation avec policy 'update' créér
        $this->authorize('update', $course);

        //mise a jour de formation
        $course->update($request->all());
        // supprimer les videos pour repartir a zéro
        $course->videos()->delete();

        //boucler sur les videos envoyer dans la requete
        foreach ($request->videos as $video) {
            $video['course_id'] = $course->id ;
            $video['duration'] = $ytb->handleYoutubeVideosDuration($video['video_url']);
            Video::create($video) ;
        };

        return Redirect::route('courses.index')->with('success', 'Félicitaion votre formaton a bien été modifiée');
    }
}
