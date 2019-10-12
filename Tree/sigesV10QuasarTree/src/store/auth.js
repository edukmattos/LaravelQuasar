import _ from 'lodash'
import { SessionStorage } from 'quasar'

const state = {
    user: '',
    access: {
        token: '',
        token_type: '',
        expires_in: ''
    },
    loggedIn: false,
    companies: [],
    searchCompaniesTerms: '',
    companiesTotal: 0,
    companyIn: [],
    companyInSectors: [],
    page: {
        slug: 'home',
        title: 'Inicio',
        subtitle: ''
    },
    settings: []
}

const mutations = {
    mutAuthClear: (state) => {
        state.access.token = '',
        state.access.token_type = '',
        state.access.expires_in = '',
        
        state.loggedIn = false,
        state.user = [],
        state.companies = [],
        state.companiesTotal = 0,
        state.companyIn = [],

        state.page.title = '',
        state.page.subtitle = '',
        
        state.settings = []
    },
    mutAuthUserLoggedIn: (state, value) => {
        state.loggedIn = value
    },
    mutAuthUser: (state, payload) => {
        state.user = payload
    },
    mutAuthUserCompanies: (state, payload) => {
        // console.log("mutAuthUserCompanies: ", payload)
        state.companies = payload
        state.companiesTotal = state.companies.length
    },
    mutAuthUserCompanyAdd: (state, payload) => {
        state.companies.push(payload)
        state.companiesTotal++
    },
    mutAuthUserCompanyUpdate: (state, payload) => {
        state.companies.forEach((company, index) => {
            if (company.id === payload.id) {
                //console.log(payload)
                //Object.assign(state.companies[index], payload.updates)
                //Deleta do state 
                state.companies.splice(index, 1)
                
                //Insere no state
                state.companies.push(payload)
            }
        })
    },
    mutAuthUserCompanyDestroy: (state, payload) => {
        state.companies.forEach((company, index) => {
            if (company.id === payload.id) {
                Object.assign(state.companies[index], payload.updates)               
            }
        })
    },
    mutAuthUserCompanyIn: (state, payload) => {
        state.companyIn = payload
    },
    mutAuthUserCompanyOut: (state) => {
        console.log('companyIn: ')
        state.companyIn = []
    },
    mutAuthUserPage: (state, { pageSlug, pageTitle, pageSubTitle }) => {
        state.page.slug = pageSlug;
        state.page.title = pageTitle;
        state.page.subtitle = pageSubTitle;
    },
    mutSetSearchCompaniesTerms: (state, value) => {
        state.searchCompaniesTerms = value
    }   
}

const actions = {
    actAuthClear: ({ commit }) => {
        commit('mutAuthClear')
    },
    //actAuthUserLoggedIn: ({ commit }, value) => {
    //    commit('mutAuthUserLoggedIn', value)
    //},
    actAuthUserLoggedIn: ({ commit }) => {
        let value = SessionStorage.getItem('loggedIn')
        commit('mutAuthUserLoggedIn', value)
    },
    actAuthUser: ({ commit }, payload) => {
        commit('mutAuthUser', payload)
    },
    actAuthUserCompanies: ({ commit }, payload) => {
        commit('mutAuthUserCompanies', payload)
    },
    actAuthUserCompanyAdd: ({ commit }, company) => {
        let payload = company
        commit('mutAuthUserCompanyAdd', payload)
    },
    actAuthUserCompanyUpdate: ({ commit }, payload) => {
        //console.log(payload)
        commit('mutAuthUserCompanyUpdate', payload)
    },
    actAuthUserCompanyDestroy: ({ commit }, payload) => {
        commit('mutAuthUserCompanyDestroy', payload)
    },
    actAuthUserCompanyIn: ({ commit }, payload) => {
        commit('mutAuthUserCompanyIn', payload)
    },
    actAuthUserCompanyOut: ({ commit }) => {
        commit('mutAuthUserCompanyOut')
    },
    actAuthUserPage: ({ commit }, pageSlug, pageTitle, pageSubTitle) => {
        commit('mutAuthUserPage', pageSlug, pageTitle, pageSubTitle )
    },
    actSetSearchCompaniesTerms: ({ commit }, value) => {
        commit('mutSetSearchCompaniesTerms', value)
    }
}

const getters = {
    getAuthUserCompaniesSorted: (state) => {
        return _.orderBy(state.companies, 'name')
    },
    getAuthUserCompaniesFiltered: (state, getters) => {
        let authUserCompaniesSorted = getters.getAuthUserCompaniesSorted,
            authUserCompaniesFiltered = {}
        // console.log('authUserCompaniesSorted: ', authUserCompaniesSorted)
        if (state.searchCompaniesTerms) {
            Object.keys(authUserCompaniesSorted).forEach((key) => {
                // console.log('key: ', key)
                let company = authUserCompaniesSorted[key],
                companyNameLowerCase = company.name.toLowerCase(),
                companyFullNameLowerCase = company.full_name.toLowerCase(),
                searchCompaniesTermsLowerCase = state.searchCompaniesTerms.toLowerCase()
                // console.log(companyNameLowerCase.includes(searchCompaniesTermsLowerCase))
                if (companyNameLowerCase.includes(searchCompaniesTermsLowerCase) || companyFullNameLowerCase.includes(searchCompaniesTermsLowerCase) || company.einssa.includes(searchCompaniesTermsLowerCase)) {
                    authUserCompaniesFiltered[key] = company
                    // console.log(company)
                }
            })
            return authUserCompaniesFiltered
        }
        return authUserCompaniesSorted
    },
    getAuthUserCompanies: (state) => {
        return state.companies
    },
    getAuthUserCompanyById: (state) => (id) => {
        // console.log('id: ', id)
        return state.companies.find(company => company.id === id)
    },
    getAuthUserCompaniesTotal: (state) => {
        return state.companiesTotal
    },
    getAuthUser: (state) => {
        return state.user
    },
    //getAuthUserLoggedIn: (state) => {
    //    return state.loggedIn
    //},
    getAuthUserLoggedIn: (state) => {
        return state.loggedIn
        //return SessionStorage.getItem('loggedIn')
    },
    //getAuthUserPage: (state) => {
    //    return state.page
    //}
}

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
}