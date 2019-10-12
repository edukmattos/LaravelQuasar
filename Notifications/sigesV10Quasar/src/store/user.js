import Vue from 'vue'
import axios from 'axios'
import { SessionStorage } from 'quasar';
import { CONFIG } from './../config'

const state = {
    companies: []
}

const mutations = {
    mutCompanies (state, payload) {
        state.companies = payload;
    },
    
    updateTask(state, payload) {
        Object.assign(state.tasks[payload.id], payload.updates)        
    },
    deleteTask(state, id) {
        // console.log('DELETED MUTATION')
        Vue.delete(state.tasks, id)
    }
}

const actions = {
    actCompanies({ commit }, payload) {
        commit('mutCompanies', payload)
    },
    XactCompanies (context) {
        // console.log('actCompanies')
        let user = SessionStorage.getItem('user')
        // console.log(user.id)
        axios
            .get(CONFIG.api_url + '/companies/user/' + user.id)
            .then((response) => {
                let payload = response.data.data;
                context.commit('mutCompanies', payload || [])
            })
            .catch(error => {
                console.log('error: ', error.response)
            })            
    },

    updateTask({ commit }, payload) {
        commit('updateTask', payload)
    },
    deleteTask({ commit }, id) {
        commit('deleteTask', id)
    }
}

const getters = {
    companies: (state) => {
        return state.companies;
    }
}

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
}