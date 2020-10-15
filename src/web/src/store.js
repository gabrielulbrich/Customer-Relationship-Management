import Vue from "vue";
import Vuex from "vuex";
import { api } from "@/services.js";
Vue.use(Vuex);

const store = new Vuex.Store({
  strict: true,
  state: {
    authenticated: false,
    user: {
      id: "",
      name: "",
      email: "",
      profile: {
        id: "",
        profile: "",
      },
    },
    page: {
      id: "",
      name: "",
      site: ""
    },
  },
  getters: {
    pageName: state => {
      return state.page.site.split('.')[0]
    }
  },
  mutations: {
    UPDATE_LOGIN(state, payload) { 
      state.authenticated = payload;
    },
    UPDATE_USER(state, payload) {
      state.user = Object.assign(state.user, payload);
    },
    UPDATE_PAGE(state, payload) {
      state.page = Object.assign(state.page, payload);
    },
    UPDATE_PROFILE(state, payload){
      state.user.profile = Object.assign(state.user.profile, payload);
    }
  },
  actions: {
    loginUser(context, payload) {
      return api.post(`/login`, {
        email: payload.email,
        password: payload.password
      })
      .then(response => {
        window.localStorage.token = `Bearer ${response.data.token.original.token}`;
        context.commit("UPDATE_USER", response.data.user);
        context.commit("UPDATE_PAGE", response.data.page);
        context.commit("UPDATE_PROFILE", response.data.profile);
        context.commit("UPDATE_LOGIN", true);
      })
    },
    getUser(context) {
      return api.get(`/me`)
      .then(response => {
        context.commit("UPDATE_USER", response.data.user);
        context.commit("UPDATE_PAGE", response.data.page);
        context.commit("UPDATE_PROFILE", response.data.profile);
        context.commit("UPDATE_LOGIN", true);
      });
    },
    registerUser(context, payload){
      return api.post(`/register`, payload)
      .then(response => {
        context.commit("UPDATE_USER", response)
      })
    },
    refreshToken(context){
      return api.get(`/refresh`)
      .then(response => {
        context.commit("UPDATE_LOGIN", true);
        window.localStorage.token = `Bearer ${response.data.token}`;
      })
    }
  }
});

export default store;