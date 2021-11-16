<template>
    <div class="min-h-full main flex flex-col justify-center py-12 sm:px-6 lg:px-8">

        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <img class="mx-auto h-12 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg"
                alt="Workflow" />
            <h2 class="mt-3 text-center text-3xl font-extrabold text-gray-900">
                Register New Account
            </h2>

        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">

                <form action="#" class="space-y-6" @submit.prevent="submit">

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700"> First Name </label>
                        <div class="mt-1">
                            <input id="first_name" name="first_name" v-model="form.first_name" type="text"
                                required=""
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                        </div>
                        <span v-show="errors.first_name" class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                                {{errors.first_name}}
                        </span>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700"> Last Name </label>
                        <div class="mt-1">
                            <input id="last_name" name="first_name" v-model="form.last_name" type="text"
                                required=""
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                            <span v-show="errors.last_name" class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                                {{errors.last_name}}
                            </span>
                        </div>
                    </div>

                    <div>
                        <label for="phone_number" class="block text-sm font-medium text-gray-700"> Phone Number </label>
                        <div class="mt-1">
                            <input id="phone_number" name="phone_number" v-model="form.phone_number" type="tel"
                                autocomplete="phone_number"
                                required=""
                                class=" appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                            <span v-show="errors.phone_number" class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                                {{errors.phone_number}}
                            </span>
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700"> Email address </label>
                        <div class="mt-1">
                            <input id="email" name="email" v-model="form.email" type="email" autocomplete="email"
                                required=""
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                        </div>
                        <span v-show="errors.email" class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                                {{errors.email}}
                            </span>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700"> Password </label>
                        <div class="mt-1">
                            <input id="password" name="password" v-model="form.password" type="password"
                                required=""
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                        </div>
                        <span  v-show="errors.password" class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                                {{errors.password}}
                        </span>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700"> Confirm Password </label>
                        <div class="mt-1">
                            <input id="password_confirmation" type="password" required="" name="password_confirmation"
                                v-model="form.password_confirmation"
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                        <span v-show="errors.password" class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                                {{errors.password}}
                        </span>
                    </div>

                    <div class="flex items-center justify-between">

                        <div class="text-sm">
                            <router-link :to="{name : 'login'}" class="text-sm text-blue-500 hover:underline"> Already a
                                member ? Sign In !
                            </router-link>
                        </div>
                    </div>
                    <div class=" w-full my-1 py-2 sm:flex  sm:items-center  sm:justify-end">
                        <div class="sm:w-8/12 w-full  flex justify-between items-center mt-3 sm:mt-0">
                            <div v-if="busy"
                                class="flex justify-center items-center p-2 px-6 rounded-sm text-white bg-indigo-500 hover:bg-indigo-600">
                                <loading class="w-6 h-6" />
                            </div>
                            <button type="submit" class="p-3 rounded-sm text-white bg-indigo-500 hover:bg-indigo-600">
                                Register
                            </button>
                        </div>
                    </div>
                </form>

                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300" />
                        </div>
                        <div class="relative flex justify-center text-sm">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
.main{
    /*background-image: url('../../../../assets/register.svg') ;*/
    /*background-repeat: no-repeat;*/
    /*background-size: 1em;*/
}
</style>
<script>
import Loading from "../../layouts/Loading";
import Errors from "../../layouts/Errors";
import {mapActions} from "vuex";
import axios from "axios";

export default {
    components: {
        Loading,
        Errors
    },
    data() {
        return {
            form: {
                first_name: '',
                last_name: '',
                email: '',
                phone_number: '',
                password: '',
                password_confirmation: '',
            },
            busy: false,
            errors: {
                first_name: '',
                last_name: '',
                email: '',
                phone_number: '',
                password: '',
            }

        }
    },
    methods: {
        ...mapActions({
            signIn: 'auth/signIn'
        }),
        async submit() {
            this.busy = true;
            this.errors = null
            this.success = ''
            try {
                await axios.get('/sanctum/csrf-cookie')
                await axios.post('/api/register',this.form).then(response=>{
                    this.signIn(this.form)
                    this.success =true
                    this.$router.replace({name: 'verify-user'})
                }).catch(({response:{data}})=>{
                    this.busy = false;
                    this.errors = data.errors
                }).finally(()=>{
                    this.busy = false;
                })
            } catch (e) {

            }
            this.busy = false;
        }
    }
}

</script>
