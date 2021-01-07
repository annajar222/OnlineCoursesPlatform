<!-- SHOW COMPONENT -->
<template>
  <app-layout>
    <template #header>
        <!-- Header 
        - title
        - category
        - vote
        -->
        <h2 class="font-bold">{{course.title}}</h2>
        <span class="text-sm" v-if="course.category !== null">{{course.category.title}}</span>
        <span class="text-sm" v-else>Has no category</span>
        <vote :course-id="courseShow.id"></vote>
    </template>
    <!-- Flash message -->
    <div v-if="$page.flash.message" class="bg-blue-300 border-l-4 border-indigo-800 text-gray-800 p-4" role="alert">
        <p class="font-bold">Be Warned</p>
        <p>{{ $page.flash.message }}</p>
    </div>
    <!-- Show Course with episodes -->
    <div class="py-6">
        <div class="mb-0 font-bold bg-teal-lightest border-t-4 border-indigo-600 rounded-b text-teal-darkest px-8 py-8 shadow-md my-2">{{this.courseShow.episodes[this.corruntKey].title}}</div>
        <!-- EPISODE VEDIO -->
        <iframe class="w-full h-screen"
                :src="'http://www.youtube.com/embed/'+this.courseShow.episodes[this.corruntKey].video_url"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen>
        </iframe>
        <!-- EPISODE DESCRIPTION -->
        <div class="w-full flex flex-col mt-8 px-4">
            <p class="text-gray-800 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1" style="transition: all .15s ease">{{courseShow.episodes[this.corruntKey].description}}</p>  
        </div>
        <!-- PROGRESS BAR -->
        <div class="py-6">
            <!--THIS IS THE PROGRESS BAR COMPONENT IN THE HELPERS FOLDER-->
            <ProgressBar :episodes = "course.episodes" :watched-episodes = "watched" />
        </div>
        <!--COURSE EPISODES-->
        <div class="my-10">
            <ul v-for="(episode , index ) in this.courseShow.episodes" :key="episode.id">
                <li class="mt-3 flex justify-between items-center px-5 py-3 hover:shadow-md">
                    <div>
                        <p @click="switchEpisode(index)" class="font-bold cursor-pointer text-left">
                            {{episode.title}}
                        </p>
                    </div>
                    <progress-button :episode-id="episode.id" :watched-episodes = "watched" />
                </li>
            </ul>
        </div>
        <!--COURSE COMMENTS-->
        <div class="my-10 px-8 mb-6 md:mb-0">
            <h2 class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2 border-t-2 border-indigo-100 py-8">{{courseShow.comments.length}} Comment<span v-if="courseShow.comments.length>1">s</span></h2>
            <div>
                <ul v-for="comment in comments" :key="comment.id">
                    <li v-if="comment.episode_id === courseShow.episodes[corruntKey].id" class="mt-3 flex justify-between items-center px-3 py-3">
                        <div>
                            <div class="border-l-4 border-indigo-600 px-3" >
                                <h3 class="font-bold cursor-pointer py-2 text-gray-800">{{comment.comment}}</h3>
                                <span class="text-blue-800">{{comment.user_name}}</span>
                            </div> 
                        </div>
                        <span v-if="$page.user.id === comment.user_id || $page.user.is_admin || courseShow.user_id === $page.user.id">
                            <delete-button :comment-id="comment.id"></delete-button>
                        </span>   
                    </li>
                </ul>
            </div>
            <!--COMMENT COMPONENT-->
            <!--you will find this component in the hlpers folder-->
            <comment :course-id="courseShow.id" :episode-id="courseShow.episodes[corruntKey].id"></comment>
        </div>
    </div>  
  </app-layout>
</template>

<script>
import AppLayout from './../../Layouts/AppLayout';
import ProgressButton from './Helpers/ProgressButton';
import ProgressBar from './Helpers/ProgressBar';
import Comment from './Helpers/Comment.vue';
import DeleteButton from './Helpers/DeleteButton.vue';
import Vote from './Helpers/Vote.vue';

export default {
    components: {
        AppLayout,
        ProgressButton,
        ProgressBar,
        Comment,
        DeleteButton,
        Vote
    },

    props: ['course','watched','comments'],

    data(){
        return{
            courseShow : this.course,
            corruntKey :0,
        }
    },
    
    methods:{
        //SO if the user clicked the episode title in the buttom this function will switch to the clicked episode.
        switchEpisode(index){
            this.corruntKey = index;

            window.scrollTo({
                top : 0,
                left : 0,
                behavior : 'smooth'
            });
        },
    },

    mounted(){
        // After submiting a new comment or deleting a comment, we bring the data(comments) using this eventBus,So we can show the course comments.
        eventBus.$on('comments', data => this.comments = data);
    }
}
</script>

<style>

</style>