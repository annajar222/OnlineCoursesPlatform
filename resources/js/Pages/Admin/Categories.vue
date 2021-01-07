<template>
    <div>
        <body class="antialiased font-sans bg-gray-200">
            <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button @click="showModal" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-gray-600 text-base font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        CATEGORIES
                </button>
            </div>
           <!-- This example requires Tailwind CSS v2.0+ -->
            <div v-if="show" class="fixed z-10 inset-0 overflow-y-auto">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <!--
                    Background overlay, show/hide based on modal state.

                    Entering: "ease-out duration-300"
                        From: "opacity-0"
                        To: "opacity-100"
                    Leaving: "ease-in duration-200"
                        From: "opacity-100"
                        To: "opacity-0"
                    -->
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>

                    <!-- This element is to trick the browser into centering the modal contents. -->
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    <!--
                    Modal panel, show/hide based on modal state.

                    Entering: "ease-out duration-300"
                        From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        To: "opacity-100 translate-y-0 sm:scale-100"
                    Leaving: "ease-in duration-200"
                        From: "opacity-100 translate-y-0 sm:scale-100"
                        To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    -->
                    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h1 class="text-xl font-semibold">Hi admin 👋, <span class="font-normal">In this place you can manage categories.</span></h1>
                                    <form @submit.prevent="submit" class="mt-6">
                                        <label for="title" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">Category Title</label>
                                        <input v-model="form.title" id="title" type="text" name="title" placeholder="Title..." autocomplete="email" class="block w-full p-3 mt-2 text-gray-700 bg-gray-200 appearance-none focus:outline-none focus:bg-gray-300 focus:shadow-inner"/>
                                        <div 
                                            v-if="$page.errors.title" class="bg-red-200 text-red-800 p-4">
                                                    {{$page.errors.title[0]}}
                                        </div>
                                        <div class="bg-white px-4 py-8 sm:px-6 sm:flex sm:flex-row-reverse">
                                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-gray-700 text-base font-medium text-white hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                Submit
                                            </button>
                                            <button @click="showModal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                Cancel
                                            </button>
                                        </div>
                                    </form>
                                    <div class="py-3 text-sm">
                                        <div v-for="category in categories" :key="category.id" class="flex justify-start cursor-pointer text-gray-700 hover:text-blue-400 rounded-md px-2 py-2 my-2">
                                            <span class="bg-green-400 h-2 w-2 m-2 rounded-full"></span>
                                            <div class="flex-grow font-medium px-2">{{category.title}}</div>
                                            <div class="text-sm font-normal text-gray-500 tracking-wide">
                                                <a @click="deleteCategory(category.id)" class="cursor-pointer bg-red-500 p-2 rounded text-white hover:bg-red-600">delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </body>
    </div>
</template>

<script>
import AppLayout from '../../Layouts/AppLayout.vue';
    export default {
        props:['categories'],
        components:{
            AppLayout
        },
        data(){
            return{
                show: false,
                form:{
                    title : null
                }
            }
        },
        methods:{
            submit(){
                this.$inertia.post('/add/category',this.form);
            },
            showModal(){
                this.show = !this.show;
            },
            deleteCategory($categoryId){
                this.$inertia.delete('/delete/category/'+$categoryId);
            },
        }
    }
</script>

<style scoped>

</style>
