<!-- CREATE COURSE COMPONENT -->
<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                New Course
            </h2>
        </template>
        <!-- flash message -->
            <div v-if="$page.flash.message" class="bg-blue-300 border-l-4 border-indigo-800 text-gray-800 p-4" role="alert">
                <p class="font-bold">Be Warned</p>
                <p>{{ $page.flash.message }}</p>
            </div>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="w-full">
                        <!-- Form -->
                        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" @submit.prevent="submit">
                            <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="title" >
                                Course Title
                            </label>
                            <input placeholder="Course Title.." v-model="form.title" maxlength="60" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="title" type="text">
                                <div 
                                    v-if="$page.errors.title" class="bg-red-200 rounded text-red-800 p-4">
                                    {{$page.errors.title[0]}}
                                </div>
                            </div>

                            <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                                Description
                            </label>
                            <textarea v-model="form.description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="description" type="text" placeholder="Course Description..">
                            </textarea>
                             <div 
                               v-if="$page.errors.description" class="bg-red-200 rounded text-red-800 p-4">
                                    {{$page.errors.description[0]}}
                                </div>
                            </div>

                            <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="category_id">
                                Category
                            </label>
                            <select v-model="form.category_id" id="category_id" class="w-full md:w-full border-2 border-gray-100 hover:border-blue-100">
                                <option v-for="category in this.categories" :key="category.id" :value="category.id">{{category.title}}</option>
                            </select>
                             <div 
                               v-if="$page.errors.category_id" class="bg-red-200 rounded text-red-800 p-4">
                                    {{$page.errors.category_id[0]}}
                                </div>
                            </div>
                            <!-- Episodes -->
                            <div class="mb-4">
                                <span class="my-8 font-bold">Course episodes</span>
                                <div class="border-solid rounded border-2  border-light-blue-500 p-10">
                                    <div v-for="(episode , index) in form.episodes" :key="index">
                                        
                                        <span class="mb-4 font-bold bg-green-200 rounded-full p-2">Episode : {{index+1}}</span>
                                        
                                        <label class="block text-gray-700 text-sm font-bold my-5" :for="'title -'+index">
                                                Title 
                                        </label>
                                        <input v-model="form.episodes[index].title" maxlength="60" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" :id="'title -'+index" type="text" placeholder="Title..">
                                        <div 
                                            v-if="$page.errors['episodes.'+index+'.title']" class=" rounded bg-red-200 text-red-800 p-4">
                                                    {{$page.errors['episodes.'+index+'.title'][0]}}
                                        </div>

                                        <label class="block text-gray-700 text-sm font-bold my-5" :for="'description -'+index">
                                                Description 
                                        </label>
                                        <textarea v-model="form.episodes[index].description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" :id="'description -'+ index" type="text" placeholder="Discription..">
                                        </textarea>
                                        <div 
                                            v-if="$page.errors['episodes.'+index+'.description']" class=" rounded bg-red-200 text-red-800 p-4">
                                                    {{$page.errors['episodes.'+ index +'.description'][0]}}
                                        </div>
                                        
                                        <label class="block text-gray-700 text-sm font-bold my-5" :for="'video_url -'+index">
                                                Vedio_Url  
                                        </label>
                                        <input v-model="form.episodes[index].video_url" class=" mb-5 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" :id="'video_url -'+index" type="text" placeholder="Vedio_Url..">
                                        <div class="text-pink-800 text-sm">
                                            Paste your vedio_url in here.
                                        </div>
                                        <div 
                                            v-if="$page.errors['episodes.'+index+'.video_url']" class=" rounded bg-red-200 text-red-800 p-4">
                                                    {{$page.errors['episodes.'+index+'.video_url'][0]}}
                                        </div>
                                            <hr class="my-10 border-gray-700 opacity-25">
                                    </div>
                                </div>

                            </div>
                            <!-- Remove episode button -->
                            <button v-if="this.form.episodes.length > 1" @click.prevent="remove" class="bg-red-800 rounded py-2 px-4 my-2 text-white block float-right md-float-right mx-5 hover:bg-red-700">
                                X  
                            </button>
                            <!-- Add episode button -->
                            <button v-if="this.form.episodes.length < 10" @click.prevent="add" class="bg-green-700 rounded py-2 px-4 my-2 text-white block float-right md-float-right hover:bg-green-800">
                                +
                            </button>
                            <!-- Submit button -->
                            <div class="content-center">
                                <button class="float-left bg-gray-800 hover:bg-gray-900 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                                        Conform
                                </button>
                            </div>
                        </form>
                       
                    </div>
                </div>
            </div>
    </app-layout>
</template>

<script>
    import AppLayout from './../../Layouts/AppLayout'

    export default {
        components: {
            AppLayout,
        },
        props:['categories'],
        data(){
            return {
                form:{
                    title:null,
                    description:null,
                    category_id:null,
                    episodes: [
                        {title:null , description:null , video_url:null}
                    ],
                },
            }
        },

        methods:{
            submit(){
                //Submit data
                this.$inertia.post('/Courses',this.form);
            },
            add(){
                //add a new episode
                this.form.episodes.push({title:null , description:null , video_url:null});
            },
            remove(){
                //remove an episode
                this.form.episodes.pop();
            }
        }
    }
</script>
