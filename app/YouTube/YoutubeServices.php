<?php

namespace App\Youtube;


use DateInterval;
use Illuminate\Support\Facades\Http;

class YoutubeServices
{

    private $key = null;

    public function __construct(string $key)
    {
        $this->key = $key ;
    }

    public function handleYoutubeVideosDuration(string $video_url)
    {

        //dd($this->key);
        // recupérer l'id depuiq video_url
        preg_match('/embed\/(.+)/', $video_url, $matches);
        $id = $matches[1] ;
        //dd($id) ;

        // appel de l'api de youtube pour recupérer la durée
        $response = Http::get("https://www.googleapis.com/youtube/v3/videos?key={$this->key}&id={$id}&part=contentDetails");
        $duration =  (json_decode($response))->items[0]->contentDetails->duration ;
        //dd($duration) ;

        //convertir en seconde
        $interval = new DateInterval($duration) ;
       // dd($interval) ;
        return $interval->s + $interval->i *60 + $interval->h * 3600;
    }

}
