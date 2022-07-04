
import { createWebHistory, createRouter } from "vue-router";

import home from "../pages/home.vue";
import SignIn from "../pages/SignIn.vue";
import SignUp from "../pages/SignUp.vue";
import Employee from "../pages/Employee.vue";
import test from "../pages/test.vue";
import sport from "../pages/sport.vue";
import display from "../pages/display.vue";



const routes =[
    {
        name: "home-page",
        path: "/",
        component: home
    },
    {
        name: "signin",
        path: "/signin",
        component: SignIn
    },
    {
        name: "signup",
        path: "/signup",
        component: SignUp
    },
    {
        name: "employee",
        path: "/employee",
        component: Employee
    },
    {
        name: "test-page",
        path: "/test",
        component: test
    },
    {
        name: "sport-page",
        path: "/sport",
        component: sport
    },
    {
        name: "display-page",
        path: "/display",
        component: display
    },




];



const router = createRouter({
    history: createWebHistory(),
    routes: routes,
    scrollBehavior(){
        window.scrollTo(0,0);
    }
});

export default router;