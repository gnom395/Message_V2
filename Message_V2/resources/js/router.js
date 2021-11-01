import vueRouter from 'vue-router';
import Vue from 'vue';

Vue.use(vueRouter);

import Index from "./views/Index";
import Changename from "./views/Changename";
//import User from "./views/User";
import Chat from "./views/Chat";
//import Chat2 from "./views/Chat2";
import UsersWin from "./components/UsersWin";
//import CreatePost from "./views/CreatePost";


const routes = [
    {
        path: "/",
        component: Index
    },
    {
        path: "/changename",
        component: Changename
    },
    {
        path: "/:ug/:id",
        component: Chat,
    },
    {
        path: "/user/:id/:idmes",
        component: Chat
    },
    {
        path: "/chat",
        component: Chat
    },
    {
        path: "/userslist",
        component: UsersWin
    }

];

export default new vueRouter({
    mode: "history",
    routes
});
