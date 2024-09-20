<template>
    <Head title="Projects Information" />
    <AuthenticatedLayout>
      <div class="my-10 max-w-4xl mx-auto bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 sm:p-8 ">
        <h2 class="text-2xl font-semibold text-gray-900 overflow-hidden text-ellipsis whitespace-nowrap">{{ project.title }}</h2>
        <br>
        <p class="mt-2 text-lg text-gray-800 font-medium overflow-hidden text-ellipsis whitespace-nowrap">{{ project.description }}</p>
        <div class="mt-6">
          <h3 class="text-xl font-semibold text-gray-900 overflow-hidden text-ellipsis whitespace-nowrap ">Details</h3>
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
              <div v-if="editForm.id === review.ReviewID">
                <div>
                  <label for="editRating" class="block text-sm font-medium">Rating</label>
                  <select id="editRating" v-model="editForm.Rating" class="mt-1 block w-full">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                  </select>
                </div>
                <div>
                  <label for="editReviewText" class="block text-sm font-medium">Review</label>
                  <textarea id="editReviewText" v-model="editForm.ReviewText" class="mt-1 block w-full"></textarea>
                </div>
                <div class="mt-2">
                  <PrimaryButton @click="updateReview" class="bg-blue-600 text-white">
                    Update Review
                  </PrimaryButton>
                  <button @click="cancelEdit" class="text-red-600 hover:text-red-800 ml-2">Cancel</button>
                </div>
              </div>
  
              <!-- Если не в режиме редактирования, показать сам отзыв -->
              <div v-else>
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
              <label for="rating" class="block text-sm font-medium">Rating</label>
              <select id="rating" v-model="form.Rating" class="mt-1 block w-full">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
              </select>
            </div>
            <div>
              <label for="ReviewText" class="block text-sm font-medium">Review</label>
              <textarea id="ReviewText" v-model="form.ReviewText" class="mt-1 block w-full"></textarea>
            </div>
            <PrimaryButton type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md">
              Post a review
            </PrimaryButton>
            <InputError class="mt-2" :message="form.errors.ReviewText" />
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
  form.post(route('reviews.addReview', props.project.id), {
    onSuccess: () => {
      form.reset();
    },
  });
};

const deleteReview = (review) => {
  console.log('deleteReview called with review:', review);
  if (confirm('Are you sure you want to delete this review?')) {
    form.delete(`/reviews/${review.ReviewID}`, {
      onSuccess: () => {
        Inertia.reload({ only: ['reviews', 'averageRating'] });
      },
      onError: (errors) => {
        console.log('Error deleting review:', errors);
      },
    });
  }
};

const cancelEdit = () => {
  editForm.reset();
  editForm.id = null;
};

const editReview = (review) => {
  console.log('editReview called with review:', review);
  editForm.id = review.ReviewID; 
  editForm.Rating = review.Rating;
  editForm.ReviewText = review.ReviewText;
};

const updateReview = () => {
  editForm.post(`/reviews/${editForm.id}/edit`, {
    onSuccess: () => {
      editForm.reset();
      editForm.id = null;
      Inertia.reload({ only: ['reviews', 'averageRating'] });
    },
  });
};

</script>
  