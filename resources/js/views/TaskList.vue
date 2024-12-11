<template>
    <div class="container mx-auto p-6 w-3/5 bg-gray-200 mt-5">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Task List</h1>
            <router-link
                to="/create-task"
                class="bg-green-500 text-white px-4 py-2 rounded shadow hover:bg-green-600"
            >
                + Create Task
            </router-link>
        </div>
        <div v-if="tasks.length === 0" class="text-gray-500">
            No tasks available.
        </div>
        <div v-else>
            <ul>
                <li v-for="task in tasks" :key="task.id" class="mb-6 p-4 bg-white rounded-lg shadow-md">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <h2 class="font-semibold text-xl">{{ task.title }}</h2>
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
                        </div>
                        <div class="flex space-x-2">
                            <button
                                @click="toggleStatus(task)"
                                class="bg-blue-500 text-white p-2 rounded-full hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400"
                            >
                                <i class="fas fa-sync-alt"></i>
                            </button>
                            <button
                                @click="deleteTask(task.id)"
                                class="bg-red-500 text-white p-2 rounded-full hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400"
                            >
                                <i class="fas fa-trash"></i>
                            </button>
                            <router-link
                                :to="{ name: 'TaskItem', params: { id: task.id } }"
                                class="bg-yellow-500 text-white p-2 rounded-full hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                            >
                                <i class="fas fa-eye"></i>
                            </router-link>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const tasks = ref([]);

const fetchTasks = async () => {
    try {
        const response = await axios.get('/api/tasks');
        tasks.value = response.data.data;
    } catch (error) {
        console.error('Error fetching tasks:', error);
    }
};

onMounted(fetchTasks);

const toggleStatus = async (task) => {
    const newStatus = task.status === 'pending' ? 'completed' : 'pending';
    try {
        await axios.put(`/api/tasks/${task.id}`, { status: newStatus });
        fetchTasks();
    } catch (error) {
        console.error('Error toggling task status:', error);
    }
};

const deleteTask = async (id) => {
    try {
        await axios.delete(`/api/tasks/${id}`);
        fetchTasks();
    } catch (error) {
        console.error('Error deleting task:', error);
    }
};
</script>

<style scoped>
</style>
