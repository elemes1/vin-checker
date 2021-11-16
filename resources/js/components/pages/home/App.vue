<template>
    <div class=" main leading-normal tracking-normal text-indigo-400 m-6 bg-cover bg-fixed">
        <div class="h-full">
            <div class="w-full container mx-auto">
                <div class="w-full flex items-center justify-between">
                    <a class="flex items-center text-indigo-400 no-underline hover:no-underline font-bold text-2xl lg:text-4xl"
                        href="#"> VIN Decoder and Lookup </a>
                </div>
            </div>

            <div class="container pt-24 md:pt-36 mx-auto flex flex-wrap flex-col md:flex-row items-center">
                <div class="flex flex-col w-full xl:w-2/5 justify-center lg:items-start overflow-y-hidden">
                    <p class="leading-normal text-base md:text-2xl mb-8 text-center md:text-left">
                        Decode Your Vehicle Identification Number for Free
                    </p>
                    <form action="#" @submit.prevent="submit"
                        class="bg-gray-100 opacity-75 w-full shadow-lg rounded-lg px-8 pt-6 pb-8 mb-4">
                        <div class="mb-4">
                            <label class="block text-indigo-800 py-2 font-bold mb-2" for="vin">

                                <button type="button" @click="enterSample()">
                                    Try a Sample VIN
                                </button>
                            </label>
                            <input
                                class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-tight focus:ring transform transition hover:scale-105 duration-300 ease-in-out"
                                name="vin"
                                v-model="form.vin"
                                id="vin"
                                required
                                type="text"
                                placeholder="Enter Your VIN"
                            />
                            <span v-show="errors.vin" class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                                {{errors.vin}}
                            </span>
                        </div>
                        <div class="flex items-center justify-between pt-4">
                            <button
                                class="bg-gradient-to-r from-purple-800 to-green-500 hover:from-pink-500 hover:to-green-500 text-white font-bold py-2 px-4 rounded focus:ring transform transition hover:scale-105 duration-300 ease-in-out"
                                type="submit"
                            >
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
                <div v-show="details==null" class="w-full xl:w-3/5 p-12 overflow-hidden">
                    <img class="mx-auto w-full md:w-4/5 transform -rotate-6 transition hover:scale-105 duration-700 ease-in-out hover:rotate-6"  src="https://myfreevin.com/wp-content/uploads/2020/02/vin-decoder-explainer-1.png" />
                </div>

                <div v-show="details !== null" class="w-full xl:w-3/5 p-12 overflow-hidden">
                    <searchResult :details="details"/>
                </div>

            </div>
        </div>
    </div>
</template>


<script>

import Loading from "../../layouts/Loading";
import Errors from "../../layouts/Errors";
import axios from "axios";
import searchResult from "./SearchResult";

export default {
    props : {
    },
    components: {
        Loading,
        Errors,
        searchResult
    },
    data() {
        return {
            form: {
                vin: '',
            },
            details: null,
            busy: false,
            errors: {
                vin: '',
            }
        }
    },
    methods: {
        enterSample(){
            this.form.vin = "4T4BF1FKXER340134"
        },
        async submit() {
            this.busy = true;
            this.details = {};
            this.errors.vin = null
            this.success = ''
            try {
                await axios.get('/sanctum/csrf-cookie')
                await axios.post('/api/search-vin', this.form).then(response => {
                    if (!response.data.success) {
                        this.busy = false;
                        this.success = response.data;
                        this.details = null;
                    }else{

                        this.busy = false;
                        this.details = response.data.data;
                        this.success = response.data.message
                    }
                }).catch(({response: {data}}) => {
                    this.busy = false;
                    this.details = null;
                    this.errors = data.errors
                }).finally(() => {
                    this.busy = false;
                })
            } catch (e) {
            }
            this.busy = false;
        }
    }
}
</script>
