<template>
   <div>
       <div class="border font-semibold  p-4  flex items-center justify-between">
           Profile
       </div>

       <div class="p-4 bg-white">

           <Success  v-if="success" :content="success" @close="success=null" />

           <Errors  v-if="errors" :content="errors" @close="errors=null" />

           <form class="md:w-10/12 md:p-4 w-full mx-auto" @submit.prevent="update">
               <div class=" w-full my-1 py-2 sm:flex  sm:items-center sm:justify-between">
                   <label for="name" class="w-4/12 "> Name </label>
                   <input type="text" v-model="form.name"  name="name" class="border border-gray-300 bg-white sm:w-8/12 w-full p-2 mt-3 sm:mt-0 focus:outline-none rounded-sm ">
               </div>
               <div class=" w-full my-1 py-2 sm:flex  sm:items-center sm:justify-between">
                   <label for="Email" class="w-4/12 "> Email </label>
                   <input type="email" v-model="form.email" name="email" class="border border-gray-300 bg-white sm:w-8/12 w-full p-2 mt-3 sm:mt-0 focus:outline-none rounded-sm">
               </div>

               <div class=" w-full my-1 py-2 sm:flex  sm:items-center  sm:justify-end">
                   <div class="sm:w-8/12 w-full  flex justify-between items-center mt-3 sm:mt-0">
                       <div v-if="busy"  class="flex justify-center items-center p-2 px-6 rounded-sm text-white bg-blue-500 hover:bg-blue-600">
                           <loading class="w-6 h-6" />
                       </div>
                       <button v-else type="submit" class="p-3 rounded-sm text-white bg-blue-500 hover:bg-blue-600">Update</button>
                   </div>
               </div>
           </form>


       </div>
   </div>
</template>


<script>
import Errors from "../../layouts/Errors";
import Success from "../../layouts/Success";
import Loading from "../../layouts/Loading";
import {mapActions, mapGetters} from "vuex";
export default {
    components : {
        Errors,
        Success,
        Loading
    },
    data() {
        return {
           form : {
               email :  '' ,
               name :  '',
           },
            errors : null,
            success : '' ,
            busy : false ,
        }
    },
computed : {
        ...mapGetters({
            authenticated: 'auth/authenticated',
            user: 'auth/user',
            phoneValidated: 'auth/phoneValidated',
        }) ,

    },

    methods : {
        ...mapActions({
            profile: 'auth/profile'
        }),

        async update(){
            this.busy = true ;
            this.errors = null
            this.success = ''
            try {
                await this.profile(this.form)
                this.success = 'profile updated successfully !'
            }
            catch (e){
                this.errors = e.data
            };
            this.busy = false ;

        },

    },

    mounted() {
        this.form.name = this.user.name
        this.form.email = this.user.email
    },


}
</script>
