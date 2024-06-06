<template>
    <Head title="Projects Information" />
    <AuthenticatedLayout>
      <div class="my-10 max-w-4xl mx-auto bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 sm:p-8">
        <h2 class="text-2xl font-semibold text-gray-900">{{ project.title }}</h2>
        <br>
        <p class="mt-2 text-lg text-gray-800 font-medium">{{ project.description }}</p>
        <div class="mt-6">
          <h3 class="text-xl font-semibold text-gray-900">Details</h3>
          <p><strong>Niche:</strong> {{ project.niche }}</p>
          <p><strong>Completion Date:</strong> {{ project.completion_date }}</p>
          <p><strong>Budget:</strong> ${{ project.budget }}</p>
        </div>
        <br>
        <h3 class="text-xl font-semibold text-gray-900">Average Rating</h3>
        <p v-if="reviews.length > 0" class="text-lg text-gray-800 font-medium">{{ averageRating }}</p>
        <div class="mt-6">
          <h3 class="text-xl font-semibold text-gray-900">Reviews</h3>
          <div v-if="reviews.length === 0" class="mt-2 text-sm text-gray-600">
            No reviews yet.
          </div>
          <ul class="mt-4 space-y-4">
            <li v-for="review in reviews" :key="review.id" class="border-b border-gray-200 pb-4">
              <div class="overflow-hidden text-ellipsis whitespace-nowrap">
                <p class="text-gray-900">{{ review.ReviewText }}</p>
                <p class="text-sm text-gray-600">
                  {{ review.user.name }} (Rating: {{ review.Rating }})
                  <span v-if="auth.user && review.user.id === auth.user.id">
                    <button @click="editReview(review)" class="text-blue-600 hover:text-blue-800 ml-2">Edit</button>
                    <button @click="deleteReview(review)" class="text-red-600 hover:text-red-800 ml-2">Delete</button>
                  </span>
                </p>
              </div>
            </li>
          </ul>
        </div>
        <div class="mt-6">
          <h3 class="text-xl font-semibold text-gray-900">Add a Review</h3>
          <form @submit.prevent="submitReview" class="space-y-4">
            <div>
              <label for="rating" class="block text-sm font-medium text-gray-700">Rating</label>
              <select id="rating" v-model="form.Rating" class="mt-1 block w-full">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
              </select>
            </div>
            <div>
              <label for="ReviewText" class="block text-sm font-medium text-gray-700">Review</label>
              <textarea id="ReviewText" v-model="form.ReviewText" class="mt-1 block w-full"></textarea>
            </div>
            <PrimaryButton type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md" > 
              Post a review
            </PrimaryButton>
            <InputError class="mt-2" :message="form.errors.ReviewText" />  
            <Transition
                  enter-active-class="transition ease-in-out"
                  enter-from-class="opacity-0"
                  leave-active-class="transition ease-in-out"
                  leave-to-class="opacity-0"
                >
                  <p v-if="form.recentlySuccessful" class="ml-4 text-sm text-gray-600">Review posted.</p>
                </Transition>
          </form>
        </div>
      </div>
    </AuthenticatedLayout>
  </template>
  
  <script setup>
import AuthenticatedLayout from './../Layouts/AuthenticatedLayout.vue';
import { useForm, Head, usePage } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';

const { props: pageProps } = usePage();
const { auth } = pageProps;

const props = defineProps({
  project: Object,
  reviews: Array,
  averageRating: String,
});

const form = useForm({
  Rating: '',
  ReviewText: '',
});

const editForm = useForm({
  Rating: '',
  ReviewText: '',
  id: null,
});

const submitReview = () => {
  form.post(route('projects.addReview', props.project.id), {
    onSuccess: () => {
      form.reset();
    },
  });
};

const editReview = (review) => {
  editForm.id = review.id;
  editForm.Rating = review.Rating;
  editForm.ReviewText = review.ReviewText;
};
</script>
  