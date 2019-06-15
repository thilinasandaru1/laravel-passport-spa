import VueRouter from "vue-router";

let routes = [
    {
        path: "/",
        component: require("./views/Home.vue").default
    },
    {
        path: "/about",
        component: require("./views/About.vue").default
    },
    {
        path: "/login",
        component: require("./views/Login.vue").default
    },
    {
        path: "/dashboard",
        component: require("./views/Dashboard.vue").default
    }
];

export default new VueRouter({
    routes
});
