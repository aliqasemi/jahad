import Login from "../views/Login";
import Vue from "vue";
import VueRouter from "vue-router";
import Main from "../views/Main";
import {isAuthenticated, isGuest} from "./AuthenticateRoute";
import Profile from "../views/Profile";
import Register from "../views/Register";
import Category from "../views/Category/Category";
import Services from "../views/Service/Services";
import AddService from "../views/Service/Add";
import Requirements from "../views/Requirement/Requirements";
import AddRequirement from "../views/Requirement/Add";
import AttachByRequirement from "../views/Attachment/AttachByRequirement";
import AttachByService from "../views/Attachment/AttachByService";

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
    //categories
    {
        path: '/categories',
        name: 'ListCategories',
        component: Category,
        beforeEnter: isAuthenticated,
    },
    //services
    {
        path: '/services',
        name: 'ListServices',
        component: Services,
        beforeEnter: isAuthenticated,
    },
    {
        path: '/services/add',
        name: 'AddService',
        component: AddService,
        beforeEnter: isAuthenticated,
    },
    {
        path: '/services/edit/:service_id',
        name: 'EditService',
        component: AddService,
        beforeEnter: isAuthenticated,
        props: true,
    },
    //requirement
    {
        path: '/requirements',
        name: 'ListRequirements',
        component: Requirements,
        beforeEnter: isAuthenticated,
    },
    {
        path: '/requirements/add',
        name: 'AddRequirement',
        component: AddRequirement,
        beforeEnter: isAuthenticated,
    },
    {
        path: '/requirements/edit/:requirement_id',
        name: 'EditRequirement',
        component: AddRequirement,
        beforeEnter: isAuthenticated,
        props: true,
    },
    //attachment
    {
        path: '/attachment/requirement/:requirement_id',
        name: 'AttachByRequirement',
        component: AttachByRequirement,
        beforeEnter: isAuthenticated,
        props: true,
    },
    {
        path: '/attachment/service/:service_id',
        name: 'AttachByService',
        component: AttachByService,
        beforeEnter: isAuthenticated,
        props: true,
    },
];

export const router = new VueRouter({
    routes,
})
