import Vue from 'vue'
import Vuex from 'vuex'

import auth from './auth'
import user from './user'
import company_sectors from './company_sectors'

Vue.use(Vuex)

/*
 * If not building with SSR mode, you can
 * directly export the Store instantiation
 */

export default function (/* { ssrContext } */) {
  const Store = new Vuex.Store({
    modules: {
      auth,
      user,
      company_sectors
    },

    // enable strict mode (adds overhead!)
    // for dev mode only
    strict: process.env.DEV
  })

  return Store
}
