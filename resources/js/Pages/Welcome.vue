<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Link, Head, usePage } from "@inertiajs/vue3";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { ref } from 'vue';

const carousel = ref(null);

const scrollLeft = () => 
{
    if (carousel.value)
    {
        carousel.value.scrollBy({
            left: -300,
            behavior:"smooth"
        })
    }
}

const scrollRight = () => 
{
    if (carousel.value)
    {
        carousel.value.scrollBy({
            left: 300,
            behavior:"smooth"
        })
    }
}

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});


</script>

<template>
    <Head title="Welcome" />

    <div class="min-h-screen bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white overflow-hidden">
        <div v-if="canLogin" class="flex justify-end px-6">
            <Link
                v-if="$page.props.auth.user"
                :href="route('login')"
                class="mx-5 my-5 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
            >Addvertisments</Link>

            <template v-else>
                <Link
                    v-if="canRegister"
                    :href="route('/projects/create')"
                    class="mx-5 my-5 inline-flex items-center px-4 py-2 bg-red-600 font-bold border border-transparent rounded-md font-sans text-xs text-white uppercase tracking-widest hover:bg-red-600 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-200"
                >Start Hiring</Link>

                <Link
                v-if="canRegister"
                :href="route('/projects/create')"
                class="mx-5 my-5 inline-flex items-center px-4 py-2 bg-white font-bold border border-transparent rounded-md font-sans text-xs text-red-600 border-red-600 uppercase tracking-widest hover:bg-red-600 hover:text-white focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-200"
            >Become a Freelancer</Link>


                <Link
                    :href="route('login')"
                    class="mx-5 my-5 font-semibold py-2 text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                >Sign in</Link>

                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="mx-5 my-5 font-semibold text-gray-600 py-2 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                >Join</Link>
            </template>
        </div>

        <div class="max-w-full mx-auto p-6 lg:p-8">
            <div class="flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" x="50px" y="0px" class="w-20 h-20 md:w-24 md:h-24 lg:w-28 lg:h-28" viewBox="0,0,256,256">
                    <g fill="#e61616" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal">
                        <g transform="scale(5.12,5.12)">
                            <path d="M20,4c-0.35684,0.00005 -0.68663,0.19023 -0.8654,0.49906c-0.17878,0.30883 -0.17946,0.68952 -0.00178,0.99899l23,40c0.18349,0.31948 0.52778,0.5122 0.89605,0.50158c0.36827,-0.01062 0.70088,-0.22285 0.86567,-0.55236l4.04688,-8.09375c0.74294,-1.48837 0.69781,-3.25311 -0.12305,-4.70117l-14.79883,-26.11719c-0.88668,-1.5648 -2.55006,-2.53516 -4.34961,-2.53516zM21.72852,6h6.94141c1.08245,0 2.07606,0.58029 2.60938,1.52148l14.79883,26.11719c0.49314,0.86994 0.52128,1.92663 0.07422,2.82227l-3.21484,6.42578zM15.99609,11c-0.35259,0.00145 -0.67836,0.18845 -0.85742,0.49219l-10,17c-0.18216,0.30915 -0.18474,0.6922 -0.00676,1.00378c0.17799,0.31158 0.50925,0.50392 0.86808,0.50403h21c0.36627,-0.00003 0.70321,-0.20028 0.87832,-0.52198c0.1751,-0.3217 0.16034,-0.71338 -0.03847,-1.02099l-11,-17c-0.18503,-0.28613 -0.50301,-0.45837 -0.84375,-0.45703zM16.04102,13.9043l9.12109,14.0957h-17.41406zM3,35c-0.35465,-0.00037 -0.68298,0.18711 -0.8629,0.49273c-0.17992,0.30563 -0.18453,0.68368 -0.0121,0.9936l5,9c0.17671,0.31745 0.51168,0.5141 0.875,0.51367h28c0.35465,0.00037 0.68298,-0.18711 0.8629,-0.49273c0.17992,-0.30563 0.18453,-0.68368 0.0121,-0.9936l-5,-9c-0.17671,-0.31745 -0.51168,-0.5141 -0.875,-0.51367zM4.70117,37h25.71094l3.88672,7h-25.71094z"></path>
                        </g>
                    </g>
                </svg>
            </div>
        
            <div class="flex justify-center my-10 rounded-3xl">
                <div class="text-center">
                    <h1 class="px-4 py-2 text-red-600 text-6xl md:text-7xl lg:text-9xl font-geist font-bold">JobHunt</h1>
                    <h2 class="text-xl md:text-2xl lg:text-3xl font-bold text-gray-800">Find the best freelancers for your projects.</h2>
                </div>
            </div>


            <div class="hidden md:flex w-full h-screen">

            <div class="flex flex-col md:flex-row w-full h-screen">
                <div class="hidden md:block w-full md:w-1/2 h-1/2 md:h-full overflow-hidden">
                    <img src="/freelancer_photo-removebg.png" alt="Freelancer Image" class="w-full h-full object-cover">
                </div>
            
                <div class="flex items-center justify-center w-full md:w-1/2 p-4 md:p-0">
                    <div class="text-center w-full">
                        <h1 class="text-gray-800 text-4xl md:text-6xl lg:text-8xl">
                            <span class="text-red-600 font-bold">JobHunt</span> is ranked №1 Freelance Platform in the Baltic States
                        </h1>
                        <div class="flex space-x-4 md:space-x-10 mt-5 justify-center">
                            <img src="/lv.png" alt="Latvia" class="w-8 h-8 md:w-12 md:h-12 lg:w-16 lg:h-16">
                            <img src="/lt.png" alt="Lithuania" class="w-8 h-8 md:w-12 md:h-12 lg:w-16 lg:h-16">
                            <img src="/ee.png" alt="Estonia" class="w-8 h-8 md:w-12 md:h-12 lg:w-16 lg:h-16">
                        </div>
                    </div>
                </div>
            </div>
            </div>

                <div class="content-center my-10">
                    <div class="flex flex-row items-center justify-center">
                        <h1 class="font-bold text-2xl mx-5 opacity-75">Trusted by: </h1>
                    </div>
                </div>
            <div>
                <div class="content-center my-10">
                    <div class="flex flex-row items-center justify-center">
                        <svg class="mx-5 opacity-75" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 256 315"><path d="M213.803 167.03c.442 47.58 41.74 63.413 42.197 63.615c-.35 1.116-6.599 22.563-21.757 44.716c-13.104 19.153-26.705 38.235-48.13 38.63c-21.05.388-27.82-12.483-51.888-12.483c-24.061 0-31.582 12.088-51.51 12.871c-20.68.783-36.428-20.71-49.64-39.793c-27-39.033-47.633-110.3-19.928-158.406c13.763-23.89 38.36-39.017 65.056-39.405c20.307-.387 39.475 13.662 51.889 13.662c12.406 0 35.699-16.895 60.186-14.414c10.25.427 39.026 4.14 57.503 31.186c-1.49.923-34.335 20.044-33.978 59.822M174.24 50.199c10.98-13.29 18.369-31.79 16.353-50.199c-15.826.636-34.962 10.546-46.314 23.828c-10.173 11.763-19.082 30.589-16.678 48.633c17.64 1.365 35.66-8.964 46.64-22.262"/></svg>
                        <svg class="mx-5 opacity-75" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 256 199"><path fill="#5865f2" d="M216.856 16.597A208.502 208.502 0 0 0 164.042 0c-2.275 4.113-4.933 9.645-6.766 14.046c-19.692-2.961-39.203-2.961-58.533 0c-1.832-4.4-4.55-9.933-6.846-14.046a207.809 207.809 0 0 0-52.855 16.638C5.618 67.147-3.443 116.4 1.087 164.956c22.169 16.555 43.653 26.612 64.775 33.193A161.094 161.094 0 0 0 79.735 175.3a136.413 136.413 0 0 1-21.846-10.632a108.636 108.636 0 0 0 5.356-4.237c42.122 19.702 87.89 19.702 129.51 0a131.66 131.66 0 0 0 5.355 4.237a136.07 136.07 0 0 1-21.886 10.653c4.006 8.02 8.638 15.67 13.873 22.848c21.142-6.58 42.646-16.637 64.815-33.213c5.316-56.288-9.08-105.09-38.056-148.36M85.474 135.095c-12.645 0-23.015-11.805-23.015-26.18s10.149-26.2 23.015-26.2c12.867 0 23.236 11.804 23.015 26.2c.02 14.375-10.148 26.18-23.015 26.18m85.051 0c-12.645 0-23.014-11.805-23.014-26.18s10.148-26.2 23.014-26.2c12.867 0 23.236 11.804 23.015 26.2c0 14.375-10.148 26.18-23.015 26.18"/></svg>
                        <svg class="mx-5 opacity-75" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 256 259.3"><path fill="#9edcf2" d="M200.9 199.8c0 13.9-32.2 25.1-71.9 25.1s-71.9-11.3-71.9-25.1c0-13.9 32.2-25.1 71.9-25.1s71.9 11.2 71.9 25.1m0 0"/><defs><path id="logosGithubOctocat0" d="M98.1 244.8c1.6 7.5 5.5 11.9 9.4 14.5h41.1c5-3.4 10.1-9.8 10.1-21.8v-31s.6-7.7 7.7-10.2c0 0 4.1-2.9-.3-4.5c0 0-19.5-1.6-19.5 14.4v23.6s.8 8.7-3.8 12.3v-29.2s.3-9.3 5.1-12.8c0 0 3.2-5.7-3.8-4.2c0 0-13.4 1.9-14 17.6l-.3 30h-3.2l-.3-30c-.6-15.6-14-17.6-14-17.6c-7-1.6-3.8 4.2-3.8 4.2c4.8 3.5 5.1 12.8 5.1 12.8v29.5c-4.6-3.3-3.8-12.6-3.8-12.6v-23.6c0-16-19.5-14.4-19.5-14.4c-4.5 1.6-.3 4.5-.3 4.5c7 2.6 7.7 10.2 7.7 10.2v21.7z"/></defs><clipPath id="logosGithubOctocat1"><use href="#logosGithubOctocat0"/></clipPath><path fill="#7dbce7" d="M200.9 199.8c0 13.9-32.2 25.1-71.9 25.1s-71.9-11.3-71.9-25.1c0-13.9 32.2-25.1 71.9-25.1s71.9 11.2 71.9 25.1m0 0" clip-path="url(#logosGithubOctocat1)"/><path fill="#9edcf2" d="m46.9 125.9l-2.1 7.2s-.5 2.6 1.9 3.1c2.6-.1 2.4-2.5 2.2-3.2zm0 0"/><path fill="#010101" d="m255.8 95.6l.2-.9c-21.1-4.2-42.7-4.3-55.8-3.7c2.1-7.7 2.8-16.7 2.8-26.6c0-14.3-5.4-25.7-14-34.3c1.5-4.9 3.5-15.8-2-29.7c0 0-9.8-3.1-32.1 11.8c-8.7-2.2-18-3.3-27.3-3.3c-10.2 0-20.5 1.3-30.2 3.9C74.4-2.9 64.3.3 64.3.3c-6.6 16.5-2.5 28.8-1.3 31.8c-7.8 8.4-12.5 19.1-12.5 32.2c0 9.9 1.1 18.8 3.9 26.5c-13.2-.5-34-.3-54.4 3.8l.2.9c20.4-4.1 41.4-4.2 54.5-3.7c.6 1.6 1.3 3.2 2 4.7c-13 .4-35.1 2.1-56.3 8.1l.3.9c21.4-6 43.7-7.6 56.6-8c7.8 14.4 23 23.8 50.2 26.7c-3.9 2.6-7.8 7-9.4 14.5c-5.3 2.5-21.9 8.7-31.9-8.5c0 0-5.6-10.2-16.3-11c0 0-10.4-.2-.7 6.5c0 0 6.9 3.3 11.7 15.6c0 0 6.3 21 36.4 14.2V177s-.6 7.7-7.7 10.2c0 0-4.2 2.9.3 4.5c0 0 19.5 1.6 19.5-14.4v-23.6s-.8-9.4 3.8-12.6v38.8s-.3 9.3-5.1 12.8c0 0-3.2 5.7 3.8 4.2c0 0 13.4-1.9 14-17.6l.3-39.3h3.2l.3 39.3c.6 15.6 14 17.6 14 17.6c7 1.6 3.8-4.2 3.8-4.2c-4.8-3.5-5.1-12.8-5.1-12.8v-38.5c4.6 3.6 3.8 12.3 3.8 12.3v23.6c0 16 19.5 14.4 19.5 14.4c4.5-1.6.3-4.5.3-4.5c-7-2.6-7.7-10.2-7.7-10.2v-31c0-12.1-5.1-18.5-10.1-21.8c29-2.9 42.9-12.2 49.3-26.8c12.7.3 35.6 1.9 57.4 8.1l.3-.9c-21.7-6.1-44.4-7.7-57.3-8.1c.6-1.5 1.1-3 1.6-4.6c13.4-.5 35.1-.5 56.3 3.7m0 0"/><path fill="#f5ccb3" d="M174.6 63.7c6.2 5.7 9.9 12.5 9.9 19.8c0 34.4-25.6 35.3-57.2 35.3S70.1 114 70.1 83.5c0-7.3 3.6-14.1 9.8-19.7c10.3-9.4 27.7-4.4 47.4-4.4s37-5.1 47.3 4.3m0 0"/><path fill="#fff" d="M108.3 85.3c0 9.5-5.3 17.1-11.9 17.1c-6.6 0-11.9-7.7-11.9-17.1c0-9.5 5.3-17.1 11.9-17.1c6.6-.1 11.9 7.6 11.9 17.1m0 0"/><path fill="#af5c51" d="M104.5 85.5c0 6.3-3.6 11.4-7.9 11.4c-4.4 0-7.9-5.1-7.9-11.4c0-6.3 3.6-11.4 7.9-11.4c4.3 0 7.9 5.1 7.9 11.4m0 0"/><path fill="#fff" d="M172.2 85.3c0 9.5-5.3 17.1-11.9 17.1c-6.6 0-11.9-7.7-11.9-17.1c0-9.5 5.3-17.1 11.9-17.1c6.5-.1 11.9 7.6 11.9 17.1m0 0"/><path fill="#af5c51" d="M168.3 85.5c0 6.3-3.6 11.4-7.9 11.4c-4.4 0-7.9-5.1-7.9-11.4c0-6.3 3.6-11.4 7.9-11.4c4.4 0 7.9 5.1 7.9 11.4m-37.8 15c0 1.6-1.3 3-3 3c-1.6 0-3-1.3-3-3s1.3-3 3-3c1.6 0 3 1.3 3 3m-9.9 7.5c-.2-.5.1-1 .6-1.2c.5-.2 1 .1 1.2.6c.8 2.2 2.8 3.6 5.1 3.6s4.3-1.5 5.1-3.6c.2-.5.7-.8 1.2-.6c.5.2.8.7.6 1.2c-1 2.9-3.8 4.9-6.9 4.9c-3.1 0-5.9-2-6.9-4.9m0 0"/><path fill="#c4e5d9" d="M54.5 121.6c0 .8-.9 1.4-2.1 1.4c-1.1 0-2.1-.6-2.1-1.4c0-.8.9-1.4 2.1-1.4c1.2 0 2.1.6 2.1 1.4m5.8 3.2c0 .8-.9 1.4-2.1 1.4c-1.1 0-2.1-.6-2.1-1.4c0-.8.9-1.4 2.1-1.4c1.2 0 2.1.6 2.1 1.4m3.5 4.2c0 .8-.9 1.4-2.1 1.4c-1.1 0-2.1-.6-2.1-1.4c0-.8.9-1.4 2.1-1.4c1.2-.1 2.1.6 2.1 1.4m3.2 4.8c0 .8-.9 1.4-2.1 1.4c-1.1 0-2.1-.6-2.1-1.4c0-.8.9-1.4 2.1-1.4c1.2-.1 2.1.6 2.1 1.4m3.5 4.4c0 .8-.9 1.4-2.1 1.4c-1.1 0-2.1-.6-2.1-1.4c0-.8.9-1.4 2.1-1.4c1.2 0 2.1.6 2.1 1.4m4.8 3.9c0 .8-.9 1.4-2.1 1.4c-1.1 0-2.1-.6-2.1-1.4c0-.8.9-1.4 2.1-1.4c1.2-.1 2.1.6 2.1 1.4m6.7 2.5c0 .8-.9 1.4-2.1 1.4c-1.1 0-2.1-.6-2.1-1.4c0-.8.9-1.4 2.1-1.4c1.2 0 2.1.6 2.1 1.4m6.7 0c0 .8-.9 1.4-2.1 1.4c-1.1 0-2.1-.6-2.1-1.4c0-.8.9-1.4 2.1-1.4c1.2 0 2.1.6 2.1 1.4m6.8-1.1c0 .8-.9 1.4-2.1 1.4c-1.1 0-2.1-.6-2.1-1.4c0-.8.9-1.4 2.1-1.4c1.1 0 2.1.6 2.1 1.4m0 0"/></svg>
                        <svg class="mx-5 opacity-75" xmlns="http://www.w3.org/2000/svg" width="3.5em" height="2em" viewBox="0 0 512 168"><path fill="#ff302f" d="m496.052 102.672l14.204 9.469c-4.61 6.79-15.636 18.44-34.699 18.44c-23.672 0-41.301-18.315-41.301-41.614c0-24.793 17.816-41.613 39.308-41.613c21.616 0 32.206 17.193 35.633 26.475l1.869 4.735l-55.692 23.049c4.236 8.348 10.84 12.584 20.183 12.584c9.345 0 15.823-4.61 20.495-11.525M452.384 87.66l37.19-15.45c-2.056-5.17-8.16-8.845-15.45-8.845c-9.281 0-22.176 8.223-21.74 24.295"/><path fill="#20b15a" d="M407.407 4.931h17.94v121.85h-17.94z"/><path fill="#3686f7" d="M379.125 50.593h17.318V124.6c0 30.711-18.128 43.357-39.558 43.357c-20.183 0-32.33-13.58-36.878-24.606l15.885-6.604c2.865 6.79 9.78 14.827 20.993 14.827c13.767 0 22.24-8.535 22.24-24.482v-5.98h-.623c-4.112 4.983-11.961 9.468-21.928 9.468c-20.807 0-39.87-18.128-39.87-41.488c0-23.486 19.063-41.8 39.87-41.8c9.905 0 17.816 4.423 21.928 9.282h.623zm1.245 38.499c0-14.702-9.78-25.417-22.239-25.417c-12.584 0-23.174 10.715-23.174 25.417c0 14.514 10.59 25.042 23.174 25.042c12.46.063 22.24-10.528 22.24-25.042"/><path fill="#ff302f" d="M218.216 88.78c0 23.984-18.688 41.613-41.613 41.613c-22.924 0-41.613-17.691-41.613-41.613c0-24.108 18.689-41.675 41.613-41.675c22.925 0 41.613 17.567 41.613 41.675m-18.19 0c0-14.95-10.84-25.23-23.423-25.23c-12.583 0-23.423 10.28-23.423 25.23c0 14.826 10.84 25.23 23.423 25.23c12.584 0 23.423-10.404 23.423-25.23"/><path fill="#ffba40" d="M309.105 88.967c0 23.984-18.689 41.613-41.613 41.613c-22.925 0-41.613-17.63-41.613-41.613c0-24.108 18.688-41.613 41.613-41.613c22.924 0 41.613 17.443 41.613 41.613m-18.253 0c0-14.95-10.839-25.23-23.423-25.23c-12.583 0-23.423 10.28-23.423 25.23c0 14.826 10.84 25.23 23.423 25.23c12.646 0 23.423-10.466 23.423-25.23"/><path fill="#3686f7" d="M66.59 112.328c-26.102 0-46.534-21.056-46.534-47.158c0-26.101 20.432-47.157 46.534-47.157c14.079 0 24.357 5.544 31.957 12.646l12.522-12.521C100.479 7.984 86.338.258 66.59.258C30.833.259.744 29.414.744 65.17c0 35.758 30.089 64.912 65.846 64.912c19.312 0 33.889-6.354 45.289-18.19c11.711-11.712 15.324-28.158 15.324-41.489c0-4.174-.498-8.472-1.059-11.649H66.59v17.318h42.423c-1.246 10.84-4.672 18.253-9.718 23.298c-6.105 6.168-15.76 12.958-32.705 12.958"/></svg>
                        <svg class="mx-5 opacity-75" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24"><path fill="currentColor" d="m16.624 13.92l2.718 2.716l-7.353 7.353l-7.353-7.352l2.717-2.717l4.636 4.66zm4.637-4.636L24 12l-2.715 2.716L18.568 12zm-9.272 0l2.716 2.692l-2.717 2.717L9.272 12zm-9.273 0L5.41 12l-2.692 2.692L0 12zM11.99.012l7.35 7.328l-2.717 2.715L11.99 5.42l-4.636 4.66l-2.717-2.716z"/></svg>
                    </div>
                </div>
            

            <div class="flex flex-col md:flex-row items-center p-10 rounded-lg shadow-lg bg-white">
                <div class="md:w-1/2 space-y-6">
                    <h1 class="text-4xl font-bold font-geist text-gray-900">The ultimate <span class="text-red-600 font-nanum font-bold ">freelance</span> solution for professionals</h1>
                    <p class="text-lg text-gray-700">
                        Discover the benefits of our platform designed to elevate your freelance career.
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                        <div class="flex items-start space-x-4">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                <path fill-rule="evenodd" d="M8.603 3.799A4.49 4.49 0 0 1 12 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 0 1 3.498 1.307 4.491 4.491 0 0 1 1.307 3.497A4.49 4.49 0 0 1 21.75 12a4.49 4.49 0 0 1-1.549 3.397 4.491 4.491 0 0 1-1.307 3.497 4.491 4.491 0 0 1-3.497 1.307A4.49 4.49 0 0 1 12 21.75a4.49 4.49 0 0 1-3.397-1.549 4.49 4.49 0 0 1-3.498-1.306 4.491 4.491 0 0 1-1.307-3.498A4.49 4.49 0 0 1 2.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 0 1 1.307-3.497 4.49 4.49 0 0 1 3.497-1.307Zm7.007 6.387a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                              </svg>
                              
                        <div>
                                <h2 class="text-lg font-semibold text-gray-900">Dedicated Support</h2>
                                <p class="text-gray-700">Our team is here to help you succeed at every step.</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                <path fill-rule="evenodd" d="M8.603 3.799A4.49 4.49 0 0 1 12 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 0 1 3.498 1.307 4.491 4.491 0 0 1 1.307 3.497A4.49 4.49 0 0 1 21.75 12a4.49 4.49 0 0 1-1.549 3.397 4.491 4.491 0 0 1-1.307 3.497 4.491 4.491 0 0 1-3.497 1.307A4.49 4.49 0 0 1 12 21.75a4.49 4.49 0 0 1-3.397-1.549 4.49 4.49 0 0 1-3.498-1.306 4.491 4.491 0 0 1-1.307-3.498A4.49 4.49 0 0 1 2.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 0 1 1.307-3.497 4.49 4.49 0 0 1 3.497-1.307Zm7.007 6.387a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                              </svg>
                        <div>
                                <h2 class="text-lg font-semibold text-gray-900">Guaranteed Payments</h2>
                                <p class="text-gray-700">Enjoy secure transactions with every project.</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                <path fill-rule="evenodd" d="M8.603 3.799A4.49 4.49 0 0 1 12 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 0 1 3.498 1.307 4.491 4.491 0 0 1 1.307 3.497A4.49 4.49 0 0 1 21.75 12a4.49 4.49 0 0 1-1.549 3.397 4.491 4.491 0 0 1-1.307 3.497 4.491 4.491 0 0 1-3.497 1.307A4.49 4.49 0 0 1 12 21.75a4.49 4.49 0 0 1-3.397-1.549 4.49 4.49 0 0 1-3.498-1.306 4.491 4.491 0 0 1-1.307-3.498A4.49 4.49 0 0 1 2.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 0 1 1.307-3.497 4.49 4.49 0 0 1 3.497-1.307Zm7.007 6.387a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                              </svg>
                        <div>
                                <h2 class="text-lg font-semibold text-gray-900">Advanced Project Management</h2>
                                <p class="text-gray-700">Seamlessly manage projects from start to finish.</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                <path fill-rule="evenodd" d="M8.603 3.799A4.49 4.49 0 0 1 12 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 0 1 3.498 1.307 4.491 4.491 0 0 1 1.307 3.497A4.49 4.49 0 0 1 21.75 12a4.49 4.49 0 0 1-1.549 3.397 4.491 4.491 0 0 1-1.307 3.497 4.491 4.491 0 0 1-3.497 1.307A4.49 4.49 0 0 1 12 21.75a4.49 4.49 0 0 1-3.397-1.549 4.49 4.49 0 0 1-3.498-1.306 4.491 4.491 0 0 1-1.307-3.498A4.49 4.49 0 0 1 2.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 0 1 1.307-3.497 4.49 4.49 0 0 1 3.497-1.307Zm7.007 6.387a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                              </svg>
                        <div>
                                <h2 class="text-lg font-semibold text-gray-900">Flexible Payment Options</h2>
                                <p class="text-gray-700">Choose from hourly rates or project-based payments.</p>
                            </div>
                        </div>
                    </div>
                    <Link
                    v-if="canRegister"
                    :href="route('/projects/create')"
                    class="mx-5 my-5 mt-10 px-6 inline-flex items-center py-2 bg-red-600 font-bold border border-transparent rounded-md font-sans text-xs text-white uppercase tracking-widest hover:bg-white-800 focus:bg-gray-800 active:bg-gray-900 focus:outline-none focus:ring-2 hover:bg-black hover:text-white focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-200"
                >Get Started</Link>                
            </div>
            
            
            
                <div class="md:w-1/2 mt-10 md:mt-0 flex justify-center">
                    <div class="relative w-3/4">
                        <img src="/freelancer_working_form_home.png" alt="Freelancer Image" class="">
                        <div class="absolute top-4 right-4 bg-white p-2 rounded-lg shadow text-gray-800 text-sm">
                            <p>Project Status</p>
                            <p class="text-red-600 font-semibold">92% | 4 steps out of 5</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-center dark:bg-gray-900 py-12">
    <div class="max-w-6xl bg-white p-10 rounded-lg shadow-lg">
        <h2 class="text-4xl font-bold text-gray-900 mb-8 text-center">
            Why Choose <span class="text-red-600">JobHunt</span>?
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <div class="flex items-start space-x-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <div>
                    <h3 class="text-2xl font-semibold text-gray-800">Why JobHunt</h3>
                    <p class="mt-2 text-gray-700 text-lg">
                        JobHunt is designed to connect freelancers with trusted clients in a secure, high-paying environment. Our platform makes it easy for professionals to showcase their skills and manage projects with ease.
                    </p>
                </div>
            </div>

            <div class="flex items-start space-x-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <div>
                    <h3 class="text-2xl font-semibold text-gray-800">Our Values and Social Impact</h3>
                    <p class="mt-2 text-gray-700 text-lg">
                        We believe in transparency, inclusivity, and equal opportunities. JobHunt fosters a community where professionals can grow, develop, and make a positive impact.
                    </p>
                </div>
            </div>

            <div class="flex items-start space-x-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                <div>
                    <h3 class="text-2xl font-semibold text-gray-800">Our Advantage Over <span class="text-green-600 font-bold">Fiverr</span></h3>
                    <ul class="mt-2 text-gray-700 text-lg list-disc ml-6">
                        <li><strong>Quality Focus:</strong> JobHunt prioritizes long-term projects and quality over quick gigs.</li>
                        <li><strong>Transparent Pricing:</strong> No hidden fees, making budgeting simple.</li>
                        <li><strong>Lower Fees:</strong> Freelancers keep more of their earnings.</li>
                        <li><strong>For Complex Projects:</strong> Ideal for larger tasks needing collaboration.</li>
                        <li><strong>Professional Community:</strong> Connecting top-tier professionals and clients.</li>
                    </ul>
                </div>
            </div>
            
            <div class="flex items-start space-x-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>

                <div>
                    <h3 class="text-2xl font-semibold text-gray-800">Our Advantage Over <span class="text-blue-500 font-bold">Freelancer</span></h3>
                    <ul class="mt-2 text-gray-700 text-lg list-disc ml-6">
                        <li><strong>User-Friendly Interface:</strong> JobHunt offers a simple, intuitive way to manage projects.</li>
                        <li><strong>Secure Platform:</strong> Built on trust with vetted clients and freelancers.</li>
                        <li><strong>No Contests:</strong> Direct matching without excessive competitions.</li>
                        <li><strong>Long-Term Focus:</strong> Encourages lasting collaborations over one-off gigs.</li>
                        <li><strong>Fair Reviews:</strong> Objective system protecting all professionals.</li>
                    </ul>
                </div>
            </div>
            


        </div>
    </div>
</div>
        </div>
    
        <div class="bg-red-600 py-12">
            <div class="max-w-6xl mx-auto px-4">
              <h1 class="text-4xl font-semibold text-white text-center mb-10">Popular Services</h1>
        
              <div class="relative flex items-center">
                <button @click="scrollLeft" class="absolute left-0 z-10 p-2 bg-white rounded-full shadow-lg">
                  ❮
                </button>
        
                <div ref="carousel" class="flex overflow-x-auto space-x-6 pb-4 scrollbar-hide mx-16 no-scrollbar">
                  <div class="card bg-white w-72 shadow-xl rounded-lg flex-shrink-0 transform transition-transform duration-300 hover:opacity-90">
                    <figure>
                      <img src="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp" alt="Web Development" class="rounded-t-lg" />
                    </figure>
                    <div class="card-body">
                      <h2 class="card-title text-red-600 text-xl font-bold">Web Development</h2>
                      <p class="text-gray-700">Create stunning and responsive websites tailored to your needs.</p>
                    </div>
                  </div>
        
                  <div class="card bg-white w-72 shadow-xl rounded-lg flex-shrink-0 transform transition-transform duration-300 hover:opacity-90">
                    <figure>
                      <img src="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp" alt="Logo Design" class="rounded-t-lg" />
                    </figure>
                    <div class="card-body">
                      <h2 class="card-title text-red-600 text-xl font-bold">Logo Design</h2>
                      <p class="text-gray-700">Get custom logo designs that perfectly represent your brand.</p>
                    </div>
                  </div>
        
                  <div class="card bg-white w-72 shadow-xl rounded-lg flex-shrink-0 transform transition-transform duration-300 hover:opacity-90">
                    <figure>
                      <img src="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp" alt="WordPress" class="rounded-t-lg" />
                    </figure>
                    <div class="card-body">
                      <h2 class="card-title text-red-600 text-xl font-bold">WordPress</h2>
                      <p class="text-gray-700">Build and manage your website with powerful WordPress solutions.</p>
                    </div>
                  </div>
        
                  <div class="card bg-white w-72 shadow-xl rounded-lg flex-shrink-0 transform transition-transform duration-300 hover:opacity-90">
                    <figure>
                      <img src="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp" alt="Voice Over" class="rounded-t-lg" />
                    </figure>
                    <div class="card-body">
                      <h2 class="card-title text-red-600 text-xl font-bold">Voice Over</h2>
                      <p class="text-gray-700">Professional voice-over services to bring your project to life.</p>
                    </div>
                  </div>
        
                  <div class="card bg-white w-72 shadow-xl rounded-lg flex-shrink-0 transform transition-transform duration-300 hover:opacity-90">
                    <figure>
                      <img src="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp" alt="Video Editing" class="rounded-t-lg" />
                    </figure>
                    <div class="card-body">
                      <h2 class="card-title text-red-600 text-xl font-bold">Video Editing</h2>
                      <p class="text-gray-700">Expert video editing to create compelling visual content.</p>
                    </div>
                  </div>
                </div>
        
                <button @click="scrollRight" class="absolute right-0 z-10 p-2 bg-white rounded-full shadow-lg">
                  ❯
                </button>
              </div>
            </div>
          </div>
        
        <div class="flex flex-col items-center p-10 bg-gray-100">
            <h2 class="text-3xl font-semibold text-gray-800 mb-8">Make it all happen with <span class="text-red-600">JobHunt</span></h2>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-16 w-full max-w-4xl">
                <div class="flex flex-col items-center text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path d="M4.5 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM14.25 8.625a3.375 3.375 0 1 1 6.75 0 3.375 3.375 0 0 1-6.75 0ZM1.5 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM17.25 19.128l-.001.144a2.25 2.25 0 0 1-.233.96 10.088 10.088 0 0 0 5.06-1.01.75.75 0 0 0 .42-.643 4.875 4.875 0 0 0-6.957-4.611 8.586 8.586 0 0 1 1.71 5.157v.003Z" />
                      </svg>
                      
                    <h3 class="text-lg font-semibold text-gray-800 my-4">Access top talent</h3>
                    <p class="text-gray-600">Find professionals across multiple categories to meet your needs.</p>
                </div>
        
                <div class="flex flex-col items-center text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-2.625 6c-.54 0-.828.419-.936.634a1.96 1.96 0 0 0-.189.866c0 .298.059.605.189.866.108.215.395.634.936.634.54 0 .828-.419.936-.634.13-.26.189-.568.189-.866 0-.298-.059-.605-.189-.866-.108-.215-.395-.634-.936-.634Zm4.314.634c.108-.215.395-.634.936-.634.54 0 .828.419.936.634.13.26.189.568.189.866 0 .298-.059.605-.189.866-.108.215-.395.634-.936.634-.54 0-.828-.419-.936-.634a1.96 1.96 0 0 1-.189-.866c0-.298.059-.605.189-.866Zm2.023 6.828a.75.75 0 1 0-1.06-1.06 3.75 3.75 0 0 1-5.304 0 .75.75 0 0 0-1.06 1.06 5.25 5.25 0 0 0 7.424 0Z" clip-rule="evenodd" />
                      </svg>
                      
                    <h3 class="text-lg font-semibold text-gray-800 my-4">Easy matching</h3>
                    <p class="text-gray-600">Enjoy a user-friendly experience that connects you with the right freelancer.</p>
                </div>
        
                <div class="flex flex-col items-center text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                      </svg>
                      
                    <h3 class="text-lg font-semibold text-gray-800 my-4">Quality work</h3>
                    <p class="text-gray-600">Get projects completed on time and within budget.</p>
                </div>
        
                <div class="flex flex-col items-center text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path d="M10.464 8.746c.227-.18.497-.311.786-.394v2.795a2.252 2.252 0 0 1-.786-.393c-.394-.313-.546-.681-.546-1.004 0-.323.152-.691.546-1.004ZM12.75 15.662v-2.824c.347.085.664.228.921.421.427.32.579.686.579.991 0 .305-.152.671-.579.991a2.534 2.534 0 0 1-.921.42Z" />
                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v.816a3.836 3.836 0 0 0-1.72.756c-.712.566-1.112 1.35-1.112 2.178 0 .829.4 1.612 1.113 2.178.502.4 1.102.647 1.719.756v2.978a2.536 2.536 0 0 1-.921-.421l-.879-.66a.75.75 0 0 0-.9 1.2l.879.66c.533.4 1.169.645 1.821.75V18a.75.75 0 0 0 1.5 0v-.81a4.124 4.124 0 0 0 1.821-.749c.745-.559 1.179-1.344 1.179-2.191 0-.847-.434-1.632-1.179-2.191a4.122 4.122 0 0 0-1.821-.75V8.354c.29.082.559.213.786.393l.415.33a.75.75 0 0 0 .933-1.175l-.415-.33a3.836 3.836 0 0 0-1.719-.755V6Z" clip-rule="evenodd" />
                      </svg>                      
                    <h3 class="text-lg font-semibold text-gray-800 my-4">Pay when satisfied</h3>
                    <p class="text-gray-600">Only release payments when you’re happy with the work.</p>
                </div>
            </div>
        
            <Link
            v-if="canRegister"
            :href="route('/projects/create')"
            class="mt-10 px-6 inline-flex py-3 items-center bg-red-600 font-bold border border-transparent rounded-md font-sans text-xs text-white uppercase tracking-widest hover:bg-black focus:bg-gray-800 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-200"
        >Get Started</Link>   
        </div>

        <div class="bg-white-600 py-24 sm:py-32">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
              <dl class="grid grid-cols-1 gap-x-8 gap-y-16 text-center lg:grid-cols-3">
                <div class="mx-auto flex max-w-xs flex-col gap-y-4">
                  <dt class="text-base leading-7 text-gray-600">Job Applications every 24 hours</dt>
                  <dd class="order-first text-3xl font-semibold tracking-tight text-red-600 sm:text-5xl">1000+</dd>
                </div>
                <div class="mx-auto flex max-w-xs flex-col gap-y-4">
                  <dt class="text-base leading-7 text-gray-600">Earned every month</dt>
                  <dd class="order-first text-3xl font-semibold tracking-tight text-red-600 sm:text-5xl">200,000$</dd>
                </div>
                <div class="mx-auto flex max-w-xs flex-col gap-y-4">
                  <dt class="text-base leading-7 text-gray-600">New users every Year</dt>
                  <dd class="order-first text-3xl font-semibold tracking-tight text-red-600 sm:text-5xl">46,000</dd>
                </div>
              </dl>
            </div>
          </div>
        
<br>
<br>
<br>
<br>
<br>


            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                <div class="max-md:hidden flex w-full my-10 max-w-3xl mx-auto mt-400 scroll-smooth">
                    <h1 class="rounded-md flex-end my-10 text-white text-7xl font-semibold bg-red-600 py-3 px-3">Over 2000+ projects</h1>
                </div>

                <div class="max-md:hidden flex w-full my-10 max-w-3xl mx-auto mt-400">
                    <p class="flex-end my-10 font-geistmono">With over 2000+ job advertisements available, your next career move could be just a click away. Whether you're seeking a new challenge, looking to advance your career, or embarking on a fresh start, our extensive collection of job listings offers a diverse range of opportunities to suit your skills, interests, and ambitions.</p>
                </div>

                <div class="max-md:hidden flex w-full my-10 max-w-3xl mx-auto mt-400">
                    <p class="flex-start my-10 font-geistmono">Over 1000 seasoned professionals spanning the globe unite in expertise to illuminate this topic. From diverse backgrounds and corners of the world, our collective knowledge converges to offer a comprehensive perspective. With a wealth of experience, insights, and cultural nuances, our global network brings unparalleled depth to the table. Together, we navigate the intricacies of this subject, drawing from a mosaic of perspectives to provide holistic understanding and innovative solutions. Our collaboration transcends borders, empowering us to tackle challenges with agility and creativity. As a community of professionals, we stand ready to enrich discourse, drive progress, and shape the future</p>
                    </div>

                    <div className="max-md:hidden flex w-90 max-w-3xl my-10 mx-auto mt-400">
                        <h1 className="flex-end my-10  text-white bg-red-600 text-7xl font-semibold rounded py-3 px-3 ">1000+ professionals all around the globe</h1>
                    </div>
                    
                    <div className="max-md:hidden flex my-10  w-90 max-w-3xl mx-auto mt-400">
                        <h1 className=" flex-start text-white text-7xl font-semibold my-10 py-3 px-3 rounded bg-red-600">5000+ potetial clients visit our platform daily</h1>
                    </div>
        
                    <div className="max-md:hidden flex my-10 w-90 max-w-3xl mx-auto mt-400">
                        <p className="flex-end my-10 font-geistmono">Join our platform and tap into a vast pool of potential clients, with over 5000 individuals visiting our platform daily. Whether you're a freelancer, entrepreneur, or business owner, our platform offers unparalleled exposure to a diverse audience actively seeking products, services, and partnerships. With such high daily traffic, your business gains visibility and reach, allowing you to showcase your offerings to a wide range of prospective clients. From small-scale projects to large-scale collaborations, our platform facilitates meaningful connections between businesses and clients, driving growth and success.</p>
                    </div>

                </div>
            </div>

            <div class="flex justify-center mt-16 px-6 sm:items-center sm:justify-between">
                <div class="text-center text-sm text-gray-500 dark:text-gray-400 sm:text-start">
                    <div class="flex items-center gap-4">
    
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="butt" stroke-linejoin="bevel"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        <a href="https://github.com/13DPAPIMA">Created by Artjoms Pimanovs </a> 
                          
                    </div>
                 
                </div>

                <div class="ms-4 text-center text-sm text-gray-500 dark:text-gray-400 sm:text-end sm:ms-0">
                   All rights are secured
                </div>
            </div>
        </div>
</template>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}
@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}

</style>