import Login from "../views/Login";
import Vue from "vue";
import VueRouter from "vue-router";
import Main from "../views/Main";
import {isAuthenticated, isGuest} from "./AuthenticateRoute";
import Profile from "../views/Profile";
import Register from "../views/Register";
import Category from "../views/Category/Category";
import Services from "../views/Service/Services";
import Add from "../views/Service/Add";

Vue.use(VueRouter)

const routes = [
    {
        path: '/',
        component: Main,
        name: "Main",
        beforeEnter: isGuest,
    },
    {
        path: '/login',
        component: Login,
        name: "Login",
        beforeEnter: isGuest,
    },
    {
        path: '/register',
        component: Register,
        name: "register",
    },
    {
        path: '/profile',
        name: 'Profile',
        component: Profile,
        beforeEnter: isAuthenticated,
    },
    {
        path: '/categories',
        name: 'ListCategories',
        component: Category,
        beforeEnter: isAuthenticated,
    },
    {
        path: '/services',
        name: 'ListServices',
        component: Services,
        beforeEnter: isAuthenticated,
    },
    {
        path: '/services/add',
        name: 'AddService',
        component: Add,
        beforeEnter: isAuthenticated,
    },
    {
        path: '/services/edit/:service_id',
        name: 'EditService',
        component: Add,
        beforeEnter: isAuthenticated,
        props: true,
    },
];

export const router = new VueRouter({
    routes,
})
