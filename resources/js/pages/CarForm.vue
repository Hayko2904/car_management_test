<template>
    <div class="mt-8 p-6 max-w-md mx-auto bg-white rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-4 text-center">{{ isEditing ? 'Update Car' : 'Add Car' }}</h1>
        <form @submit.prevent="submit" class="space-y-4">
            <!-- Make -->
            <div>
                <label for="make" class="block text-sm font-medium text-gray-700">Make</label>
                <input v-model="car.make" id="make" name="make" type="text" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"/>
            </div>

            <!-- Model -->
            <div>
                <label for="model" class="block text-sm font-medium text-gray-700">Model</label>
                <input v-model="car.model" id="model" name="model" type="text" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"/>
            </div>

            <!-- Year -->
            <div>
                <label for="year" class="block text-sm font-medium text-gray-700">Year</label>
                <input v-model="car.year" id="year" name="year" type="number" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"/>
            </div>

            <!-- Price -->
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                <input v-model="car.price" id="price" name="price" type="text" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"/>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea v-model="car.description" id="description" name="description" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
            </div>

            <!-- Image -->
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                <input type="file" @change="handleFileChange" id="image" name="image" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"/>
                <img v-if="previewImage" :src="previewImage" alt="Image Preview" class="mt-2 max-w-xs rounded-md border border-gray-300"/>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" class="w-full py-2 px-4 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    {{ isEditing ? 'Update Car' : 'Add Car' }}
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { apiClient } from '../api.js';

const route = useRoute();
const router = useRouter();

const car = ref({
    make: '',
    model: '',
    year: '',
    price: '',
    description: '',
    image: null
});

const previewImage = ref(null);
const isEditing = ref(false);
const fileAdded = ref(false)

onMounted(async () => {
    if (route.params.id) {
        isEditing.value = true;
        try {
            const response = await apiClient.get(`cars/${route.params.id}`);
            car.value = response.data.data;
            previewImage.value = response.data.data.image;
        } catch (error) {
            console.error('Error fetching car:', error);
        }
    }
});

const handleFileChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        car.value.image = file;
        previewImage.value = URL.createObjectURL(file);
        fileAdded.value = true;
    }
};

const submit = async () => {
    try {
        const formData = new FormData();

        for (const key in car.value) {
            if ((key === 'image' && car.value[key] === null) || key === 'image' && !fileAdded.value) {
                continue;
            }
            formData.append(key, car.value[key]);
        }
        if (isEditing.value) {
            formData.append('_method', 'PUT');
            await apiClient.post(`cars/${route.params.id}`, formData);
        } else {
            await apiClient.post('cars', formData);
        }
        await router.push('/home'); // Redirect to car list page
    } catch (error) {
        console.error('Error saving car:', error);
    }
};
</script>
