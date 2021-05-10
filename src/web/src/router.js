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

Vue.use(Router);

const router = new Router({
	mode: "history",
	base: process.env.BASE_URL,
	routes: [
		{
			path: '*',
			redirect: '/login'
		},
		{
			path: '/login',
			name: 'Login',
			component: () => import('./views/Login.vue')
		},
		{
			path: '/:page',
			name: 'dashboard',
			meta: {
				requiresAuth: true
			},
			component: () => import('./views/Crm/App.vue'),
			redirect: { name: 'dashboard' },
			children: [
				{
					path: 'dashboard',
					component: Dashboard,
					name: 'dashboard'
				},
				{
					path: 'board',
					component: Board,
					name: 'board'
				},
				{
					path: 'lead/:id',
					component: Lead,
					name: 'lead'
				},
				{
					path: 'profile',
					component: Profile,
					name: 'profile'
				},
				{
					path: 'users',
					component: Users,
					name: 'users',
					meta: {
						requiresAdmin: true
					}
				},
				{
					path: 'pages',
					component: Pages,
					name: 'pages',
					meta: {
						requiresAdmin: true
					}
				},
				{
					path: 'developer',
					component: Developer,
					name: 'developer',
					meta: {
						requiresAdmin: true
					}
				},
				{
					path: 'data',
					component: Data,
					name: 'data',
					meta: {
						requiresAdmin: true
					}
				},
			]
		},
	],
	scrollBehavior() {
		return {x: 0, y: 0};
	}
});

router.beforeEach((to, from, next) => {
	if (to.matched.some(record => record.meta.requiresAuth)) {
		if (store.state.authenticated) {
			next()
		}else {
			next({
				name: 'Login',
			})
		}
	} else if(to.matched.some(record => record.meta.requiresAdmin)) {
		next();
	} else {
		next();
	}
  });

export default router;