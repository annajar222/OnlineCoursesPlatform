<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Hello Admin <span class="font-bold">{{$page.user.name}}</span>
            </h2>
        </template>
    <body class="antialiased font-sans bg-gray-200">
        <div v-if="$page.flash.message" class="bg-blue-200 border-l-4 border-blue-800 text-green-dark p-4" role="alert">
            <p class="font-bold">Be Warned</p>
            <p>{{ $page.flash.message }}</p>
        </div>
        <span v-if="$page.user.is_parentAdmin">
            <add-admin></add-admin>
        </span>
        <div class="overflow-x-auto" v-if="users.length > 0">
            <div class="overflow-x-auto px-2">
                <div class="py-3 px-3">
                    <input v-model="question" class="border-2 border-gray-300 bg-white w-full h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none"
                        type="search" name="search" placeholder="search for name..">
                </div>
                    <table class="min-w-full leading-normal table-auto ">
                        <thead>
                                <tr>
                                    <th @click="sort('name')"
                                        class="cursor-pointer px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hover:bg-gray-200">
                                        User Name <span class="text-xs text-bold"><img class="w-3 float-right" src="https://img.icons8.com/metro/26/000000/sort.png"/></span>
                                    </th>
                                    <th @click="sort('email')"
                                        class="cursor-pointer px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hover:bg-gray-200">
                                        User Email <span class="text-xs text-bold"><img class="w-3 float-right" src="https://img.icons8.com/metro/26/000000/sort.png"/></span>
                                    </th>
                                    <th @click="sort('courses_count')"
                                        class="cursor-pointer px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hover:bg-gray-200">
                                        Courses <span class="text-xs text-bold"><img class="w-3 float-right" src="https://img.icons8.com/metro/26/000000/sort.png"/></span>
                                    </th>
                                    <th @click="sort('created_at')"
                                        class="cursor-pointer px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hover:bg-gray-200">
                                        Created at <span class="text-xs text-bold"><img class="w-3 float-right" src="https://img.icons8.com/metro/26/000000/sort.png"/></span>
                                    </th>
                                    <th @click="sort('is_admin')"
                                        class="cursor-pointer px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hover:bg-gray-200">
                                        Is admin <span class="text-xs text-bold"><img class="w-3 float-right" src="https://img.icons8.com/metro/26/000000/sort.png"/></span>
                                    </th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Options
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in sortedList" :key="user.id">
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <div class="flex items-center">
                                            <div class="ml-3">
                                                <p class="text-gray-900 whitespace-no-wrap">
                                                    {{user.name}}
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
                                                {{user.email}}
                                        </span>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <span
                                            class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                            <span aria-hidden
                                                class="absolute inset-0 bg-green-200 opacity-50 rounded-full">
                                            </span>
                                                {{user.courses_count}} Course<span v-if="user.courses_count > 1">s</span>
                                            </span>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <span
                                            class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                            <span aria-hidden
                                                class="absolute inset-0 bg-gray-200 opacity-50 rounded-full"></span>
                                            <span class="relative">{{user.created_at | formatDate}}</span>
                                        </span>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <span class="bg-blue-100 p-2 rounded-full text-center">{{user.is_admin ? 'Yes' : 'No'}}</span>
                                    </td>
                                    <span v-if="user.is_admin">
                                        <span v-if="$page.user.is_parentAdmin">
                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                <ul class="list-none">
                                                    <a @click="deleteUser(user.id)" class="cursor-pointer"><li class="text-center rounded-sm px-3 py-1 hover:bg-red-100 shadow-sm rounded-full p-1 my-2">Delete</li></a>
                                                </ul>
                                            </td>
                                        </span>
                                    </span>
                                    <span v-else>
                                        <td v-if="user.id != $page.user.id" class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <ul class="list-none">
                                                <a @click="deleteUser(user.id)" class="cursor-pointer"><li class="text-center rounded-sm px-3 py-1 hover:bg-red-100 shadow-sm rounded-full p-1 my-2">Delete</li></a>
                                            </ul>
                                        </td>
                                        <td v-else class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <ul class="list-none">
                                                <span class="p-1 rounded-full bg-gray-100">Your Account</span> 
                                            </ul>
                                        </td>
                                    </span>
                                </tr>
                            </tbody>
                    </table>
                </div>
            </div>
            <div v-else>
                    <div class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between">
                        <span class="text-xs xs:text-sm text-gray-900">
                            <span
                                class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                    <span aria-hidden class="absolute inset-0 bg-gray-300 opacity-50 rounded-full"></span>
                                        <span class="relative">No Profiles</span>
                                    </span>
                        </span>
                    </div>
            </div>
    </body>
    </app-layout>
</template>

<script>
    import AppLayout from './../../Layouts/AppLayout';
    import AddAdmin from './AddAdmin';

    export default {
        components: {
            AppLayout,
            AddAdmin,
        },
       props:['users'],
        data(){
            return {
                question: '',
                currentSort:'name',
                currentSortDir:'asc',
            }
        },
        methods:{
            deleteUser($userId){
                this.$inertia.delete('/delete/user/'+$userId);
            },
            sort:function(s) {
                //if s == current sort, reverse
                if(s === this.currentSort) {
                this.currentSortDir = this.currentSortDir==='asc'?'desc':'asc';
                }
                this.currentSort = s;
            }
        },
        computed:{
            sortedList:function() {
                if(this.question){
                    return this.users.filter( user => {
                        return user.name.toLowerCase().includes(this.question.toLowerCase());
                    });
                }
                return this.users.sort((a,b) => {
                    let modifier = 1;
                    if(this.currentSortDir === 'desc') modifier = -1;
                    if(a[this.currentSort] < b[this.currentSort]) return -1 * modifier;
                    if(a[this.currentSort] > b[this.currentSort]) return 1 * modifier;
                    return 0;
                });
            }
        },
        mounted(){

        }

    }
</script>


<style scoped>

</style>
