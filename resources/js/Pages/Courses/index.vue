<template>
    <app-layout>
        <template #header>
            Liste de formations
        </template>
        <section class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class=" py-3 flex items-center justify-between bg-green-200 text-green-500 p-3 m-2" :test="true"  v-if="$page.flash.success&&!test">
           <p> {{$page.flash.success}} </p>
            <a :href="'/course'" @click.prevent="close(test)">x</a>
        </div>
        <div class="py-5 m-auto w-3/4 " v-for="course in courses.data" v-bind:key="course.id">
        <div class="bg-white rounded shadow p-5">
            <div class="text-sm text-gray-500 flex justify-between items-center">


                <div> Mise en ligne par <strong> {{course.user.name}} </strong> -
                 <span :class="course.participants>0?'text-green-700':'text-red-700'"> {{course.participants}} participant<span v-if="parseInt(course.participants) > 1 ">s </span> </span>

                </div>

                <span class="block text-sm text-gray-400"> {{course.videos_count}} vidéo<span v-if="course.videos_count > 1">s</span></span>
            </div>
                    <h1 class="text-4xl"> {{ course.title}}</h1>
                    <div class="bg-gray-200 rounded-full px-3 py-1 inline-block  font-semibold text-blue-500"> {{ convert(course.total_duration)}}</div>


                <div class="text-sm text-gray-500"> {{course.description}}</div>

                 <div class="flex items-center justify-between">
                     <a :href="'course/' + course.id" class="bg-indigo-500 text-white px-2 py-1 text-sm
                rounded hover:bg-indigo-700 inline-block mt-3">
                         voir la formation
                     </a>
                     <a :href="'course/edit/' + course.id" class="bg-red-400 text-white px-2 py-1 text-sm
                    rounded hover:bg-red-700 inline-block mt-3"
                        v-if="course.user_id===userId"
                     >

                         Modifier ma formation
                     </a>
                 </div>
            </div>

        </div>
                <div class="w-50  ml-12 items-center">
                    <inertia-link
                        class="text-indigo-500 font-bold py-1 px-3 rounded text-xs bg-green hover:bg-green-dark "
                        :href="link.url"
                        v-for="link in courses.links"
                        v-bind:key="link.label">
                        <span v-if="link.label === '&laquo; Previous' " class="text-blue-700 pl-12 ml-15" :class="{'disable':link.label === 1}">Previous</span>
                        <span v-if="link.label !== '&laquo; Previous'&& link.label !=='Next &raquo;' " :class="{'text-red-500' : link.active}" > {{link.label}} </span>
                        <span v-if="link.label === 'Next &raquo;' " class="text-blue-700">Next</span>
                    </inertia-link>
                </div>

            </div>
        </section>
    </app-layout>
</template>

<script>
    import AppLayout from "../../Layouts/AppLayout";

    export default {
        name: "index.vue",
        components: {
            AppLayout
        }

        ,
            props:['courses', 'userId'],
        mounted() {

                console.log(this.userId);
        },
        data() {
            return  {courseList: this.courses, test:'this.test'}
        },
        methods: {
            close (test) {
                console.log(this.test)
              //  test = !test;
            },
            convert(timeStamps) {
                let hours = Math.floor(timeStamps / 3600) ;
                let minutes = Math.floor((timeStamps / 60 ) - (hours * 60));
                let seconds = timeStamps % 60 ;

                return hours.toString().padStart(2, 0) + 'h:' + minutes.toString().padStart(2, 0)  + 'm:' + seconds.toString().padStart(2, 0)  +'s' ;
            }
        }

    }

</script>

<style scoped>

</style>
