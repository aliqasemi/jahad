import Login from "../views/Login";
import Vue from "vue";
import VueRouter from "vue-router";
import Main from "../views/Main";

Vue.use(VueRouter)

const routes = [
    {path: '/', component: Main, name: "Main"},
    {path: '/login', component: Login, name: "Login"},
];

export const router = new VueRouter({
    routes,
})
