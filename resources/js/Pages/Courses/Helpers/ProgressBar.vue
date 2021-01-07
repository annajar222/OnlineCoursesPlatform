<!-- PROGRESS BAR HELPER -->
<template>
    <div>
        <!-- THE PROGRESS BAR -->
        <div class="bg-gray-200 w-full rounded">
            <div class="bg-indigo-600 text-white rounded-l text-center
            transition-width duration-500"
            :style=" 'width:' + percentage + '%' ">
                {{ percentage }}%
            </div>
        </div>
    </div>
</template>


<script>
    export default {
        
        props:['watchedEpisodes','episodes'],

        data(){
            return {
                watchedEpisodesData : this.watchedEpisodes,
            }
        },

        computed:{
            //Now we will compute the progress bar percentage (10%,20%...)
            percentage(){
                    //See if the user has watched any of the course episodes.
                    let filteredEp = this.episodes.filter( courseEp =>{

                    return this.watchedEpisodesData.find(watchedEp =>{

                                return watchedEp.id === courseEp.id;
                        
                        }
                    );
                }  
                );
                //And then compute the result SO we can use it to show the progressBar PROGRESS or PERCENTAGE.
                return Math.ceil(filteredEp.length / this.episodes.length * 100);
            }
           
        },
        mounted(){
            //Now we have the watched episodes(episodes that the user watched).
            //SO we will use it in with by the watchedEpisodesData array.
            eventBus.$on('toggleProgress', data => this.watchedEpisodesData = data);
        }
    }
</script>