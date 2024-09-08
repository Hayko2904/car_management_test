<script setup>

import { apiClient } from "../api.js";
import { useRouter } from 'vue-router';
import {onMounted} from "vue";

const router = useRouter();

const formData = {
    name: '',
    email: '',
    password: '',
    password_confirmation: ''
}

onMounted(() => {
    localStorage.removeItem('token')
    localStorage.removeItem('user')
})

const submit = () => {
    if (formData.password !== formData.password_confirmation) {
        return
    }

    apiClient.post('sign-up', formData)
        .then(res => {
            localStorage.setItem('token', res.data?.token)
            localStorage.setItem('user', JSON.stringify(res.data?.user))
            router.push({ path: '/home' }).then(() => router.go(0));
        })
}

</script>

<template>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Sign in to your account</h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" @submit.prevent="submit">
                <div>
                    <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Name</label>
                    <div class="mt-2">
                        <input v-model="formData.name" id="name" name="name" type="text" autocomplete="name" required class="p-1 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
                    <div class="mt-2">
                        <input v-model="formData.email" id="email" name="email" type="email" autocomplete="email" required class="p-1 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                    <div class="mt-2">
                        <input v-model="formData.password" id="password" name="password" type="password" autocomplete="current-password" required class="p-1 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium leading-6 text-gray-900">Password confirmation</label>
                    <div class="mt-2">
                        <input v-model="formData.password_confirmation" id="password_confirmation" name="password_confirmation" type="password" autocomplete="current-password" required class="p-1 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div>
                    <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sign in</button>
                </div>
            </form>
        </div>
    </div>
</template>

<style scoped>

</style>
