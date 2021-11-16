<template>
    <div class="max-w-screen-md mx-auto text-gray-900">
        <div class="flex justify-center">
            <div class="flex-1">
                <div class="border w-auto">
                    <div  class="border p-4  font-semibold"> Verify Phone Number</div>
                    <success  v-if="success" :content="success" @close="success=null" />
                    <errors v-if="errors" :content="errors" @close="errors=null" />
                    <div class="bg-white shadow sm:rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="mt-2 max-w-xl text-sm text-gray-500">
                                <p>
                                    <em> input token sent to your phone </em>
                                </p>
                            </div>
                            <form action="#" @submit.prevent="submit" class="flex flex-col">
                                <div class="w-full sm:max-w-xs">
                                    <input type="text" name="otp_code" v-model="form.otp_code" id="otp_code"  required="" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="" />
                                </div>
                                <div class=" my-1 py-2 sm:w-8/12 md:w-10/12 md:p-4 w-full mx-auto flex justify-center items-center mt-3 sm:mt-0">
                                    <div v-if="busy"  class="flex justify-center items-center p-2 px-6 rounded-sm text-white bg-blue-500 hover:bg-blue-600">
                                        <loading class="w-6 h-6" />
                                    </div>
                                    <button v-else @click="errors ? resend() : send()" :class="'mt-3 w-full inline-flex items-center justify-center px-4 py-2 border border-transparent shadow-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm' + (!errors ? ' bg-blue-500 hover:bg-blue-600' : ' bg-red-400 text-white hover:bg-red-600')  " >
                                        {{ errors ? 'Oops! Resend Code ?' :'Send'}}
                                    </button>

                                    <button type="submit"  :class="'mt-3 w-full inline-flex items-center justify-center px-4 py-2 border border-transparent shadow-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm' + (!errors ? ' bg-blue-500 hover:bg-blue-600' : ' bg-red-400 text-white hover:bg-red-600')  " >
                                        Verify Code
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Errors from "../../layouts/Errors";
import Success from "../../layouts/Success";
import Loading from "../../layouts/Loading";
import axios from "axios";
import {mapActions} from "vuex";

export default {
    components : {
        Errors,
        Success,
        Loading
    },

    data() {
        return {
            errors : null,
            success : '',
            busy : false ,
            form : {
                otp_code : ''
            }
        }
    },

    methods : {
        async send(){
            this.busy = true ;
            this.errors = null
            this.success = ''
            await axios.get('/sanctum/csrf-cookie')
            await axios.get('/api/verify') .then((res) =>{
                if(!res.data.success){
                    this.busy = false ;
                    this.errors = {'message' : res.data.message}
                    return;
                }
                this.busy = false ;
                this.success = res.data.message

            })
                .catch((err) =>{
                    console.log(err)
                    this.errors = {'message' : 'Phone Number Could not be validated.'}
                })
            this.busy = false ;
        },
        async resend(){
            this.busy = true ;
            this.errors = null
            this.success = ''
            await axios.get('/sanctum/csrf-cookie')
            await axios.get('/api/verify/resend') .then((res) =>{
                if(!res.data.success){
                    this.busy = false ;
                    this.errors = {'message' : res.data.message}
                    return;
                }
                this.busy = false ;
                this.success = res.data.message

            })
                .catch((err) =>{
                    console.log(err)
                    this.errors = {'message' : 'Phone Number Could not be validated.'}
                })
            this.busy = false ;
        },
        async submit(){
            this.busy = true ;
            this.errors = null
            this.success = ''
            await axios.get('/sanctum/csrf-cookie')
            await axios.post('/api/verify', this.form) .then((res) =>{
                if(!res.data.success){
                    this.busy = false ;
                    this.success = res.data
                }
                this.busy = false ;
                this.success = res.data.message
                this.$router.go()
            })
                .catch((err) =>{
                    this.errors = {'message' : 'Phone Number Could not be validated.'}
                })
        }
    },

}
</script>
