import Vue from "vue";
import Vuex from "vuex";
import { api } from "@/services.js";
Vue.use(Vuex);

const store = new Vuex.Store({
  strict: true,
  state: {
    authenticated: false,
    usuario: {
      id: "",
      nome: "",
      email: "",
      senha: "",
      site: ""
    },
    usuario_produtos: null
  },
  mutations: {
    UPDATE_LOGIN(state, payload) { 
      state.authenticated = payload;
    },
    UPDATE_USUARIO(state, payload) {
      state.usuario = Object.assign(state.usuario, payload);
    },
  },
  actions: {
    loginUser(context, payload) {
      return api.post(`/login`, {
        email: payload.email,
        password: payload.password
      })
      .then(response => {
        window.localStorage.token = `Bearer ${response.data.token}`;
      })
    },
    getUser(context) {
      return api.get(`/me`)
      .then(response => {
        context.commit("UPDATE_USUARIO", response.data);
        context.commit("UPDATE_LOGIN", true);
      });
    },
    registerUser(context, payload){
      return api.post(`/register`, payload)
      .then(response => {
        context.commit("UPDATE_USUARIO", payload)
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