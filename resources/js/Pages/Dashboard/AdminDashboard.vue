<!-- ADMIN USERS DASHBOARD -->
<template>
    <app-layout>
        <template #header>
            <!-- Header -->
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Hello Admin <span class="font-bold">{{$page.user.name}}</span>
            </h2>
        </template>
        <!-- Flash message-->
        <div v-if="$page.flash.message" class="bg-blue-300 border-l-4 border-indigo-800 text-gray-800 p-4" role="alert">
            <p class="font-bold">Be Warned</p>
            <p>{{ $page.flash.message }}</p>
        </div>
    <body class="antialiased font-sans bg-gray-200">
        <div class="p-3">
            <!-- Categories modal/component , Check the catrgories component in admin folder. -->
            <categories :categories="categories"></categories>
            <!-- Sort by category dropdown menu -->
            <div class="dropdown inline-block relative">
                <button class="bg-white text-gray-700 font-semibold py-2 px-4 rounded inline-flex items-center">
                    <span class="mr-1">Categories</span>
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/> </svg>
                </button>
                <ul class="dropdown-menu absolute hidden text-gray-700 pt-1">
                    <li class=""><a  :href="'/dashboard'" class="cursor-pointer rounded-b bg-gray-100 hover:bg-white py-2 px-4 block whitespace-no-wrap">All Categories</a></li>
                    <li class=""><a @click="setCategory(category.title)" v-for="category in categories" :key="category.id" class="cursor-pointer rounded-b bg-gray-100 hover:bg-white py-2 px-4 block whitespace-no-wrap">{{category.title}}</a></li>
                </ul>
            </div>
        </div>
        <div class="overflow-x-auto px-2">
            <!-- Search bar  -->
            <div class="py-3">
                <input v-model="question" class="border-2 border-gray-300 bg-white w-full h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none"
                    type="search" name="search" placeholder="Search...">
            </div>
            <!-- COURSES TABLE -->
            <div v-if="courses.length > 0" class="inline-block min-w-full shadow rounded-lg overflow-x-auto table-auto">
                    <table class="min-w-full leading-normal table-auto">
                        <thead>
                                <tr>
                                    <th @click="sort('title')"
                                        class="cursor-pointer px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hover:bg-gray-200">
                                        Course Title <span class="text-xs text-bold"><img class="w-3 float-right" src="https://img.icons8.com/metro/26/000000/sort.png"/></span>
                                    </th>
                                    <th @click="sort('created_at')"
                                        class="cursor-pointer px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hover:bg-gray-200">
                                        Created at <span class="text-xs text-bold"><img class="w-3 float-right" src="https://img.icons8.com/metro/26/000000/sort.png"/></span>
                                    </th>
                                    <th @click="sort('episodes_count')"
                                        class="cursor-pointer px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hover:bg-gray-200">
                                        Episodes <span class="text-xs text-bold"><img class="w-3 float-right" src="https://img.icons8.com/metro/26/000000/sort.png"/></span>
                                    </th>
                                    <th @click="sort('participants')"
                                        class="cursor-pointer px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hover:bg-gray-200">
                                        Participants<img class="w-3 float-right" src="https://img.icons8.com/metro/26/000000/sort.png"/>  
                                    </th>
                                    <th 
                                        class="cursor-pointer px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hover:bg-gray-200">
                                        Category
                                    </th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Options
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="course in sortedList" :key="course.id">
                                    <td :class="course.user.id === $page.user.id ? 'px-5 py-5 border-b border-gray-200 bg-purple-100 text-sm' : 'px-5 py-5 border-b border-gray-200 bg-white text-sm'">
                                        <div class="flex items-center">
                                            <div class="ml-3">
                                                <p class="text-gray-900 whitespace-no-wrap">
                                                    {{course.title}}
                                                </p>
                                            </div>
                                        </div>
                                        <span class="text-indigo-900 pl-3">
                                                Created by {{course.user.name}}
                                                <span v-if="course.user.id === $page.user.id">(Yours)</span>
                                        </span>
                                    </td>
                                    <td :class="course.user.id === $page.user.id ? 'px-5 py-5 border-b border-gray-200 bg-purple-100 text-sm' : 'px-5 py-5 border-b border-gray-200 bg-white text-sm'">
                                        <span
                                            class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                            <span aria-hidden
                                                class="absolute inset-0 bg-gray-200 opacity-50 rounded-full"></span>
                                            <span class="relative">{{course.created_at | formatDate}}</span>
                                        </span>
                                    </td>
                                    <td :class="course.user.id === $page.user.id ? 'px-5 py-5 border-b border-gray-200 bg-purple-100 text-sm' : 'px-5 py-5 border-b border-gray-200 bg-white text-sm'">
                                        <span
                                            class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                            <span aria-hidden
                                                class="absolute inset-0 bg-green-200 opacity-50 rounded-full">
                                            </span>
                                                {{course.episodes_count}} Episode<span v-if="course.episodes_count > 1">s</span>
                                            </span>
                                    </td>
                                    <td :class="course.user.id === $page.user.id ? 'px-5 py-5 border-b border-gray-200 bg-purple-100 text-sm' : 'px-5 py-5 border-b border-gray-200 bg-white text-sm'">
                                        <span
                                            class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                            <span aria-hidden
                                                class="absolute inset-0 bg-green-200 opacity-50 rounded-full">
                                            </span>
                                                {{course.participants}} Participant<span v-if="course.participants > 1">s</span>
                                            </span>
                                    </td>
                                    <td :class="course.user.id === $page.user.id ? 'px-5 py-5 border-b border-gray-200 bg-purple-100 text-sm' : 'px-5 py-5 border-b border-gray-200 bg-white text-sm'">
                                        <!-- IF COURSE HAS CATEGORY THEN: -->
                                        <span  v-if="course.category !== null"
                                            class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                            <span aria-hidden
                                                class="absolute inset-0 bg-green-200 opacity-50 rounded-full">
                                            </span>
                                                {{course.category.title}}
                                        </span>
                                        <!-- IF COURSE HAS NO CATEGORY THEN: -->
                                        <span  v-else
                                            class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                            <span aria-hidden
                                                class="absolute inset-0 bg-green-200 opacity-50 rounded-full">
                                            </span>
                                                Has No Category
                                        </span>
                                    </td>
                                    <td :class="course.user.id === $page.user.id ? 'px-5 py-5 border-b border-gray-200 bg-purple-100 text-sm' : 'px-5 py-5 border-b border-gray-200 bg-white text-sm'">
                                        <ul class="list-none">
                                                <a @click="deleteCourse(course.id)" class="cursor-pointer"><li class="rounded-sm px-3 py-1 hover:bg-red-100 shadow-sm rounded-full p-1 my-2">Delete</li></a>
                                                <a :href="'/Course/'+course.id" class="cursor-pointer"><li class="rounded-sm px-3 py-1 hover:bg-gray-100 rounded-full p-1 my-2 shadow-sm">Visit</li></a>
                                                <span v-if="course.user.id === $page.user.id"><a :href="'/Courses/edit/'+course.id" class="cursor-pointer"><li class="rounded-sm px-3 py-1 hover:bg-green-100 rounded-full p-1 my-2 shadow-sm">Edit</li></a></span>
                                        </ul>
                                    </td>
                                </tr>
                            </tbody>
                    </table>
            </div>
            <!-- IF THERE IS NO COURSES -->
            <div v-else class="px-5 py-5 flex flex-col xs:flex-row items-center xs:justify-between">  
                <span class="text-xs xs:text-sm text-gray-900">
                    <span
                        class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                            <span aria-hidden class="absolute inset-0 bg-gray-300 opacity-50 rounded-full"></span>
                                <span class="relative">No Courses Created Yet</span>
                    </span>
                </span>
            </div>
        </div>
    </body>
    </app-layout>
</template>

<script>
    import AppLayout from './../../Layouts/AppLayout'
    import Categories from './../Admin/Categories.vue';

    export default {
        components: {
            AppLayout,
            Categories,
        },
        props:['courses','categories'],
        data(){
            return{
                question: '',
                flag:false,
                currentSort:'title',
                currentSortDir:'asc',
                category : null
            }
        },
        methods:{
            //DELETE COURSE
            deleteCourse($courseId){
                 this.$inertia.delete('/Course/delete/byAdmin/'+$courseId);
            },
            setFlag(){
                this.flag = !this.flag;
            },
            //SORT FUNCTION
            sort(s) {
                //if s == current sort, reverse
                if(s === this.currentSort) {
                this.currentSortDir = this.currentSortDir==='asc'?'desc':'asc';
                }
                this.currentSort = s;
            },
            //SET CATEGORY FUCNTION
            setCategory($category){
                this.category =  $category;
            },
        },
        computed:{
            //SORT COURSES
            sortedList() {
                //IF ADMIN SEARCH FOR A COURSE
                if(this.question){
                    return this.courses.filter( course => {
                        return course.title.toLowerCase().includes(this.question.toLowerCase());
                    });
                }
                //IF ADMIN SORT COURSES BY CATEGORY
                if (this.category !== null) {
                    return this.courses.filter( course => {
                        //AND CHECK IF CATEGORY IS NOT NULL
                        //SOMETHIMG COURSE HAS NO CATEGORY..
                        if(course.category !== null){
                            return course.category.title.toLowerCase().includes(this.category.toLowerCase());
                        }
                    });
                } else {
                    //ELSE IF ADMIN WANTS TO SORT BY TITLE,CREATED AT,PARTICIPANTS NUMBER OR EPISODES.
                    return this.courses.sort((a,b) => {
                    let modifier = 1;
                    if(this.currentSortDir === 'desc') modifier = -1;
                    if(a[this.currentSort] < b[this.currentSort]) return -1 * modifier;
                    if(a[this.currentSort] > b[this.currentSort]) return 1 * modifier;
                    return 0;
                    });
                }
                
            }
        },
    }
</script>

<style scoped>
/* DROPDOWN MENU STYLE*/
.dropdown:hover .dropdown-menu {
  display: block;
}
</style>
