<template>
<app-layout>
    <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Hello Admin <span class="font-bold">{{$page.user.name}} you have {{emails.length}} email<span v-if="emails.length>1">s</span>.</span>
        </h2>
    </template>
<div v-if="$page.flash.message" class="bg-blue-200 border-l-4 border-blue-800 text-green-dark p-4" role="alert">
    <p class="font-bold">Be Warned</p>
    <p>{{ $page.flash.message }}</p>
</div>
<body class="flex items-center justify-center">
	<div class="overflow-x-auto">
            <div class="overflow-x-auto px-2">
                <div class="py-3 px-3">
                    <input v-model="question" class="border-2 border-gray-300 bg-white w-full h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none"
                        type="search" name="search" placeholder="search for email..">
                </div>
                    <table class="min-w-full leading-normal table-auto ">
                        <thead>
                                <tr>
                                    <th 
                                        class="cursor-pointer px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hover:bg-gray-200">
                                        Name
                                    </th>
                                    <th 
                                        class="cursor-pointer px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hover:bg-gray-200">
                                        Email
                                    </th>
                                    <th 
                                        class="cursor-pointer px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hover:bg-gray-200">
                                       Message
                                    </th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Options
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="email in getFilterCourses" :key="email.id">
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <div class="flex items-center">
                                            <div class="ml-3">
                                                <p class="text-gray-900 whitespace-no-wrap">
                                                    {{email.firstname}}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <span
                                            class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                            <span aria-hidden
                                                class="absolute inset-0 bg-indigo-200 opacity-50 rounded-full">
                                            </span>
                                                {{email.email}}
                                        </span>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <div class="flex items-center">
                                            <div class="ml-3">
                                                <p class="text-gray-900 whitespace-no-wrap">
                                                    {{email.message}}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <ul class="list-none">
                                            <a @click="deleteMail(email.id)" class="cursor-pointer"><li class="text-center rounded-sm px-3 py-1 hover:bg-red-100 shadow-sm rounded-full p-1 my-2">Delete</li></a>
                                        </ul>
                                    </td>
                                </tr>
                            </tbody>
                    </table>
                </div>
            </div>
</body>
</app-layout>
</template>

<script>
import AppLayout from './../../Layouts/AppLayout';
export default {
    components:{
        AppLayout,
    },
    data(){
        return{
            question: ''
        }
    },
    props:['emails'],
    methods:{
        deleteMail($emailId){
            this.$inertia.delete('/delete/mail/'+$emailId);
        }
    },
    computed:{
        getFilterCourses(){
            return this.emails.filter( course => {
                return course.email.toLowerCase().includes(this.question.toLowerCase());
            });     
        }
    }
}
</script>

<style>
</style>