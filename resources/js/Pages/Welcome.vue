<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Link,Head, useForm, usePage } from "@inertiajs/vue3";


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

    <div
        class="min-h-screen bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white"
    >
        <div v-if="canLogin" class="-mx-3 flex flex-1 justify-end" >
            <Link
                v-if="$page.props.auth.user"
                :href="route('login')"
                class=" mx-5 my-5 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                >Addvertisments</Link
            >

            <template v-else>
               
                <Link
                v-if="canRegister"
                :href="route('/projects/create')"
                class="mx-5 my-5 max-md:hidden inline-flex items-center px-4 py-2 mx-3 bg-red-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-200"
                >
                Start Hiring</Link>

                <Link
                    :href="route('login')"
                    class="mx-5 my-5 font-inter font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                    >Sign in</Link
                >
 
                <Link
                v-if="canRegister"
                :href="route('register')"
                class="mx-6 my-5 ms-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                >Join</Link>
          
            
            </template>
            
        </div>
        
        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <div class="flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0,0,256,256">
                <g fill="#e61616" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(5.12,5.12)"><path d="M20,4c-0.35684,0.00005 -0.68663,0.19023 -0.8654,0.49906c-0.17878,0.30883 -0.17946,0.68952 -0.00178,0.99899l23,40c0.18349,0.31948 0.52778,0.5122 0.89605,0.50158c0.36827,-0.01062 0.70088,-0.22285 0.86567,-0.55236l4.04688,-8.09375c0.74294,-1.48837 0.69781,-3.25311 -0.12305,-4.70117l-14.79883,-26.11719c-0.88668,-1.5648 -2.55006,-2.53516 -4.34961,-2.53516zM21.72852,6h6.94141c1.08245,0 2.07606,0.58029 2.60938,1.52148l14.79883,26.11719c0.49314,0.86994 0.52128,1.92663 0.07422,2.82227l-3.21484,6.42578zM15.99609,11c-0.35259,0.00145 -0.67836,0.18845 -0.85742,0.49219l-10,17c-0.18216,0.30915 -0.18474,0.6922 -0.00676,1.00378c0.17799,0.31158 0.50925,0.50392 0.86808,0.50403h21c0.36627,-0.00003 0.70321,-0.20028 0.87832,-0.52198c0.1751,-0.3217 0.16034,-0.71338 -0.03847,-1.02099l-11,-17c-0.18503,-0.28613 -0.50301,-0.45837 -0.84375,-0.45703zM16.04102,13.9043l9.12109,14.0957h-17.41406zM3,35c-0.35465,-0.00037 -0.68298,0.18711 -0.8629,0.49273c-0.17992,0.30563 -0.18453,0.68368 -0.0121,0.9936l5,9c0.17671,0.31745 0.51168,0.5141 0.875,0.51367h28c0.35465,0.00037 0.68298,-0.18711 0.8629,-0.49273c0.17992,-0.30563 0.18453,-0.68368 0.0121,-0.9936l-5,-9c-0.17671,-0.31745 -0.51168,-0.5141 -0.875,-0.51367zM4.70117,37h25.71094l3.88672,7h-25.71094z"></path></g></g>
                </svg>
            </div>

            <div class="mt-16">

                <div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-2xl">
                    <div class="md:flex">
                     
                      <div class="p-8">
                        <div class="uppercase tracking-wide text-sm text-indigo-500 font-semibold">Company retreats</div>
                        <a href="#" class="block mt-1 text-lg leading-tight font-medium text-black hover:underline">Incredible accommodation for your team</a>
                        <p class="mt-2 text-slate-500">Looking to take your team away on a retreat to enjoy awesome food and take in some sunshine? We have a list of places to do just that.</p>
                      </div>
                    </div>
                  </div>
                  
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                  <div className="max-md:hidden flex w-90 my-10 max-w-3xl mx-auto mt-400 scroll-smooth">
                      <h1 className="flex-end my-10  text-red-600 text-7xl font-semibold my-10">Over 2000+ projects</h1>
                    </div>
          
                    <div className="max-md:hidden flex w-90 my-10 max-w-3xl mx-auto mt-400 ">
                       <p className="flex-end my-10 ">With over 2000+ job advertisements available, your next career move could be just a click away. Whether you're seeking a new challenge, looking to advance your career, or embarking on a fresh start, our extensive collection of job listings offers a diverse range of opportunities to suit your skills, interests, and ambitions.</p>
                    </div>
                   
                    <div className=" max-md:hidden flex w-90 max-w-3xl my-10 mx-auto mt-400 ">
                        <p className="flex-start my-10">Over 1000 seasoned professionals spanning the globe unite in expertise to illuminate this topic. From diverse backgrounds and corners of the world, our collective knowledge converges to offer a comprehensive perspective. With a wealth of experience, insights, and cultural nuances, our global network brings unparalleled depth to the table. Together, we navigate the intricacies of this subject, drawing from a mosaic of perspectives to provide holistic understanding and innovative solutions. Our collaboration transcends borders, empowering us to tackle challenges with agility and creativity. As a community of professionals, we stand ready to enrich discourse, drive progress, and shape the future</p>
                    </div>

                    <div className="max-md:hidden flex w-90 max-w-3xl my-10 mx-auto mt-400">
                        <h1 className="flex-end my-10  text-red-600 text-7xl font-semibold my-10">1000+ professionals all around the globe</h1>
                    </div>
                    
                    <div className="max-md:hidden flex my-10  w-90 max-w-3xl mx-auto mt-400">
                        <h1 className=" flex-start text-red-600 text-7xl font-semibold my-10">5000+ potetial clients visit our platform daily</h1>
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