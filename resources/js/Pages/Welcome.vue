<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Link, Head, usePage } from "@inertiajs/vue3";
import GuestLayout from "@/Layouts/GuestLayout.vue";

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
                    class="mx-5 my-5 inline-flex items-center px-4 py-2 bg-red-700 border border-transparent rounded-md font-sans text-xs text-white uppercase tracking-widest hover:bg-red-600 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-200"
                >Start Hiring</Link>

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
                <svg xmlns="http://www.w3.org/2000/svg" x="50px" y="0px" width="100" height="100" viewBox="0,0,256,256">
                    <g fill="#e61616" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal">
                        <g transform="scale(5.12,5.12)">
                            <path d="M20,4c-0.35684,0.00005 -0.68663,0.19023 -0.8654,0.49906c-0.17878,0.30883 -0.17946,0.68952 -0.00178,0.99899l23,40c0.18349,0.31948 0.52778,0.5122 0.89605,0.50158c0.36827,-0.01062 0.70088,-0.22285 0.86567,-0.55236l4.04688,-8.09375c0.74294,-1.48837 0.69781,-3.25311 -0.12305,-4.70117l-14.79883,-26.11719c-0.88668,-1.5648 -2.55006,-2.53516 -4.34961,-2.53516zM21.72852,6h6.94141c1.08245,0 2.07606,0.58029 2.60938,1.52148l14.79883,26.11719c0.49314,0.86994 0.52128,1.92663 0.07422,2.82227l-3.21484,6.42578zM15.99609,11c-0.35259,0.00145 -0.67836,0.18845 -0.85742,0.49219l-10,17c-0.18216,0.30915 -0.18474,0.6922 -0.00676,1.00378c0.17799,0.31158 0.50925,0.50392 0.86808,0.50403h21c0.36627,-0.00003 0.70321,-0.20028 0.87832,-0.52198c0.1751,-0.3217 0.16034,-0.71338 -0.03847,-1.02099l-11,-17c-0.18503,-0.28613 -0.50301,-0.45837 -0.84375,-0.45703zM16.04102,13.9043l9.12109,14.0957h-17.41406zM3,35c-0.35465,-0.00037 -0.68298,0.18711 -0.8629,0.49273c-0.17992,0.30563 -0.18453,0.68368 -0.0121,0.9936l5,9c0.17671,0.31745 0.51168,0.5141 0.875,0.51367h28c0.35465,0.00037 0.68298,-0.18711 0.8629,-0.49273c0.17992,-0.30563 0.18453,-0.68368 0.0121,-0.9936l-5,-9c-0.17671,-0.31745 -0.51168,-0.5141 -0.875,-0.51367zM4.70117,37h25.71094l3.88672,7h-25.71094z"></path>
                        </g>
                    </g>
                </svg>
            </div>


            <div class="flex justify-center content-center items-center bg-white-600 w-full h-screen max-xl:hidden">
                <div class="text-center">
                    <h1 class="px-4 py-2 bg-red-600 max-md:hidden text-white text-8xl font-geist font-bold rounded-xl">JobHunt</h1>
                    <h1 class="max-md:hidden my-4 text-red-600 text-4xl font-geist font-semibold" >You Found The Right Freelance Platform</h1>
                    <h1 class="max-md:hidden my-4 text-red-600 text-4xl font-geist font-semibold">You will find the best high-paying projects on our platform</h1>
                    <p class="max-md:hidden my-4 text-red-600 text-4xl font-geist font-semibold">The best opportunity for your career</p>
                </div>
            </div>

            
            <div class="flex w-full h-screen bg-white-600">
                <div class="w-1/2 overflow-hidden">
                    <img src="/freelancer_photo-removebg.png" alt="Freelancer Image" class="w-full h-full object-cover">
                </div>
            
                <div class="flex items-center justify-center w-1/2">
                    <div class="text-center w-full">
                        <h1 class="max-md:hidden text-red-600 text-8xl font-bold">№ 1 In The Freelance Platform in Baltics</h1>
                        <br><br>
                        <h1 class="max-md:hidden my-4 text-red-600 text-4xl font-geist">JobHunt - Easy Peasy Lemon Squeezy</h1>
                        <h1 class="max-md:hidden my-4 text-red-600 text-4xl font-geist">JobHunt Will Provide Safe Payments</h1>
                        <p class="max-md:hidden my-4 text-red-600 text-4xl font-geist">JobHunt will Help You to find Colleagues</p>
                        <p class="max-md:hidden my-4 text-red-600 text-4xl font-geist">JobHunt is a polnaja imba</p>
                    </div>
                </div>
            </div>
            <br>
            <br>
            <br>
            <div class="content-center my-10">
                <div class="flex flex-row items-center justify-center">
                <h1 class="font-bold text-2xl mx-5 opacity-75">Trusted by: </h1>
                </div>
            </div>

            <div class="content-center my-10">
                <div class="flex flex-row items-center justify-center">
                <svg class="mx-5 opacity-75" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 256 315"><path d="M213.803 167.03c.442 47.58 41.74 63.413 42.197 63.615c-.35 1.116-6.599 22.563-21.757 44.716c-13.104 19.153-26.705 38.235-48.13 38.63c-21.05.388-27.82-12.483-51.888-12.483c-24.061 0-31.582 12.088-51.51 12.871c-20.68.783-36.428-20.71-49.64-39.793c-27-39.033-47.633-110.3-19.928-158.406c13.763-23.89 38.36-39.017 65.056-39.405c20.307-.387 39.475 13.662 51.889 13.662c12.406 0 35.699-16.895 60.186-14.414c10.25.427 39.026 4.14 57.503 31.186c-1.49.923-34.335 20.044-33.978 59.822M174.24 50.199c10.98-13.29 18.369-31.79 16.353-50.199c-15.826.636-34.962 10.546-46.314 23.828c-10.173 11.763-19.082 30.589-16.678 48.633c17.64 1.365 35.66-8.964 46.64-22.262"/></svg>
                <svg class="mx-5 opacity-75" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 256 199"><path fill="#5865f2" d="M216.856 16.597A208.502 208.502 0 0 0 164.042 0c-2.275 4.113-4.933 9.645-6.766 14.046c-19.692-2.961-39.203-2.961-58.533 0c-1.832-4.4-4.55-9.933-6.846-14.046a207.809 207.809 0 0 0-52.855 16.638C5.618 67.147-3.443 116.4 1.087 164.956c22.169 16.555 43.653 26.612 64.775 33.193A161.094 161.094 0 0 0 79.735 175.3a136.413 136.413 0 0 1-21.846-10.632a108.636 108.636 0 0 0 5.356-4.237c42.122 19.702 87.89 19.702 129.51 0a131.66 131.66 0 0 0 5.355 4.237a136.07 136.07 0 0 1-21.886 10.653c4.006 8.02 8.638 15.67 13.873 22.848c21.142-6.58 42.646-16.637 64.815-33.213c5.316-56.288-9.08-105.09-38.056-148.36M85.474 135.095c-12.645 0-23.015-11.805-23.015-26.18s10.149-26.2 23.015-26.2c12.867 0 23.236 11.804 23.015 26.2c.02 14.375-10.148 26.18-23.015 26.18m85.051 0c-12.645 0-23.014-11.805-23.014-26.18s10.148-26.2 23.014-26.2c12.867 0 23.236 11.804 23.015 26.2c0 14.375-10.148 26.18-23.015 26.18"/></svg>
                <svg class="mx-5 opacity-75" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 256 259.3"><path fill="#9edcf2" d="M200.9 199.8c0 13.9-32.2 25.1-71.9 25.1s-71.9-11.3-71.9-25.1c0-13.9 32.2-25.1 71.9-25.1s71.9 11.2 71.9 25.1m0 0"/><defs><path id="logosGithubOctocat0" d="M98.1 244.8c1.6 7.5 5.5 11.9 9.4 14.5h41.1c5-3.4 10.1-9.8 10.1-21.8v-31s.6-7.7 7.7-10.2c0 0 4.1-2.9-.3-4.5c0 0-19.5-1.6-19.5 14.4v23.6s.8 8.7-3.8 12.3v-29.2s.3-9.3 5.1-12.8c0 0 3.2-5.7-3.8-4.2c0 0-13.4 1.9-14 17.6l-.3 30h-3.2l-.3-30c-.6-15.6-14-17.6-14-17.6c-7-1.6-3.8 4.2-3.8 4.2c4.8 3.5 5.1 12.8 5.1 12.8v29.5c-4.6-3.3-3.8-12.6-3.8-12.6v-23.6c0-16-19.5-14.4-19.5-14.4c-4.5 1.6-.3 4.5-.3 4.5c7 2.6 7.7 10.2 7.7 10.2v21.7z"/></defs><clipPath id="logosGithubOctocat1"><use href="#logosGithubOctocat0"/></clipPath><path fill="#7dbce7" d="M200.9 199.8c0 13.9-32.2 25.1-71.9 25.1s-71.9-11.3-71.9-25.1c0-13.9 32.2-25.1 71.9-25.1s71.9 11.2 71.9 25.1m0 0" clip-path="url(#logosGithubOctocat1)"/><path fill="#9edcf2" d="m46.9 125.9l-2.1 7.2s-.5 2.6 1.9 3.1c2.6-.1 2.4-2.5 2.2-3.2zm0 0"/><path fill="#010101" d="m255.8 95.6l.2-.9c-21.1-4.2-42.7-4.3-55.8-3.7c2.1-7.7 2.8-16.7 2.8-26.6c0-14.3-5.4-25.7-14-34.3c1.5-4.9 3.5-15.8-2-29.7c0 0-9.8-3.1-32.1 11.8c-8.7-2.2-18-3.3-27.3-3.3c-10.2 0-20.5 1.3-30.2 3.9C74.4-2.9 64.3.3 64.3.3c-6.6 16.5-2.5 28.8-1.3 31.8c-7.8 8.4-12.5 19.1-12.5 32.2c0 9.9 1.1 18.8 3.9 26.5c-13.2-.5-34-.3-54.4 3.8l.2.9c20.4-4.1 41.4-4.2 54.5-3.7c.6 1.6 1.3 3.2 2 4.7c-13 .4-35.1 2.1-56.3 8.1l.3.9c21.4-6 43.7-7.6 56.6-8c7.8 14.4 23 23.8 50.2 26.7c-3.9 2.6-7.8 7-9.4 14.5c-5.3 2.5-21.9 8.7-31.9-8.5c0 0-5.6-10.2-16.3-11c0 0-10.4-.2-.7 6.5c0 0 6.9 3.3 11.7 15.6c0 0 6.3 21 36.4 14.2V177s-.6 7.7-7.7 10.2c0 0-4.2 2.9.3 4.5c0 0 19.5 1.6 19.5-14.4v-23.6s-.8-9.4 3.8-12.6v38.8s-.3 9.3-5.1 12.8c0 0-3.2 5.7 3.8 4.2c0 0 13.4-1.9 14-17.6l.3-39.3h3.2l.3 39.3c.6 15.6 14 17.6 14 17.6c7 1.6 3.8-4.2 3.8-4.2c-4.8-3.5-5.1-12.8-5.1-12.8v-38.5c4.6 3.6 3.8 12.3 3.8 12.3v23.6c0 16 19.5 14.4 19.5 14.4c4.5-1.6.3-4.5.3-4.5c-7-2.6-7.7-10.2-7.7-10.2v-31c0-12.1-5.1-18.5-10.1-21.8c29-2.9 42.9-12.2 49.3-26.8c12.7.3 35.6 1.9 57.4 8.1l.3-.9c-21.7-6.1-44.4-7.7-57.3-8.1c.6-1.5 1.1-3 1.6-4.6c13.4-.5 35.1-.5 56.3 3.7m0 0"/><path fill="#f5ccb3" d="M174.6 63.7c6.2 5.7 9.9 12.5 9.9 19.8c0 34.4-25.6 35.3-57.2 35.3S70.1 114 70.1 83.5c0-7.3 3.6-14.1 9.8-19.7c10.3-9.4 27.7-4.4 47.4-4.4s37-5.1 47.3 4.3m0 0"/><path fill="#fff" d="M108.3 85.3c0 9.5-5.3 17.1-11.9 17.1c-6.6 0-11.9-7.7-11.9-17.1c0-9.5 5.3-17.1 11.9-17.1c6.6-.1 11.9 7.6 11.9 17.1m0 0"/><path fill="#af5c51" d="M104.5 85.5c0 6.3-3.6 11.4-7.9 11.4c-4.4 0-7.9-5.1-7.9-11.4c0-6.3 3.6-11.4 7.9-11.4c4.3 0 7.9 5.1 7.9 11.4m0 0"/><path fill="#fff" d="M172.2 85.3c0 9.5-5.3 17.1-11.9 17.1c-6.6 0-11.9-7.7-11.9-17.1c0-9.5 5.3-17.1 11.9-17.1c6.5-.1 11.9 7.6 11.9 17.1m0 0"/><path fill="#af5c51" d="M168.3 85.5c0 6.3-3.6 11.4-7.9 11.4c-4.4 0-7.9-5.1-7.9-11.4c0-6.3 3.6-11.4 7.9-11.4c4.4 0 7.9 5.1 7.9 11.4m-37.8 15c0 1.6-1.3 3-3 3c-1.6 0-3-1.3-3-3s1.3-3 3-3c1.6 0 3 1.3 3 3m-9.9 7.5c-.2-.5.1-1 .6-1.2c.5-.2 1 .1 1.2.6c.8 2.2 2.8 3.6 5.1 3.6s4.3-1.5 5.1-3.6c.2-.5.7-.8 1.2-.6c.5.2.8.7.6 1.2c-1 2.9-3.8 4.9-6.9 4.9c-3.1 0-5.9-2-6.9-4.9m0 0"/><path fill="#c4e5d9" d="M54.5 121.6c0 .8-.9 1.4-2.1 1.4c-1.1 0-2.1-.6-2.1-1.4c0-.8.9-1.4 2.1-1.4c1.2 0 2.1.6 2.1 1.4m5.8 3.2c0 .8-.9 1.4-2.1 1.4c-1.1 0-2.1-.6-2.1-1.4c0-.8.9-1.4 2.1-1.4c1.2 0 2.1.6 2.1 1.4m3.5 4.2c0 .8-.9 1.4-2.1 1.4c-1.1 0-2.1-.6-2.1-1.4c0-.8.9-1.4 2.1-1.4c1.2-.1 2.1.6 2.1 1.4m3.2 4.8c0 .8-.9 1.4-2.1 1.4c-1.1 0-2.1-.6-2.1-1.4c0-.8.9-1.4 2.1-1.4c1.2-.1 2.1.6 2.1 1.4m3.5 4.4c0 .8-.9 1.4-2.1 1.4c-1.1 0-2.1-.6-2.1-1.4c0-.8.9-1.4 2.1-1.4c1.2 0 2.1.6 2.1 1.4m4.8 3.9c0 .8-.9 1.4-2.1 1.4c-1.1 0-2.1-.6-2.1-1.4c0-.8.9-1.4 2.1-1.4c1.2-.1 2.1.6 2.1 1.4m6.7 2.5c0 .8-.9 1.4-2.1 1.4c-1.1 0-2.1-.6-2.1-1.4c0-.8.9-1.4 2.1-1.4c1.2 0 2.1.6 2.1 1.4m6.7 0c0 .8-.9 1.4-2.1 1.4c-1.1 0-2.1-.6-2.1-1.4c0-.8.9-1.4 2.1-1.4c1.2 0 2.1.6 2.1 1.4m6.8-1.1c0 .8-.9 1.4-2.1 1.4c-1.1 0-2.1-.6-2.1-1.4c0-.8.9-1.4 2.1-1.4c1.1 0 2.1.6 2.1 1.4m0 0"/></svg>
                <svg class="mx-5 opacity-75" xmlns="http://www.w3.org/2000/svg" width="3.5em" height="2em" viewBox="0 0 512 168"><path fill="#ff302f" d="m496.052 102.672l14.204 9.469c-4.61 6.79-15.636 18.44-34.699 18.44c-23.672 0-41.301-18.315-41.301-41.614c0-24.793 17.816-41.613 39.308-41.613c21.616 0 32.206 17.193 35.633 26.475l1.869 4.735l-55.692 23.049c4.236 8.348 10.84 12.584 20.183 12.584c9.345 0 15.823-4.61 20.495-11.525M452.384 87.66l37.19-15.45c-2.056-5.17-8.16-8.845-15.45-8.845c-9.281 0-22.176 8.223-21.74 24.295"/><path fill="#20b15a" d="M407.407 4.931h17.94v121.85h-17.94z"/><path fill="#3686f7" d="M379.125 50.593h17.318V124.6c0 30.711-18.128 43.357-39.558 43.357c-20.183 0-32.33-13.58-36.878-24.606l15.885-6.604c2.865 6.79 9.78 14.827 20.993 14.827c13.767 0 22.24-8.535 22.24-24.482v-5.98h-.623c-4.112 4.983-11.961 9.468-21.928 9.468c-20.807 0-39.87-18.128-39.87-41.488c0-23.486 19.063-41.8 39.87-41.8c9.905 0 17.816 4.423 21.928 9.282h.623zm1.245 38.499c0-14.702-9.78-25.417-22.239-25.417c-12.584 0-23.174 10.715-23.174 25.417c0 14.514 10.59 25.042 23.174 25.042c12.46.063 22.24-10.528 22.24-25.042"/><path fill="#ff302f" d="M218.216 88.78c0 23.984-18.688 41.613-41.613 41.613c-22.924 0-41.613-17.691-41.613-41.613c0-24.108 18.689-41.675 41.613-41.675c22.925 0 41.613 17.567 41.613 41.675m-18.19 0c0-14.95-10.84-25.23-23.423-25.23c-12.583 0-23.423 10.28-23.423 25.23c0 14.826 10.84 25.23 23.423 25.23c12.584 0 23.423-10.404 23.423-25.23"/><path fill="#ffba40" d="M309.105 88.967c0 23.984-18.689 41.613-41.613 41.613c-22.925 0-41.613-17.63-41.613-41.613c0-24.108 18.688-41.613 41.613-41.613c22.924 0 41.613 17.443 41.613 41.613m-18.253 0c0-14.95-10.839-25.23-23.423-25.23c-12.583 0-23.423 10.28-23.423 25.23c0 14.826 10.84 25.23 23.423 25.23c12.646 0 23.423-10.466 23.423-25.23"/><path fill="#3686f7" d="M66.59 112.328c-26.102 0-46.534-21.056-46.534-47.158c0-26.101 20.432-47.157 46.534-47.157c14.079 0 24.357 5.544 31.957 12.646l12.522-12.521C100.479 7.984 86.338.258 66.59.258C30.833.259.744 29.414.744 65.17c0 35.758 30.089 64.912 65.846 64.912c19.312 0 33.889-6.354 45.289-18.19c11.711-11.712 15.324-28.158 15.324-41.489c0-4.174-.498-8.472-1.059-11.649H66.59v17.318h42.423c-1.246 10.84-4.672 18.253-9.718 23.298c-6.105 6.168-15.76 12.958-32.705 12.958"/></svg>
                <svg class="mx-5 opacity-75" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24"><path fill="currentColor" d="m16.624 13.92l2.718 2.716l-7.353 7.353l-7.353-7.352l2.717-2.717l4.636 4.66zm4.637-4.636L24 12l-2.715 2.716L18.568 12zm-9.272 0l2.716 2.692l-2.717 2.717L9.272 12zm-9.273 0L5.41 12l-2.692 2.692L0 12zM11.99.012l7.35 7.328l-2.717 2.715L11.99 5.42l-4.636 4.66l-2.717-2.716z"/></svg>
            </div>
        </div>
            <br>
            <br>
            <br>       
            <br>
            <br>
            <br>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 bg-red-600">
            <div class="max-md:hidden flex w-full my-10 max-w-3xl mx-auto mt-400 scroll-smooth">
                <h1 class="my-5 text-white text-4xl font-semibold">Popular Services</h1>
            </div>
        </div>
        <div class="flex flex-row content-center items-center justify-center max-md:flex-col bg-red-600">
            <div class="max-w-sm mx-2 mb-4 rounded overflow-hidden shadow-lg transform transition-transform duration-300 hover:scale-105">
                <div class=" px-6 py-4 bg-white text-red-600">
                    <h1 class="font-bold text-4xl mb-1">AI Artist</h1>
                </div>
            </div>
            <div class="max-w-sm mx-2 mb-4 rounded overflow-hidden shadow-lg transform transition-transform duration-300 hover:scale-105">
                <div class="px-6 py-4 bg-white text-red-600">
                    <h1 class="font-bold text-4xl mb-1">Logo Design</h1>
                </div>
            </div>
            <div class="max-w-sm mx-2 mb-4 rounded overflow-hidden shadow-lg transform transition-transform duration-300 hover:scale-105">
                <div class="px-6 py-4 bg-white text-red-600">
                    <h1 class="font-bold text-4xl mb-1">Word Press</h1>
                </div>
            </div>
            <div class="max-w-sm mx-2 mb-4 rounded overflow-hidden shadow-lg transform transition-transform duration-300 hover:scale-105">
                <div class="px-6 py-4 bg-white text-red-600">
                    <h1 class="font-bold text-4xl mb-1">Voice Over</h1>
                </div>
            </div>
            <div class="max-w-sm mx-2 mb-4 rounded overflow-hidden shadow-lg transform transition-transform duration-300 hover:scale-105">
                <div class=" px-6 py-4 bg-white text-red-600">
                    <div class="font-bold text-xl mb-2 font-geist">Video Editor</div>
                    <p class="text-base font-geist">The best quality on market</p>
                </div>
            </div>
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
                    <p class="flex-end my-10">With over 2000+ job advertisements available, your next career move could be just a click away. Whether you're seeking a new challenge, looking to advance your career, or embarking on a fresh start, our extensive collection of job listings offers a diverse range of opportunities to suit your skills, interests, and ambitions.</p>
                </div>

                <div class="max-md:hidden flex w-full my-10 max-w-3xl mx-auto mt-400">
                    <p class="flex-start my-10">Over 1000 seasoned professionals spanning the globe unite in expertise to illuminate this topic. From diverse backgrounds and corners of the world, our collective knowledge converges to offer a comprehensive perspective. With a wealth of experience, insights, and cultural nuances, our global network brings unparalleled depth to the table. Together, we navigate the intricacies of this subject, drawing from a mosaic of perspectives to provide holistic understanding and innovative solutions. Our collaboration transcends borders, empowering us to tackle challenges with agility and creativity. As a community of professionals, we stand ready to enrich discourse, drive progress, and shape the future</p>
                    </div>

                    <div className="max-md:hidden flex w-90 max-w-3xl my-10 mx-auto mt-400">
                        <h1 className="flex-end my-10  text-white bg-red-600 text-7xl font-semibold my-10 rounded py-3 px-3 ">1000+ professionals all around the globe</h1>
                    </div>
                    
                    <div className="max-md:hidden flex my-10  w-90 max-w-3xl mx-auto mt-400">
                        <h1 className=" flex-start text-white text-7xl font-semibold my-10 py-3 px-3 rounded bg-red-600">5000+ potetial clients visit our platform daily</h1>
                    </div>
        
                    <div className="max-md:hidden flex my-10 w-90 max-w-3xl mx-auto mt-400">
                        <p className="flex-end my-10">Join our platform and tap into a vast pool of potential clients, with over 5000 individuals visiting our platform daily. Whether you're a freelancer, entrepreneur, or business owner, our platform offers unparalleled exposure to a diverse audience actively seeking products, services, and partnerships. With such high daily traffic, your business gains visibility and reach, allowing you to showcase your offerings to a wide range of prospective clients. From small-scale projects to large-scale collaborations, our platform facilitates meaningful connections between businesses and clients, driving growth and success.</p>
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
                    Powered by Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
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