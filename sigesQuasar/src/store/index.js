import Vue from 'vue';
import Vuex from 'vuex';

import auth from './auth';
import materials from './materials';
import plans from './plans';
import companies from './companies';
import orders from './orders';
import providers from './providers';
import cart from './cart';
import user from './user';
import users from './users';
import employees from './employees';

Vue.use(Vuex);

export default function () {
  const Store = new Vuex.Store({
    modules: {
      auth,
      materials,
      plans,
      companies,
      orders,
      providers,
      cart, 
      user,
      users,
      employees
    }
  });

  return Store;
}
