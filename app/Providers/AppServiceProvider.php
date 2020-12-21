<?php

namespace App\Providers;

use App\Youtube\YoutubeServices;
use http\Message;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // message de success de creation de formation
        Inertia::share('flash', function(){
            return [
                'success' => Session::get('success')
                ];
        });

        //message d'erreurs validation de creation de formation

        Inertia::share(['errors', function(){
            return
                 Session::get('errors')
                ? Session::get('errors')->getBag('default')->getMessages()
                     : (object) [] ;

        },
        ]);

        // instansié' un service Youtube puisque on fais injection de dependance dasn
        //la methode store de controlleur CourseController or l'istructeur de YoutubeService
        // ne sait pas le key a chaque instance => on montre laravel comment insatancé un service YT
        // dans notre cas $key = YOUTUBE_API_KEY
        $this->app->singleton('App\Youtube\YoutubeServices', function (){
            return new YoutubeServices(env('YOUTUBE_API_KEY'));
        });

        Paginator::useBootstrap();
    }
}
