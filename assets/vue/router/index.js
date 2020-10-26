import Vue from "vue";
import VueRouter from "vue-router"
import Dashboard from "../App";

Vue.use(VueRouter);

let router = new VueRouter({
  mode: "history",
  routes: [
    { path: "/dashboard", component: Dashboard, meta: { requiresAuth: true } },
    { path: "*", redirect: "/" }
  ],
});
export default router;