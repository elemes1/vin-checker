<template>

    <div class="min-h-full flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <img class="mx-auto h-12 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg"
                alt="Workflow" />
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Sign in to your account
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">

                {{ ' ' }}
                <router-link :to="{name : 'register'}" class="font-medium text-indigo-600 hover:text-indigo-500"> New
                    member ? Set Up Account !
                </router-link>

            </p>
        </div>
        <errors  v-if="errors" :content="errors" :type="errors"  @close="errors=null" />
        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <form action="#" class="space-y-6" @submit.prevent="submit">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700"> Email address </label>
                        <div class="mt-1">
                            <input id="email" name="email" v-model="form.email" type="email" autocomplete="email"
                                required=""
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700"> Password </label>
                        <div class="mt-1">
                            <input id="password" name="password" v-model="form.password" type="password"
                                autocomplete="current-password" required=""
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember-me" name="remember-me" type="checkbox"
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" /> <label
                            for="remember-me" class="ml-2 block text-sm text-gray-900"> Remember me </label>
                        </div>

                        <div class="text-sm">

                            <router-link :to="{name : 'forgot-password'}"
                                class="font-medium text-indigo-600 hover:text-indigo-500"> Forgot your password ?
                            </router-link>

                        </div>
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Sign in
                        </button>
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

<script>
import {mapActions} from 'vuex'
import Errors from "../../layouts/Errors";
import Loading from "../../layouts/Loading";

export default {
    name: 'SignIn',
    components: {
        Loading,
        Errors
    },
    data() {
        return {
            form: {
                email: '',
                password: '',
            },
            errors: null,
            busy: false,
        }
    },

    methods: {
        ...mapActions({
            signIn: 'auth/signIn'
        }),

        async submit() {
            this.busy = true;
            this.errors = null
            try {
                await this.signIn(this.form)
                this.$router.replace({name: 'app'})
            } catch (e) {
                this.errors = {'message' : 'The given credential is invalid'}
            };
            this.busy = false;

        }
    }
}
</script>
