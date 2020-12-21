<template>
    <app-layout>
        <template #header>
            {{course.title}}
        </template>


        <div class="  w-3/4 m-auto" >
            <div class="text-4xl text-blue-400"><i class="fa fa-book"></i> My Courses</div>
            <div class="text-2xl"> {{ course.videos[this.currentKey].title}}</div>
            <iframe class="w-full h-screen" :src="course.videos[this.currentKey].video_url" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>
            <div class="text-sm text-gray-500"> {{ course.videos[0].description}}</div>
            <div class="py-6">
                <progress-bar :watchedEp="watched" :videos="course.videos"></progress-bar>
            </div>
            <div class="mt-6">
                <ul v-for="(video, index) in this.course.videos" v-bind:key="video.id">
                    <li class="mt-3 flex justify-between items-center ">
                    <div class="">
                        Video n°{{ index + 1 }} - {{ video.title}} - <span :class="video.duration>3600?'text-red-500':'text-green-500'">{{convert(video.duration)}}</span> -
                        <button class="text-blue-700 focus:text-indigo-500 focus:outline-none"
                                @click="switchVideo(index)"> Voir la video</button>
                    </div>
                        <progress-button :video-id="video.id" :watched-video="watched"></progress-button>
                    </li>
                </ul>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from "../../Layouts/AppLayout";
    import progressButton from "./progressButton";
    import progressBar from "./progressBar";


    export default {
        name: "index.vue",
        components: {
            AppLayout,
            progressButton,
            progressBar
        }

        ,
            props:['course', 'watched'],
        mounted() {
              //  console.log(this.courses);
        },
        data() {
            return  {
                courseShow: this.course,
                currentKey: 0 }
        },
        methods: {
            switchVideo(index) {
             this.currentKey = index;
             window.scrollTo({
                 top:0,
                 left: 0,
                 behavior: 'smooth'
             })
            },
            convert(timeStamps) {
                let hours = Math.floor(timeStamps / 3600) ;
                let minutes = Math.floor((timeStamps / 60 ) - (hours * 60));
                let seconds = timeStamps % 60 ;

                return hours.toString().padStart(2, 0) + 'h:' + minutes.toString().padStart(2, 0)  + 'm:' + seconds.toString().padStart(2, 0)  +'s' ;
            }
        },

    }

</script>

<style scoped>

</style>
