import Vue from 'vue';
import Router from 'vue-router';
import store from "@/store";
import Board from './views/Crm/Board/Board.vue';
import Lead from './views/Crm/Lead/Lead.vue';

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
			path: '/registrar',
			name: 'Register User',
			component: () => import('./views/Register.vue')
		},
		{
			path: '/:page',
			name: 'dashboard',
			meta: {
				requiresAuth: true
			},
			component: () => import('./views/Crm/App.vue'),
			children: [
				{
					path: 'board',
					component: Board,
				},
				{
					path: 'lead/:id',
					component: Lead,
					name: 'lead'
				}
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
	} else {
		next();
	}
  });

export default router;