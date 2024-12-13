<template>
    <div class="flex justify-center items-center min-h-screen bg-gray-100 p-4">
        <div class="w-full max-w-lg p-6 bg-white rounded-lg shadow-lg">
            <div v-if="task" class="space-y-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold">{{ task.title }}</h2>
                    <div class="flex space-x-2">
                        <button
                            @click="editTask"
                            class="p-2 rounded-full text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        >
                            <i class="fas fa-edit"></i>
                        </button>
                        <button
                            @click="deleteTask"
                            class="p-2 rounded-full text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400"
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
                        class="w-full py-2 px-4 rounded-md bg-gray-500 text-white hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500"
                    >
                        Back to Task List
                    </button>
                </div>
            </div>
            <div v-else class="text-center text-gray-500">Loading...</div>
        </div>
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
        const { data } = await axios.get(`/api/tasks/${route.params.id}`);
        task.value = data;
    } catch (error) {
        console.error('Error fetching task details:', error);
    }
};

onMounted(fetchTaskDetails);

const goBack = () => {
    router.push('/');
};

const deleteTask = async () => {
    try {
        await axios.delete(`/api/tasks/${task.value.id}`);
        router.push('/');
    } catch (error) {
        console.error('Error deleting task:', error);
    }
};

const editTask = () => {
    router.push({ name: 'EditTask', params: { id: task.value.id } });
};
</script>

<style scoped>
/* Custom styles can be added if needed */
</style>
