import _ from 'lodash'

const state = {
    clients: [],
    search: '',
    searchLocations: ''
}

const mutations = {
    mutAuthUserCompanyClients: (state, payload) => {
        // console.log("mutAuthUserCompanyClients: ", payload)
        state.clients = payload
    },
    mutAuthUserCompanyClientAdd: (state, payload) => {
        state.clients.push(payload)
        state.clientsTotal++
    },
    mutAuthUserCompanyClientUpdate: (state, payload) => {
        state.clients.forEach((client, index) => {
            if (client.id === payload.id) {
                //console.log(payload)
                //Object.assign(state.clients[index], payload.updates)
                //Deleta do state 
                state.clients.splice(index, 1)
                
                //Insere no state
                state.clients.push(payload)
            }
        })
    },
    mutAuthUserCompanyClientDestroy: (state, payload) => {
        state.clients.forEach((client, index) => {
            if (client.id === payload.id) {
                Object.assign(state.clients[index], payload.updates)               
            }
        })
    },
    mutSetSearch: (state, value) => {
        state.search = value
    },
    mutSetSearchLocations: (state, value) => {
        state.searchLocations = value
    }    
}

const actions = {
    actAuthUserCompanyClients: ({ commit }, payload) => {
        commit('mutAuthUserCompanyClients', payload)
    },
    actAuthUserCompanyClientAdd: ({ commit }, client) => {
        let payload = client
        commit('mutAuthUserCompanyClientAdd', payload)
    },
    actAuthUserCompanyClientUpdate: ({ commit }, payload) => {
        //console.log(payload)
        commit('mutAuthUserCompanyClientUpdate', payload)
    },
    actAuthUserCompanyClientDestroy: ({ commit }, payload) => {
        commit('mutAuthUserCompanyClientDestroy', payload)
    },
    actSetSearch: ({ commit }, value) => {
        commit('mutSetSearch', value)
    },
    actSetSearchLocations: ({ commit }, value) => {
        commit('mutSetSearchLocations', value)
    }
}

const getters = {
    getAuthUserCompanyClientsSorted: (state) => {
        return _.orderBy(state.clients, 'name')
    },
    getAuthUserCompanyClientsFiltered: (state, getters) => {
        let authUserCompanyClientsSorted = getters.getAuthUserCompanyClientsSorted,
            authUserCompanyClientsFiltered = {}
        // console.log('authUserCompanyClientsSorted: ', authUserCompanyClientsSorted)
        if (state.search) {
            Object.keys(authUserCompanyClientsSorted).forEach((key) => {
                // console.log('key: ', key)
                let client = authUserCompanyClientsSorted[key],
                clientNameLowerCase = client.name.toLowerCase(),
                clientFullNameLowerCase = client.full_name.toLowerCase(),
                searchLowerCase = state.search.toLowerCase()
                // console.log(clientNameLowerCase.includes(searchLowerCase))
                if (clientNameLowerCase.includes(searchLowerCase) || clientFullNameLowerCase.includes(searchLowerCase) || client.einssa.includes(searchLowerCase)) {
                    authUserCompanyClientsFiltered[key] = client
                    // console.log(client)
                }
            })
            return authUserCompanyClientsFiltered
        }
        return authUserCompanyClientsSorted
    },
    getAuthUserCompanyClients: (state) => {
        return state.clients
    },
    getAuthUserCompanyClientById: (state) => (id) => {
        // console.log('id: ', id)
        return state.clients.find(client => client.id === id)
    },
    getAuthUserCompanyClientsFilteredTotal: (state) => {
        return state.clients.length
    },

    //Locations - Inicio
    getAuthUserCompanyClientLocationsSorted: (state) => {
       return _.orderBy(state.clients[0].client_locations, 'description')
    },
    getAuthUserCompanyClientLocationsFiltered: (state, getters) => {
        let 
            authUserCompanyClientLocationsSorted = getters.getAuthUserCompanyClientLocationsSorted,
            authUserCompanyClientLocationsFiltered = []
        //console.log('authUserCompanyClientLocationsSorted: ', authUserCompanyClientLocationsSorted)
        if (state.searchLocations) {
            Object.keys(authUserCompanyClientLocationsSorted).forEach((key) => {
                console.log('Sorted: ', authUserCompanyClientLocationsSorted[key])
                let location = authUserCompanyClientLocationsSorted[key],
                locationLine1LowerCase = (location.description).toLowerCase(),
                locationLine2LowerCase = (location.address + ', ' + location.building + ' ' + location.building_comments + ' - ' + location.neighborhood).toLowerCase(),
                locationLine3LowerCase = (location.city + '/' + location.state + ' - CEP: ' + location.zip_code).toLowerCase(),
                locationLine4LowerCase = (location.email).toLowerCase(),
                locationLine5LowerCase = (location.mobile + ', ' + location.phone).toLowerCase(),
                searchLowerCase = state.searchLocations.toLowerCase()
                // console.log(clientNameLowerCase.includes(searchLowerCase))

                if (locationLine1LowerCase.includes(searchLowerCase) || locationLine2LowerCase.includes(searchLowerCase) || locationLine3LowerCase.includes(searchLowerCase) || locationLine4LowerCase.includes(searchLowerCase) || locationLine5LowerCase.includes(searchLowerCase)) {

                    console.log('key: ', key)
                    console.log('Sorted: ', authUserCompanyClientLocationsSorted[key])
                    
                    authUserCompanyClientLocationsFiltered[key] = location
                        console.log("Xlocation: ", location)
                    }
                })

            console.log('Filtered: ', authUserCompanyClientLocationsFiltered)
            return authUserCompanyClientLocationsFiltered
        }
        return authUserCompanyClientLocationsSorted
    }
    //Locations - Fim
}

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
}