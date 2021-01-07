<!-- INDEX COMPONENT -->
<template>
  <app-layout>
    <template #header>
        <div>
            <!-- search bar in the top -->
            <div class="flex relative items-center rounded-full shadow-sm border-black hover:shadow-md">
                <input v-model='question' class="rounded-r-full w-full py-2 px-3 text-gray-700 leading-tight focus:ring-2 focus:ring-purple-600 focus:border-transparent" id="search" type="text" placeholder="Search..">
            </div>
        </div>
    </template>
    <!-- flash message -->
    <div class="bg-blue-300 border-l-4 border-indigo-800 text-gray-800 p-4" v-if="$page.flash.message">
        <p class="text-sm">{{ $page.flash.message }}</p>
    </div>
    <!-- Courses and categories -->
    <nav class="font-sans flex flex-col text-center sm:flex-row sm:text-left sm:justify-between py-4 px-6 bg-white shadow sm:items-baseline w-full">
        <div class="mb-2 sm:mb-0">
            <a @click="getAll" class="cursor-pointer text-teal-500  hover:text-red-500 background-transparent font-bold uppercase px-3 py-1 text-xs outline-none focus:outline-none mr-1 mb-1" type="button" style="transition: all .15s ease">All Categories</a>
        </div>
        <!-- Show all categories -->
        <div class="mb-2 sm:mb-0" v-for="category in this.categories" :key="category.id">
           <span v-if="category !== null"><a @click="setCategory(category.title)" class="cursor-pointer text-teal-500 hover:text-red-500 background-transparent font-bold uppercase px-3 py-1 text-xs outline-none focus:outline-none mr-1 mb-1" type="button" style="transition: all .15s ease">{{category.title}}</a></span>
        </div>
    </nav>
    <!-- Show all courses, with details(category,participants,creator..) -->
    <div v-for="course in this.getFilterCourses" :key="course.id" class="shadow-md bg-white text-gray-500 m-8 p-6 rounded hover:shadow-lg">
        <div class="flex items-center">
            <div class="description">
                <div class="flex flex-row items-center">
                    <a :href="'/Course/'+course.id"><h1 class="text-2xl font-semibold mr-4 hover:text-indigo-500">{{ course.title}}</h1></a>
                </div>
                <!-- votes -->
                <div class="text-red-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1" type="button" style="transition: all .15s ease">
                    <i class="fa fa-heart"></i> Has {{course.votes_count}} Vote<span v-if="course.votes_count > 1">s</span>
                </div>
            </div>
            <!-- Button for opening card -->
                <div class="ml-4">
                    <div @click="InsertIndex(course.id)" class="cursor-pointer px-3 py-2 text-gray-600 hover:text-gray-700" :class="{'transform rotate-180': index == course.id}">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                    </div>
                </div>
            </div>
            <!-- Collapsed content -->
            <div class="w-full flex flex-col mt-8" :class="{'hidden': index != course.id}">
                <div><span class="cursor-pointer font-semibold p-3 mx-3 hover:text-green-400">Creator : {{ course.user.name }}</span></div>
                <div><span class="cursor-pointer font-semibold p-3 mx-3 hover:text-green-400">{{course.participants}} participant<span v-if="parseInt(course.participants) >1 ">s</span></span></div>
                <div><span class="cursor-pointer font-semibold p-3 mx-3 hover:text-green-400">{{ course.episodes_count }} episode<span v-if="parseInt(course.episodes_count)>1">s</span></span></div>
                <div><span class="cursor-pointer font-semibold p-3 mx-3 hover:text-green-400" v-if="course.category === null">No category</span><span class="cursor-pointer font-semibold p-3 mx-3 hover:text-green-400" v-else>category : {{course.category.title}}</span></div>
                <div><span class="cursor-pointer font-semibold p-3 mx-3 hover:text-green-400">Created at : {{course.created_at | formatDate}}</span></div>
                <hr class="my-4 border-gray-700">
                <p>{{course.description}}</p>  
            </div>
    </div>
    <!-- If there is no courses or category has no courses yet. -->
    <div class="text-center py-10" v-if="getFilterCourses.length == 0">
      <span class="text-center p-2 bg-green-100 rounded-full text-gray-800">No Courses yet.</span>
    </div>
    <!-- Pagination -->
    <div class="text-center py-10">
      <inertia-link :href="link.url" v-for="link in courses.links" :key="link.label"
        class="text-indigo-700 border-gray-500 p-5"
        >
            <span v-if="link.label === '&laquo; Previous'" :class="{'text-red-700' : link.active}">
                <a class="cursor-pointer bg-white p-2 px-2 rounded hover:shadow">Previous</a>
            </span>
            <span v-else-if="link.label === 'Next &raquo;'" :class="{'text-red-700' : link.active}">
                <a class="cursor-pointer bg-white p-2 px-2 rounded hover:shadow">Next</a>
            </span>
            <span v-else :class="{'text-red-700' : link.active}">
               <a class="cursor-pointer bg-gray-100 px-5 rounded">{{link.label}}</a> 
            </span>
      </inertia-link>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from './../../Layouts/AppLayout';
export default {
    components: {
        AppLayout,
    },
    props: ['courses','categories'],
    data(){
        return{
            courseList : this.courses,
            question : '',
            index: null,
            category: '',
            timeout: null,
            flag:false
        }
    },
    methods:{
        InsertIndex($id){
            //open the Collapsed content for the course that has the id = $id.
            this.index = $id;
        },
        getAll(){
            //get all courses, that means all courses with all catetegories.
            this.$inertia.visit('/Courses',{ method : 'get'});
        },
        setCategory($category){
            this.category = $category;
        },
    },
    computed:{
        //If user clicked a category, this function will return courses belongs to the clicked category.
        getFilterCourses(){
            if(this.category)
            {
                return this.courseList.data.filter( course => {
                  if(course.category !== null)
                  {
                      return course.category.title.toLowerCase().includes(this.category.toLowerCase());
                  }
                });
            }
            //also if the user type something in the search bar,return the results.
            return this.courseList.data.filter( course => {
                return course.title.toLowerCase().includes(this.question.toLowerCase());
            });     
        }
    },
}
</script>

<style scoped>

</style>

