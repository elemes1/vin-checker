<template>
    <div class=" w-full pb-72 main" style="">
        <div class="search flex justify-center pt-36" >
            <form action="" class="flex flex-col" >
                <input type="text" class="border-2 border-purple-300  px-3 w-96 h-12 py-3 placeholder-gray-400 text-gray-400  bg-white  rounded text-sm shadow focus:outline-none focus:ring"  placeholder="Search VIN" style="transition: all 0.15s ease 0s;"/>
                <input class="items-center text-center cursor-pointer text-white  rounded-md bg-purple-600  w-24 h-10 mt-4" type="submit" value="Submit">
            </form>
        </div>
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="sr-only">Page title</h1>
            <!-- Main 3 column grid -->
            <div class="grid grid-cols-1 gap-4 items-start lg:grid-cols-3 lg:gap-8">
                <!-- Left column -->
                <div class="grid grid-cols-1 gap-4 lg:col-span-2 ">
                    <section aria-labelledby="section-1-title filter ">
                        <h2 class="sr-only" id="section-1-title">Section title</h2>
                        <div class="rounded-lg bg-white overflow-hidden shadow-lg">
                            <div class="p-6">
                                <!-- Your content -->
                            </div>
                        </div>
                    </section>
                </div>

                <!-- Right column -->
                <div class="grid grid-cols-1 gap-4">
                    <section aria-labelledby="section-2-title">
                        <h2 class="sr-only" id="section-2-title">Section title</h2>
                        <div class="rounded-lg bg-white overflow-hidden shadow-lg">
                            <div class="p-6">
                                <!-- Your content -->
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</template>


<style scoped>
.main{
    background-image: url('../../../../assets/bg-image.png');
}
</style>


<script>

import Loading from "../../layouts/Loading";
import Errors from "../../layouts/Errors";
import axios from "axios";

export default {
    components: {
        Loading,
        Errors
    },
    data() {
        return {
            form: {
                vin: '',
            },
            details : null,
            busy: false,
            errors: {
                vin: '',
            }
        }
    },
    methods: {
        async submit() {
            this.busy = true;
            this.errors = null
            this.success = ''
            try {
                await axios.get('/sanctum/csrf-cookie')
                await axios.post('/api/search-vin',this.form).then(response=>{
                    if(!response.data.success){
                        this.busy = false ;
                        this.success = response.data
                    }
                    this.busy = false ;
                    this.success = response.data.message
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

V
</script>
