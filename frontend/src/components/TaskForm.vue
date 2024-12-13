<template>
    <div class="flex justify-center items-center min-h-screen bg-gray-50">
        <div class="w-full max-w-xl p-6 bg-white rounded-lg shadow-lg">
            <h2 class="text-3xl font-semibold text-gray-800 text-center mb-6">
                {{ isEdit ? 'Edit Task' : 'Create a New Task' }}
            </h2>

            <!-- Success Message -->
            <div v-if="successMessage" class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg shadow-sm">
                <p>{{ successMessage }}</p>
            </div>

            <!-- Loading Spinner -->
            <div v-if="loading" class="text-center py-4">
                <span class="text-gray-500">Saving task...</span>
            </div>

            <!-- Task Form -->
            <form v-if="!loading" @submit.prevent="saveTask" class="space-y-6">
                <!-- Task Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Task Title</label>
                    <input
                        id="title"
                        v-model="title"
                        type="text"
                        class="mt-2 block w-full rounded-md border-2 border-gray-300 p-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                        required
                    />
                </div>

                <!-- Task Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Task Description</label>
                    <textarea
                        id="description"
                        v-model="description"
                        rows="5"
                        class="mt-2 block w-full rounded-md border-2 border-gray-300 p-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                    ></textarea>
                </div>

                <!-- Task Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Task Status</label>
                    <select
                        id="status"
                        v-model="status"
                        class="mt-2 block w-full rounded-md border-2 border-gray-300 p-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                        required
                    >
                        <option value="" disabled>Select Status</option>
                        <option value="pending">Pending</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="w-full mt-4 inline-flex justify-center rounded-md border border-transparent bg-blue-500 py-3 px-6 text-sm font-semibold text-white shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    {{ isEdit ? 'Update Task' : 'Save Task' }}
                </button>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import axios from 'axios';

// Form fields and loading state
const title = ref('');
const description = ref('');
const status = ref('');
const successMessage = ref('');
const loading = ref(false);

// Edit check and task ID from route
const route = useRoute();
const router = useRouter();
const isEdit = ref(false);
const taskId = route.params.id || null;

onMounted(async () => {
    if (taskId) {
        isEdit.value = true;
        try {
            const { data } = await axios.get(`/api/tasks/${taskId}`);
            title.value = data.title;
            description.value = data.description;
            status.value = data.status;
        } catch (error) {
            console.error('Error fetching task:', error);
        }
    }
});

const saveTask = async () => {
    loading.value = true;
    try {
        if (isEdit.value) {
            await axios.put(`/api/tasks/${taskId}`, {
                title: title.value,
                description: description.value,
                status: status.value,
            });
            successMessage.value = 'Task updated successfully!';
        } else {
            await axios.post('/api/tasks', {
                title: title.value,
                description: description.value,
                status: status.value,
            });
            successMessage.value = 'Task created successfully!';
        }

        title.value = '';
        description.value = '';
        status.value = '';

        setTimeout(() => {
            router.push('/');
        }, 2000);
    } catch (error) {
        console.error('Error saving task:', error);
    } finally {
        loading.value = false;
    }
};
</script>

<style scoped>
/* Optional: Add custom styles if necessary */
</style>
