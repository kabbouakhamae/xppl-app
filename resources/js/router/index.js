
import { createWebHistory, createRouter } from "vue-router";

import Home from "../pages/Home.vue";
import SignIn from "../pages/SignIn.vue";
import SignUp from "../pages/SignUp.vue";
import Employee from "../pages/Employee.vue";
import Permission from "../pages/Permission.vue";
import Annual from "../pages/Annual.vue";
import Transport from "../pages/Transport.vue";
import FuelCons from "../pages/FuelCons.vue";
import FuelReport from "../pages/FuelReport.vue";
import test from "../pages/test.vue";




const routes =[
    {
        name: "Home",
        path: "/",
        component: Home
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
        name: "permission",
        path: "/permiss",
        component: Permission
    },
    {
        name: "annual",
        path: "/annual",
        component: Annual
    },
    {
        name: "transport",
        path: "/transport",
        component: Transport
    },
    {
        name: "fuelcons",
        path: "/fuelcons",
        component: FuelCons
    },
    {
        name: "fuelreport",
        path: "/fuelreport",
        component: FuelReport
    },


    {
        name: "test-page",
        path: "/test",
        component: test
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