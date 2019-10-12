import _ from 'lodash'

const state = {
    companySectors: [],
    search: ''
}

const mutations = {
    mutCompanySectors: (state, payload) => {
        // console.log("mutCompanySectors: ", payload)
        state.companySectors = payload
    },
    mutCompanySectorAdd: (state, payload) => {
        state.companySectors.push(payload)
    },
    mutCompanySectorUpdate: (state, payload) => {
        state.companySectors.forEach((companySector, index) => {
            if (companySector.id === payload.id) {
                //console.log(payload)
                //Object.assign(state.companySectors[index], payload.updates)
                //Deleta do state 
                state.companySectors.splice(index, 1)
                
                //Insere no state
                state.companySectors.push(payload)
            }
        })
    },
    mutCompanySectorDestroy: (state, payload) => {
        state.companySectors.forEach((company, index) => {
            if (companySector.id === payload.id) {
                Object.assign(state.companySectors[index], payload.updates)               
            }
        })
    },
    mutSetSearch: (state, value) => {
        state.search = value
    }   
}

const actions = {
    actAuthClear: ({ commit }) => {
        commit('mutAuthClear')
    },
    actCompanySectors: ({ commit }, payload) => {
        commit('mutCompanySectors', payload)
    },
    actCompanySectorAdd: ({ commit }, companySector) => {
        let payload = companySector
        commit('mutCompanySectorAdd', payload)
    },
    actCompanySectorUpdate: ({ commit }, payload) => {
        //console.log(payload)
        commit('mutCompanySectorUpdate', payload)
    },
    actCompanySectorDestroy: ({ commit }, payload) => {
        commit('mutCompanySectorDestroy', payload)
    },
    actSetSearchCompaniesTerms: ({ commit }, value) => {
        commit('mutSetSearch', value)
    }
}

const getters = {
    getCompanySectorsSorted: (state) => {
        return _.orderBy(state.companySectors, 'name')
    },
    getCompanySectorsFiltered: (state, getters) => {
        let CompanySectorsSorted = getters.getCompanySectorsSorted,
            CompanySectorsFiltered = {}
        // console.log('CompanySectorsSorted: ', CompanySectorsSorted)
        if (state.search) {
            Object.keys(CompanySectorsSorted).forEach((key) => {
                // console.log('key: ', key)
                let companySector = CompanySectorsSorted[key],
                companySectorNameLowerCase = companySector.name.toLowerCase(),
                companySectorDescriptionLowerCase = companySector.description.toLowerCase(),
                searchLowerCase = state.search.toLowerCase()
                // console.log(companySectorNameLowerCase.includes(searchLowerCase))
                if (companySectorNameLowerCase.includes(searchLowerCase) || companySectorDescriptionLowerCase.includes(searchLowerCase)) {
                    CompanySectorsFiltered[key] = companySector
                    // console.log(companySector)
                }
            })
            return CompanySectorsFiltered
        }
        return CompanySectorsSorted
    },
    getCompanySectors: (state) => {
        return state.companySectors
    },
    getCompanySectorById: (state) => (id) => {
        // console.log('id: ', id)
        return state.companySectors.find(companySector => companySector.id === id)
    }
}

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
}