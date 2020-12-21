<template>
    <div >
        <button class=" px-2 py-2 rounded text-white" :class="isWatched ? 'bg-green-300 hover:bg-green-500' : 'bg-indigo-300 hover:bg-indigo-500'  " :style="'width:100px;'"  @click="toggleProgress()"> {{ this.isWatched ? 'Terminé' : '' }} <i v-if="!isWatched" class="fa fa-eye"></i> <i v-if="isWatched" class="fa fa-check"></i></button>

    </div>
</template>

<script>

    export default {
        name: "progressButton.vue",
        props :['videoId', 'watchedVideo'],
        data() {
           return {
               watchedEp: this.watchedVideo,
               isWatched: null ,
           }
        } ,
        methods: {
            toggleProgress() {
                axios.post('/courseProgress', {
                    videoId: this.videoId,
                })
                    .then( response => {
                        if (response.status === 200) {
                            this.isWatched = !this.isWatched;
                            eventBus.$emit('toggleProgress', response.data);
                        }
                        }
                    )
                    .catch( error => console.log(error))
            },

            isWatchedVideo() {
                return this.watchedEp.find(video => video.id === this.videoId) ? true : false;
          }
        },
        mounted() {
            console.log(this.watchedEp)
            this.isWatched = this.isWatchedVideo() ;
        }

    }
</script>

<style scoped>

</style>
