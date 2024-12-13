<template>
    <div class="container mx-auto p-6 bg-white shadow-md rounded-lg mt-5 w-2/3">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Task List</h1>
        <router-link
          to="/create-task"
          class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 focus:outline-none"
        >
          + Create Task
        </router-link>
      </div>

      <!-- Filter Bar -->
      <div class="flex justify-start space-x-4 mb-6">
        <button
          @click="filterTasks('all')"
          :class="{
            'bg-blue-500 text-white': filter === 'all',
            'bg-gray-300 text-gray-700': filter !== 'all'
          }"
          class="px-4 py-2 rounded-lg shadow hover:bg-blue-600 focus:outline-none"
        >
          All
        </button>
        <button
          @click="filterTasks('pending')"
          :class="{
            'bg-blue-500 text-white': filter === 'pending',
            'bg-gray-300 text-gray-700': filter !== 'pending'
          }"
          class="px-4 py-2 rounded-lg shadow hover:bg-blue-600 focus:outline-none"
        >
          Pending
        </button>
        <button
          @click="filterTasks('completed')"
          :class="{
            'bg-blue-500 text-white': filter === 'completed',
            'bg-gray-300 text-gray-700': filter !== 'completed'
          }"
          class="px-4 py-2 rounded-lg shadow hover:bg-blue-600 focus:outline-none"
        >
          Completed
        </button>
      </div>

      <!-- Task List -->
      <div v-if="tasks.length === 0" class="text-gray-500">
        No tasks available.
      </div>
      <div v-else>
        <ul>
          <li
            v-for="task in filteredTasks"
            :key="task.id"
            class="mb-6 p-4 bg-white rounded-lg shadow-md border border-gray-200"
          >
            <div class="flex items-center justify-between">
              <div class="flex-1">
                <h2 class="font-semibold text-xl text-gray-900">{{ task.title }}</h2>
                <p class="text-gray-600">{{ task.description }}</p>
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
                  class="bg-blue-500 text-white p-2 rounded-full shadow hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400"
                >
                  <i class="fas fa-sync-alt"></i>
                </button>
                <button
                  @click="deleteTask(task.id)"
                  class="bg-red-500 text-white p-2 rounded-full shadow hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400"
                >
                  <i class="fas fa-trash"></i>
                </button>
                <router-link
                  :to="{ name: 'TaskItem', params: { id: task.id } }"
                  class="bg-yellow-500 text-white p-2 rounded-full shadow hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                >
                  <i class="fas fa-eye"></i>
                </router-link>
              </div>
            </div>
          </li>
        </ul>

        <!-- Pagination Controls -->
        <div class="flex justify-center space-x-2 mt-6">
          <button
            @click="fetchTasks(currentPage - 1)"
            :disabled="currentPage === 1"
            class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg shadow hover:bg-gray-400 focus:outline-none"
          >
            Previous
          </button>
          <span class="text-gray-700 px-4 py-2">{{ currentPage }}</span>
          <button
            @click="fetchTasks(currentPage + 1)"
            :disabled="currentPage === lastPage"
            class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg shadow hover:bg-gray-400 focus:outline-none"
          >
            Next
          </button>
        </div>
      </div>
    </div>
  </template>

  <script setup>
  import { ref, computed, onMounted } from 'vue';
  import axios from '../axios';

  const tasks = ref([]); // Holds the list of tasks
  const filter = ref('all'); // Tracks the current filter
  const currentPage = ref(1); // Tracks the current page number
  const lastPage = ref(1); // Tracks the total number of pages

  // Fetch tasks from the backend
  const fetchTasks = async (page = 1) => {
    try {
      // Ensure page stays within valid range
      if (page < 1 || page > lastPage.value) return;
      const response = await axios.get(`/api/tasks?page=${page}`);
      tasks.value = response.data.data; // Assign tasks to data property
      currentPage.value = response.data.current_page; // Update current page
      lastPage.value = response.data.last_page; // Update total pages
    } catch (error) {
      console.error('Error fetching tasks:', error);
    }
  };

  // Filter tasks based on the selected filter
  const filteredTasks = computed(() => {
    if (filter.value === 'all') {
      return tasks.value;
    }
    return tasks.value.filter((task) => task.status === filter.value);
  });

  // Set the filter
  const filterTasks = (status) => {
    filter.value = status; // Update filter value
  };

  // Toggle the status of a task
  const toggleStatus = async (task) => {
    const newStatus = task.status === 'pending' ? 'completed' : 'pending'; // Determine new status
    try {
      await axios.put(`/api/tasks/${task.id}`, { status: newStatus }); // Update task status
      fetchTasks(currentPage.value); // Refresh the task list
    } catch (error) {
      console.error('Error toggling task status:', error);
    }
  };

  // Delete a task
  const deleteTask = async (id) => {
    try {
        // delete the task and refetch
      await axios.delete(`/api/tasks/${id}`);
      fetchTasks(currentPage.value);
    } catch (error) {
      console.error('Error deleting task:', error);
    }
  };

  // Fetch tasks on component mount
  onMounted(() => fetchTasks());
  </script>

  <style scoped>
  </style>
