<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-green-200 text-green-500 p-3 m-2"  v-if="$page.flash.success">
                    {{$page.flash.success}}
                </div>
                <div class="w-full">

                        <form @submit.prevent="submit"
                              class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" >
                                <div class="mb-4">
                                    <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Titre de formation</label>
                                    <input
                                        v-model="form.title"
                                        id="title"
                                           type="text"
                                           class="bg-gray-50  leading-tight appearance-none rounded shadow  block w-full px-3 py-2 border placeholder-gray-500 text-gray-700 md focus:outline-none  focus:border-indigo-500 focus:shadow-outline text-gray-700"
                                           placeholder="Entrer le titre de formation">

                                    <div class="bg-red-200 text-red-800 p-4 my-2"
                                         v-if="$page.errors.title">
                                        {{ $page.errors.title}}
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                                    <textarea
                                        v-model="form.description"
                                        id="description"
                                        name="description"
                                        class="bg-gray-50  appearance-none rounded block shadow w-full px-3 py-2 border text-gray-700 focus:outline-none focus:shadow-outline leading-tight focus:border-indigo-500"
                                        placeholder="Description de formation"> </textarea>
                                    <div class="bg-red-200 text-red-800 p-4 my-2"
                                         v-if="$page.errors.description">
                                        {{ $page.errors.description}}
                                    </div>
                                </div>

                                <div class="mb-4 card rounded border p-5 bg-indigo-50 ">
                                    <h2 class="text-2xl">Videos de la formation</h2>

                                    <div class="" v-for="(video, index) in form.videos" v-bind="index">

                                        <label :for="'title-'+index" class="m-2 block text-gray-700 text-sm font-bold mb-2">
                                            Titre de video n°{{index +1}}
                                        </label>
                                        <input
                                            v-model="form.videos[index].title"
                                            :id="'title-'+index"
                                            type="text"
                                            class="bg-gray-50  leading-tight appearance-none rounded shadow  block w-full px-3 py-2 border placeholder-gray-500 text-gray-700 md focus:outline-none  focus:border-indigo-500 focus:shadow-outline text-gray-700"
                                            placeholder="Entrer le titre de formation">

                                        <div class="bg-orange-200 text-red-800 p-4 my-2"
                                             v-if="$page.errors['videos.' + index + '.title']">
                                            {{ $page.errors['videos.' + index + '.title']}}

                                        </div>

                                        <label :for="'description-'+index" class="m-2 block text-gray-700 text-sm font-bold mb-2">
                                            Description de video n°{{index +1}}
                                        </label>
                                        <input
                                            v-model="form.videos[index].description"
                                            :id="'description-'+index"
                                            type="text"
                                            class="bg-gray-50  leading-tight appearance-none rounded shadow  block w-full px-3 py-2 border placeholder-gray-500 text-gray-700 md focus:outline-none  focus:border-indigo-500 focus:shadow-outline text-gray-700"
                                            placeholder="Entrer la description de video">

                                        <div class="bg-yellow-200 text-red-800 p-4 my-2"
                                             v-if="$page.errors['videos.' + index + '.description']">
                                            {{ $page.errors['videos.' + index + '.description']}}
                                        </div>

                                        <label :for="'video_url-'+index" class="m-2 block text-gray-700 text-sm font-bold mb-2">
                                           Embed URl de video n°{{index +1}}
                                        </label>
                                        <input
                                            v-model="form.videos[index].video_url"
                                            :id="'video_url-'+index"
                                            type="text"
                                            class=" bg-gray-50 leading-tight appearance-none rounded shadow  block w-full px-3 py-2 border placeholder-gray-500 text-gray-700 md focus:outline-none  focus:border-indigo-500 focus:shadow-outline text-gray-700"
                                            placeholder="Entrer Youtube Embed URL exp : https://www.youtube.com/embed/Kudd571c ">

                                        <div class="bg-pink-200 text-red-800 p-4 my-2"
                                             v-if="$page.errors['videos.' + index + '.video_url']">
                                            {{ $page.errors['videos.' + index + '.video_url']}}
                                        </div>

                                        <hr class="m-5">
                                    </div>


                                </div>
                            <hr>
                            <div class="">
                                <button
                                    v-if="form.videos.length < 15"
                                    class="bg-green-300 rounded py-2 px-4 my-2 text-white block"
                                    @click.prevent="add"
                                 > <i class="fa fa-plus"></i>  </button>
                                <button
                                    v-if="form.videos.length > 1"
                                    class="bg-orange-300 rounded py-2 px-4 my-2 text-white inline-block"
                                    @click.prevent="remove"
                                 > <i class="fa fa-trash"></i> </button>
                                <button type="submit"
                                        class="block bg-blue-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded w-100  focus:outline-none focus:shadow-outline">
                                <i class="fa fa-pencil">   </i>
                                    Enregistrer ma formation
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

    </app-layout>
</template>

<script>
    import AppLayout from "../Layouts/AppLayout";


    export default {
        components: {
            AppLayout,

        },
        data() {
          return {
              form: {
                  title: null,
                  description: null,
                  videos: [
                      {title: null, description: null, video_url: null}
                  ],
              }
          }
        },
        methods: {

          submit(){
              console.log(this.form);
                this.$inertia.post('/courses', this.form);
          }  ,
            add() {
                this.form.videos.push({title: null, description: null, video_url: null}) ;
            },
            remove() {
              this.form.videos.pop() ;
            },
        },
    }
</script>
