<template>
    <div class="flex justify-center items-center min-h-screen bg-gray-100">
        <div class="w-1/2 p-6 bg-white rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold mb-6 text-center">Create a New Task</h2>

            <div v-if="successMessage" class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg shadow">
                <p>{{ successMessage }}</p>
            </div>

            <form @submit.prevent="saveTask" class="space-y-4">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Task Title</label>
                    <input
                        id="title"
                        v-model="title"
                        type="text"
                        class="mt-1 block w-full rounded-md border-2 border-gray-300 p-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                        required
                    />
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Task Description</label>
                    <textarea
                        id="description"
                        v-model="description"
                        rows="5"
                        class="mt-1 block w-full rounded-md border-2 border-gray-300 p-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                    ></textarea>
                </div>
                <button
                    type="submit"
                    class="inline-flex justify-center rounded-md border border-transparent bg-green-500 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500"
                >
                    Save Task
                </button>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

const title = ref('');
const description = ref('');
const successMessage = ref('');

const router = useRouter();

const saveTask = async () => {
    try {
        await axios.post('/api/tasks', { title: title.value, description: description.value });

        successMessage.value = 'Task saved successfully! Redirecting...';

        title.value = '';
        description.value = '';

        setTimeout(() => {
            router.push('/');
        }, 2000);

    } catch (error) {
        console.error('Error saving task:', error);
    }
};
</script>
