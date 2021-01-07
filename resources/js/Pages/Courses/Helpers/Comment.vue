<!-- Comment helper -->
<template>
        <div class="my-10">
            <!--THE COMMPENT INPUT-->
            <form  @submit.prevent="submit()">
                <div class="">
                    <div class="px-3 mb-6 md:mb-0">
                        <input v-model="comment" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" id="grid-comment" name="comment" type="text" placeholder="Comment..">
                        <p class="text-red text-xs italic">Comment For This Episode</p>
                    </div>
                </div>
                <div class="">
                    <div class="px-3 py-3 mb-6 md:mb-0">
                        <input class="cursor-pointer bg-indigo-700 p-2 rounded text-white hover:bg-indigo-800" type="submit" value="Submit" >
                    </div>
                </div>
            </form>
        </div>
</template>

<script>
export default {
    props:['courseId','episodeId'],
    data(){
        return{
            comment:'',
        }
    },
    
    methods:{
        submit(){
            //we use axios to submit the comment and then we emit the response with the eventBus in the ShowComponent.
            axios.post('/store/comment', {
                comment:this.comment,
                episodeId :this.episodeId,
                courseId :this.courseId,
            })
            .then(response =>{
                this.comment = '';
                if(response.status === 200)
                {
                    eventBus.$emit('comments',response.data);
                } 
            })
            .catch(error => console.log(error));
        },
    },
}
</script>

<style>

</style>