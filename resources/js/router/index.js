import { createRouter, createWebHistory } from 'vue-router';
import TaskList from '../views/TaskList.vue';
import TaskForm from '../views/TaskForm.vue';
import TaskItem from '../views/TaskItem.vue';

const routes = [
    { path: '/', name: 'TaskList', component: TaskList },
    { path: '/create-task', name: 'TaskForm', component: TaskForm },
    { path: '/task/:id', name: 'TaskItem', component: TaskItem, props: true },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
