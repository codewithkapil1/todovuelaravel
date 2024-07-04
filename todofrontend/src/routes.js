import ListTodo from "./components/ListTodo.vue";
import FullCalender from "./components/FullCalender.vue";

import { createRouter, createWebHistory } from "vue-router";
// import Update from "./components/Update.vue";

const routes = [
  {
    name: "FullCalender",
    component: FullCalender,
    path: "/",
  },
  {
    name: "ListTodo",
    component: ListTodo,
    path: "/viewtodo",
  },
];
const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
