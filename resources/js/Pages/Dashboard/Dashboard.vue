<!-- NORMAL USERS DASHBOARD -->
<template>
    <app-layout>
    <template #header>
            <!-- Header -->
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Hello <span class="bg-gray-100 rounded-full p-2">{{$page.user.name}}</span> This Is Your Dashboard
            </h2>
    </template>
    <!-- Flash message -->
    <div v-if="$page.flash.message" class="bg-blue-300 border-l-4 border-indigo-800 text-gray-800 p-4" role="alert">
         <p class="font-bold">Be Warned</p>
        <p>{{ $page.flash.message }}</p>
    </div>
    <body class="antialiased font-sans bg-gray-200">
        <!-- IF USER HAS COURSES -->
        <div class="container mx-auto px-4 sm:px-8" v-if="UserCourses.length > 0">
            <div class="py-8">
                <div>
                    <h2 class="text-2xl font-semibold leading-tight">Courses you have created</h2>
                </div> 
            <div class="my-2 flex sm:flex-row flex-col">
                <div class="block relative w-full">
                    <span class="h-full absolute inset-y-0 left-0 flex items-center pl-2">
                        <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current text-gray-500">
                            <path
                                d="M10 4a6 6 0 100 12 6 6 0 000-12zm-8 6a8 8 0 1114.32 4.906l5.387 5.387a1 1 0 01-1.414 1.414l-5.387-5.387A8 8 0 012 10z">
                            </path>
                        </svg>
                    </span>
                    <!-- SEARCH BAR -->
                    <input placeholder="Search" v-model='question'
                        class="w-full appearance-none rounded-full sm:rounded-l-none border border-gray-400 border-b block pl-8 pr-6 py-2 w-full bg-white text-sm placeholder-gray-400 text-gray-700 focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none" />
                </div>
            </div>
            <!-- THEN SHOW COURSES -->
            <div class="mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                <div class="inline-block min-w-full shadow rounded-lg overflow-hidden table-auto">
                        <table class="min-w-full leading-normal table-auto ">
                            <thead>
                                <tr>
                                    <th
                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Course Title
                                    </th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Course Episodes
                                    </th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Created at
                                    </th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Participant
                                    </th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Category
                                    </th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Options
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="course in this.getFilterCourses" :key="course.id">
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <div class="flex items-center">
                                            <div class="ml-3">
                                                <p class="text-gray-900 whitespace-no-wrap">
                                                    {{course.title}}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <span
                                            class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                            <span aria-hidden
                                                class="absolute inset-0 bg-indigo-200 opacity-50 rounded-full"></span>
                                            <span class="relative">{{course.episodes_count}} Episode<span v-if="parseInt(course.episodes_count) >1">s</span></span>
                                        </span>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <span
                                            class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                            <span aria-hidden
                                                class="absolute inset-0 bg-gray-200 opacity-50 rounded-full"></span>
                                            <span class="relative">{{course.created_at | formatDate}}</span>
                                        </span>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <span
                                            class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                            <span aria-hidden
                                                class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                            <span class="relative">{{course.participants}} Participant<span v-if="parseInt(course.participants) >1">s</span></span>
                                        </span>
                                    </td>
                                   <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <span
                                            class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                            <span aria-hidden
                                                class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                            <span  class="relative">{{course.category.title}}</span>
                                        </span>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <ul class="list-none">
                                            <a :href="'/Courses/edit/'+course.id"><li class="rounded-sm px-3 py-1 hover:bg-gray-100 rounded-full p-1 my-2">Edit</li></a>
                                            <a @click="deleteCourse(course.id)" class="cursor-pointer"><li class="rounded-sm px-3 py-1 hover:bg-red-100 rounded-full p-1 my-2">Delete</li></a>
                                            <a :href="'/Course/'+course.id"><li class="rounded-sm px-3 py-1 hover:bg-yellow-100 rounded-full p-1 my-2 ">Visit</li></a>
                                        </ul>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div
                            class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between          ">
                            <span class="text-xs xs:text-sm text-gray-900">
                                <span class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                    <span class="relative bg-green-200 rounded-full p-2">Total: {{this.getFilterCourses.length}} Entries</span>
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- IF USER HAS NO COURSES -->
        <div v-else>
            <div class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between          ">
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

    export default {
        components: {
            AppLayout,
        },
        props:['courses'],
        data(){
            return {
               UserCourses: this.courses,
               question : '',
            }
        },

        methods:{
            //delete course if user clicked delete button.
            deleteCourse($courseId){
                this.$inertia.delete('/Course/delete/'+$courseId);
            },
        },    
        
        computed:{
            // if user type something in the search bar in top then search , the return the results.
            getFilterCourses(){
               return this.UserCourses.filter( course => {
                    return course.title.toLowerCase().includes(this.question.toLowerCase());
                });
            }
        },

    }
</script>
