<template>

    <div class="bg-gray-200 w-full rounded">
        <div  class="pl-1 rounded  text-center transition-width duration-500" :class="pourcentage<50?'text-red-500 bg-green-200':'text-white bg-green-'+(Math.floor(pourcentage/15)*100)"
             :style="'width:'+ pourcentage +'%'"> {{pourcentage}}% </div>

    </div>
</template>

<script>
    export default {
        name: "progressBar.vue",
        props: ['watchedEp', 'videos' ],
        data() {
            return {
                watchedEpData: this.watchedEp,

            }
        },
        computed: {
            pourcentage() {
                let filteredEp = this.videos.filter( courseEp =>{
                    return this.watchedEpData.find(watchedEp =>{
                       return watchedEp.id === courseEp.id;

                    });
                });

                return Math.ceil(filteredEp.length / this.videos.length * 100);
            }
        },
        mounted() {
          //  console.log('watchedEp',this.watchedEp,'videos',this.videos);
            eventBus.$on('toggleProgress', data =>{
                    this.watchedEpData = data;
                console.log('data', data)
            }) ;
        }



    }
</script>

<style scoped>

</style>
