<template>
    <div class="container mx-auto p-6 bg-white rounded-lg shadow-md mt-5">
        <div v-if="task" class="space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold">{{ task.title }}</h2>
                <div class="flex space-x-2">
                    <button
                        @click="editTask"
                        class="bg-blue-500 text-white p-2 rounded-full hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400"
                    >
                        <i class="fas fa-edit"></i>
                    </button>
                    <button
                        @click="deleteTask"
                        class="bg-red-500 text-white p-2 rounded-full hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400"
                    >
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            <p class="text-gray-500">{{ task.description }}</p>
            <span
                :class="{
                    'text-green-500': task.status === 'completed',
                    'text-red-500': task.status === 'pending'
                }"
                class="text-sm font-semibold"
            >
                {{ task.status }}
            </span>
            <div class="mt-4">
                <button
                    @click="goBack"
                    class="bg-gray-500 text-white py-2 px-4 rounded-lg shadow-sm hover:bg-gray-600"
                >
                    Back to Task List
                </button>
            </div>
        </div>
        <div v-else class="text-center text-gray-500">Loading...</div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';

const route = useRoute();
const router = useRouter();
const task = ref(null);

const fetchTaskDetails = async () => {
    try {
        const response = await axios.get(`/api/tasks/${route.params.id}`);
        task.value = response.data;
    } catch (error) {
        console.error('Error fetching task details:', error);
    }
};

onMounted(fetchTaskDetails);

const goBack = () => {
    router.push('/'); // Navigate back to the task list
};

const deleteTask = async () => {
    try {
        await axios.delete(`/api/tasks/${task.value.id}`);
        router.push('/'); // Navigate back to the task list after deletion
    } catch (error) {
        console.error('Error deleting task:', error);
    }
};

const editTask = () => {
    router.push({ name: 'TaskForm', params: { id: task.value.id } }); // Navigate to edit page
};
</script>

<style scoped>
</style>
