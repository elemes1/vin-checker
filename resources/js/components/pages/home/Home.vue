<template>
	<div>
        <main>
            <div class="relative pt-16 flex content-center items-center justify-center" style="min-height: 100vh;">
                <div class="absolute top-0 w-full h-full bg-center bg-cover" style='background-image: url("https://www.thetruthaboutcars.com/wp-content/uploads/2021/03/tesla-yoke-teaser.png");'>
                    <span id="blackOverlay" class="w-full h-full absolute opacity-90 bg-black"></span>
                </div>
                <div class="container relative mx-auto">
                    <div class="items-center flex flex-wrap">
                        <div class="w-full lg:w-6/12 px-4 mt-24 ml-auto mr-auto text-center">
                            <div class="pr-12">
                                <h1 class="text-white text-indigo-600 font-semibold text-center text-3xl">
                                    CHECK VEHICLE IDENTIFICATION NUMBER
                                </h1>
                                <p class="mt-4 text-lg text-gray-300">
                                    Check any VIN and get Full Vehicle History Report
                                </p>
                            </div>
                            <div class="search flex justify-center mt-6">
                                <form action="" class="flex flex-col bg-transparent">
                                    <input type="text" class="border-0 px-3 w-96 py-3 placeholder-white text-white  bg-transparent border border-blue-500  rounded text-sm shadow focus:outline-none focus:ring"  placeholder="Enter VIN" style="transition: all 0.15s ease 0s;"/>
                                    <router-link  class="p-4 tracking-widest flex items-center  text-gray-600"
                                        active-class="font-semibold text-gray-800"
                                        :to="{ name: 'login' }">
                                        <button class="items-center text-center  cursor-pointer text-white rounded-sm bg-indigo-600  w-24 h-8 mt-4" type="submit" value="Submit">
                                        Submit
                                        </button>
                                    </router-link>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </main>
	</div>
</template>

<script>

	export default {
		data() {
			return {
			}
		}
	}
</script>
