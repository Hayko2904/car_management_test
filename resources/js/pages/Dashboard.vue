<template>
    <div class="md:container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Car List</h1>
        <button @click="addCar" class="mb-4 px-4 py-2 bg-blue-500 text-white font-semibold rounded hover:bg-blue-600">
            Add Car
        </button>
        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden">
            <!-- Table Headers (Make, Model, Year, etc.) -->
            <thead class="bg-gray-100 text-gray-700">
            <tr>
                <th class="px-6 py-3 text-left font-medium uppercase tracking-wider cursor-pointer hover:bg-gray-200" @click="sort('make')">Make</th>
                <th class="px-6 py-3 text-left font-medium uppercase tracking-wider cursor-pointer hover:bg-gray-200" @click="sort('model')">Model</th>
                <th class="px-6 py-3 text-left font-medium uppercase tracking-wider cursor-pointer hover:bg-gray-200" @click="sort('year')">Year</th>
                <th class="px-6 py-3 text-left font-medium uppercase tracking-wider cursor-pointer hover:bg-gray-200" @click="sort('price')">Price</th>
                <th class="px-6 py-3 text-left font-medium uppercase tracking-wider cursor-pointer hover:bg-gray-200" @click="sort('description')">Description</th>
                <th class="px-6 py-3 text-left font-medium uppercase tracking-wider">Image</th>
                <th class="px-6 py-3 text-left font-medium uppercase tracking-wider cursor-pointer hover:bg-gray-200" @click="sort('created_at')">Created at</th>
                <th class="px-6 py-3 text-left font-medium uppercase tracking-wider">Action</th>
            </tr>
            </thead>
            <tbody class="text-gray-700">
            <tr v-for="car in sortedCars" :key="car.id" class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">{{ car.make }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ car.model }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ car.year }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ car.price }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ car.description }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <img :src="car.image" alt="Car Image" class="w-16 h-16 object-cover rounded-md border border-gray-300 shadow-sm" />
                </td>
                <td class="px-6 py-4 whitespace-nowrap">{{ dayjs(car.created_at).format('DD-MM-YYYY') }}</td>
                <td class="px-6 py-4 whitespace-nowrap flex space-x-4">
                    <button @click="editCar(car.id)" class="text-blue-600 hover:text-blue-800 font-semibold transition duration-150 ease-in-out">Edit</button>
                    <button @click="deleteCar(car.id)" class="text-red-600 hover:text-red-800 font-semibold transition duration-150 ease-in-out">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>


        <!-- Pagination Controls -->
        <div v-if="pagination.per_page !== pagination.total" class="mt-4">
            <button
                @click="fetchCars(pagination.current_page - 1)"
                :disabled="pagination.current_page === 1"
                class="cursor-pointer px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400"
            >
                Previous
            </button>

            <button
                @click="fetchCars(pagination.current_page + 1)"
                :disabled="pagination.current_page === pagination.last_page"
                class="cursor-pointer px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 ml-2"
            >
                Next
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { apiClient } from '../api.js';
import dayjs from "dayjs";

const router = useRouter();
const cars = ref([]);
const sortColumn = ref('make');
const sortOrder = ref('asc');
const pagination = ref({});

const fetchCars = async (page = 1) => {
    try {
        const response = await apiClient.get('cars?page=' + page);

        cars.value = response.data.data || [];
        pagination.value = response.data.meta;
    } catch (error) {
        console.error('Error fetching cars:', error);
    }
};

onMounted(async () => {
    if (!localStorage.getItem('user') && !localStorage.getItem('token')) {
        await router.push('/login')
    }

    await fetchCars(); // Fetch initial page of cars
});

const sort = (column) => {
    if (sortColumn.value === column) {
        sortOrder.value = sortOrder.value === 'asc' ? 'desc' : 'asc';
    } else {
        sortColumn.value = column;
        sortOrder.value = 'asc';
    }
};

const sortedCars = computed(() => {
    return [...cars.value].sort((a, b) => {
        const aValue = a[sortColumn.value];
        const bValue = b[sortColumn.value];

        if (aValue < bValue) return sortOrder.value === 'asc' ? -1 : 1;
        if (aValue > bValue) return sortOrder.value === 'asc' ? 1 : -1;
        return 0;
    });
});

const editCar = (id) => {
    router.push(`/edit/${id}`);
};

const deleteCar = async (id) => {
    try {
        await apiClient.delete(`cars/${id}`);
        cars.value = cars.value.filter(car => car.id !== id);
        await fetchCars()
    } catch (error) {
        console.error('Error deleting car:', error);
    }
};

const addCar = () => {
    router.push('/add-car');
};
</script>

<style scoped>
/* Add any scoped styles here */
</style>
