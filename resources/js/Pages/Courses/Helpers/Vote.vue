<!-- VOTE HELPER -->
<template>
    <div class="float-right">
        <!-- IF USER HAS VOTED FOR THIS COURSE THEN SHOW THIS. -->
        <span v-if="voted" class="text-purple-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1" type="button" style="transition: all .15s ease">
            You Like this course
        </span>
        <!-- ELSE , TELL HIM TO VOTE IF WANTED. -->
        <span v-else class="text-sm" >Is this Course usefull ?
            <span>
                <!-- IF USER VOTED SHOW A GREEN "YES" BUTTON -->
                 <button v-if="flag" @click="clicked" class="text-green-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1" type="button" style="transition: all .15s ease">
                    Yes
                </button>
                <!-- IF USER DID NOT VOTE YET SHOW A PURPLE "YES" BUTTON -->
                <button v-else @click="clicked" class="text-purple-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1" type="button" style="transition: all .15s ease">
                    Yes
                </button>
            </span>
        </span>
    </div>
</template>

<script>
export default {
    props:['courseId'],
    data(){
        return{
            voted:false,
            flag:false
        }
    },
    methods:{
        clicked(){
            //IF USER VOTED, SUBMIT THE VOTE TO THE VOTE COURSE CONTROLLER.
            axios.post('/vote/course/',{
                course_id : this.courseId
            })
            //THEN IF THE VOTE STORED SETT THE FLAG TO TRUE.
            .then(response => {
                if(response.status === 200)
                {
                    this.flag = true;
                } 
            });
        }
    },
    created(){
        //BEFOR ANYTHING HAPPEND, GET ALL THE CONNECTED USER VOTES.
        axios.get('/get/user/votes')
            .then(response => {
                if(response.status === 200)
                {
                    //AND THEN CHECK IF THE USER HAS VOTED FOR THIS COURSE, IF SO SETT THE VOTED VARIBLE TO TRUE.
                    for(let i = 0 ; i < response.data.length ; i++)
                    {
                        if(response.data[i].course_id === this.courseId){
                            this.voted = true;
                        }
                    }
                } 
            });
    },
}
</script>