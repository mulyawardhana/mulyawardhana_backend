import Vue from 'vue'
import Vuex from 'vuex'

//IMPORT MODULE SECTION
import auth from './stores/auth.js'
import user from './stores/user.js'

Vue.use(Vuex)

//DEFINE ROOT STORE VUEX
const store = new Vuex.Store({

    modules: {
        auth,
        user
    },

    state: {

        token: localStorage.getItem('token'),
        errors: []
    },
    getters: {

        isAuth: state => {
            return state.token != "null" && state.token != null
        }
    },
    mutations: {

        SET_TOKEN(state, payload) {
            state.token = payload
        },
        SET_ERRORS(state, payload) {
            state.errors = payload
        },
        CLEAR_ERRORS(state) {
            state.errors = []
        }
    }
})

export default store
