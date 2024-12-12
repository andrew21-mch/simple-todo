import { createRouter, createWebHistory } from 'vue-router';
import TaskForm from '../views/TaskForm.vue';
import TaskList from '../views/TaskList.vue';
import TaskItem from '../views/TaskItem.vue';

const routes = [
  {
    path: '/',
    name: 'TaskList',
    component: TaskList,
  },
  {
    path: '/create-task',
    name: 'CreateTask',
    component: TaskForm,
  },
  {
    path: '/edit-task/:id',
    name: 'EditTask',
    component: TaskForm,
    props: true,
  },
  {
    path: '/task/:id',
    name: 'TaskItem',
    component: TaskItem,
    props: true,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
