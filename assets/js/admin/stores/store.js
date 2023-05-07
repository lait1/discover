import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        message: ''
    },
    mutations: {
        setMessage(state, message) {
            state.message = message
        }
    },
    actions: {
        async fetchMessage({ commit }) {
            commit('setMessage', 'Gamargjoba!')
        }
    }
})