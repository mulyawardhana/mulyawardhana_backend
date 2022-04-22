//IMPORT SECTION
import Vue from 'vue'
import Router from 'vue-router'
import Home from './pages/Home.vue'
import Login from './pages/Login.vue'
import store from './store.js'
import Setting from './pages/setting/Index.vue'
import SetPermission from './pages/setting/roles/SetPermission.vue'
import IndexArticle from './pages/article/Index.vue'
import DataArticle from './pages/article/Article.vue'
import AddArticle from './pages/article/Add.vue'
import EditArticle from './pages/article/Edit.vue'

Vue.use(Router)

//DEFINE ROUTE
const router = new Router({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home,
            meta: { requiresAuth: true }
        },
        {
            path: '/login',
            name: 'login',
            component: Login
        },
        {
            path: '/setting',
            component: Setting,
            meta: { requiresAuth: true },
            children: [
                {
                    path: 'role-permission',
                    name: 'role.permissions',
                    component: SetPermission,
                    meta: { title: 'Set Permissions' }
                },
            ]
        },
        {
            path: '/article',
            component: IndexArticle,
            children: [
                {
                    path: '',
                    name: 'article.data',
                    component: DataArticle,
                    meta: { title: 'Manage article' }
                },
                {
                    path: 'add',
                    name: 'article.add',
                    component: AddArticle,
                    meta: { title: 'Add New Outlet' }
                },
                {
                    path: 'edit/:id',
                    name: 'article.edit',
                    component: EditArticle,
                    meta: { title: 'Edit Outlet' }
                }
            ]
        }

    ]
});

//Navigation Guards
router.beforeEach((to, from, next) => {
    store.commit('CLEAR_ERRORS')
    if (to.matched.some(record => record.meta.requiresAuth)) {
        let auth = store.getters.isAuth
        if (!auth) {
            next({ name: 'login' })
        } else {
            next()
        }
    } else {
        next()
    }
})

export default router
