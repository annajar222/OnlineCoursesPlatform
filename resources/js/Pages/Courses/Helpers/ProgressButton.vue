<!-- ProgressButton helper -->
<template>
    <!-- THE DONE/CANCEL BUTTON -->
    <div>
        <button @click = "toggleProgress()" 
        :class="{ 'bg-indigo-600 rounded py-3 px-3 text-white': this.isWatched , 'py-3 px-3 rounded text-white bg-indigo-700' : !this.isWatched}">
            {{ this.isWatched ? 'Cancel' : 'Done'}}
        </button>
    </div>
</template>

<script>
    export default{
    
    props: ['episodeId','watchedEpisodes'],

    data(){
        return{
            watchedEp : this.watchedEpisodes,
            isWatched : null,
        }
    },
    methods:{
        toggleProgress(){
            //Using axios we submit the episodeId to the toggleProgress function, and return the user episodes(episodes that he watched).
            axios.post('/toggleProgress', {
                episodeId :this.episodeId,
            })
            //then we emit the user episodes(watched episodes) with eventBus(toggleProgress) so we can use it in the ProgressBar component.
            .then(response =>{
                if(response.status === 200)
                {
                    this.isWatched = !this.isWatched;
                    eventBus.$emit('toggleProgress',response.data);
                } 
            })
            .catch(error => console.log(error));
        },
        isWatchedEpisode(){
            //We check if the user has watched the episode or not if so return true else false.
            //then we will use the response in the watchedEp varible.
            return this.watchedEp.find(episode => episode.id === this.episodeId) ? true : false;
        }
    },

    mounted(){
        //run the isWatchedEpisode function and return the response in the isWatched varible.
        this.isWatched = this.isWatchedEpisode();
    }
    
    }
</script>