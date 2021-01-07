<!-- Delete helper -->
<template>
<!--delete button-->
  <div>
      <button @click="deleteComment()" class="text-red-500 hover:text-red-600 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1" type="button" style="transition: all .15s ease">delete</button>
  </div>
</template>

<script>
export default {
    props:['commentId'],
    data(){
        return{
            comment_id:this.commentId
        }
    },
    methods:{
        deleteComment(){
            //we use axios to delete the comment then we emit the response with the evenBus in the ShowComponent.
            axios.delete('/delete/comment/'+this.comment_id)
            .then(response =>{
                if(response.status === 200)
                {
                    eventBus.$emit('comments',response.data);
                } 
            })
            .catch(error => console.log(error));
        }
    }
}
</script>

<style>

</style>