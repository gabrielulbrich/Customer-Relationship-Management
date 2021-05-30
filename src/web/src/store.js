import Vue from "vue";
import Vuex from "vuex";
import { api } from "@/services.js";
import createPersistedState from "vuex-persistedstate";
Vue.use(Vuex);

const store = new Vuex.Store({
  strict: true,
  state: {
    authenticated: false,
    user: {
      id: "",
      name: "",
      email: "",
      avatar: "",
      profile: {
        code: "",
        name: "",
      },
    },
    page: {
      id: "",
      name: "",
      site: "",
      notification: [{}]
    },
  },
  plugins: [createPersistedState()],
  getters: {
    pageName: state => {
      return state.page.site.split('.')[0]
    },
    isAdmin: state => {
      return state.user.profile.code == 1
    },
    isMaster: state => {
      return state.user.profile.code == 5
    },    
    isUser: state => {
      return state.user.profile.code == 2
    },
    isAnonymous: state => {
      return state.user.profile.code == 3 || state.user.profile.code == 4
    },
    isInactive: state => {
      return state.user.profile.code == 4
    },
    isInApproval: state => {
      return state.user.profile.code == 3
    },
    countNotification: state => {
      return Object.keys(state.page.notification).length;
    },
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
    },
    UPDATE_NOTIFICATION(state, payload) {
      state.page.notification = payload
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
        context.commit("UPDATE_PROFILE", response.data.user.profile);
        context.commit("UPDATE_LOGIN", true);
      })
    },
    me(context) {
      return api.get(`/me`)
      .then(response => {
        context.commit("UPDATE_USER", response.data.user);
        context.commit("UPDATE_PAGE", response.data.page);
        context.commit("UPDATE_PROFILE", response.data.profile);
        context.commit("UPDATE_LOGIN", true);
      });
    },
    updateUser(context, payload){
      return api.put(`/user/update`, payload)
      .then(response => {
        context.commit("UPDATE_USER", response.data)
      })
    },
    refreshToken(context){
      return api.get(`/refresh`)
      .then(response => {
        context.commit("UPDATE_LOGIN", true);
        window.localStorage.token = `Bearer ${response.data.token}`;
      })
    },
  }
});

export default store;