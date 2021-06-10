import Vue from 'vue';
import Router from 'vue-router';
import store from "@/store";
import Dashboard from '@/views/Crm/Dashboard/Dashboard.vue';
import Board from '@/views/Crm/Board/Board.vue';
import Lead from '@/views/Crm/Lead/Lead.vue';
import Profile from '@/views/Crm/Profile/Profile.vue';
import Users from '@/views/Crm/Users/Users.vue';
import Pages from '@/views/Crm/Pages/Pages.vue';
import Developer from '@/views/Crm/Developer/Developer.vue';
import Data from '@/views/Crm/Data/Data.vue';
import RecoverPassword from '@/views/Crm/RecoverPassword/RecoverPassword.vue'

Vue.use(Router);

const router = new Router({
  mode: "history",
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/login',
      name: 'Login',
      component: () => import('./views/Login.vue')
    },
    {
      path: '/recover-password/:token',
      name: 'RecoverPassword',
      component: () => import('./views/Crm/RecoverPassword/RecoverPassword.vue')
    },
    {
      path: '/',
      name: 'dashboard',
      component: () => import('./views/Crm/App.vue'),
      children: [
        {
          path: 'dashboard',
          component: Dashboard,
          name: 'dashboard2',
          meta: {
            requiresAuth: true
          },
        },
        {
          path: 'board',
          component: Board,
          name: 'board',
          meta: {
            requiresAuth: true
          },
        },
        {
          path: 'lead/:id',
          component: Lead,
          name: 'lead',
          meta: {
            requiresAuth: true
          },
        },
        {
          path: 'profile',
          component: Profile,
          name: 'profile',
          meta: {
            requiresAuth: true
          },
        },
        {
          path: 'users',
          component: Users,
          name: 'users',
          meta: {
            requiresAdmin: true,
            requiresAuth: true
          }
        },
        {
          path: 'pages',
          component: Pages,
          name: 'pages',
          meta: {
            requiresAdmin: true,
            requiresAuth: true
          }
        },
        {
          path: 'developer',
          component: Developer,
          name: 'developer',
          meta: {
            requiresAdmin: true,
            requiresAuth: true
          }
        },
        {
          path: 'data',
          component: Data,
          name: 'data',
          meta: {
            requiresAdmin: true,
            requiresAuth: true
          }
        },
      ]
    },
    {
      path: '*',
      redirect: '/login'
    },
  ],
  scrollBehavior() {
    return {x: 0, y: 0};
  }
});

router.beforeEach((to, from, next) => {
  if (!to.meta.requiresAuth || to.meta.requiresAuth  && (localStorage.getItem('token'))) {
      next()
  } else {
    next({
      name: 'Login',
    })
  }
});

export default router;