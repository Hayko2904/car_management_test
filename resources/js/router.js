import {createMemoryHistory, createRouter, createWebHistory} from 'vue-router'
import Login from "./pages/Login.vue";
import SignUp from "./pages/SignUp.vue";
import Dashboard from "./pages/Dashboard.vue";
import CarForm from "./pages/CarForm.vue";

const routes = [
    { path: '/home', component: Dashboard },
    { path: '/login', component: Login },
    { path: '/sign-up', component: SignUp },
    { path: '/add-car', component: CarForm },
    { path: '/edit/:id', component: CarForm },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router
