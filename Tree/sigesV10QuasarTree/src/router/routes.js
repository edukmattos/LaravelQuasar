
const routes = [
  {
    path: '/',
    component: () => import('layouts/Layout.vue'),
    children: [
      { 
        path: '', 
        component: () => import('pages/Home.vue') 
      },
      { 
        path: '/about', 
        component: () => import('pages/About.vue') 
      },
      { 
        path: '/auth', 
        component: () => import('pages/Auth.vue') 
      }
    ]
  },
  {
    path: '/user',
    component: () => import('layouts/Layout.vue'),
    children: [
      {
        path: '/user/activation/:email/:activationCode',
        component: () => import('pages/User/AccountVerify.vue')
      },
      {
        path: '/profile',
        component: () => import('pages/User/Profile.vue')
      },
      {
        path: 'dashboard/',
        name: 'Painel Controle',
        component: () => import('pages/User/Dashboard.vue')
      },
      {
        path: 'companies/',
        name: 'Empresas',
        component: () => import('pages/User/Companies/List.vue')
      },
      {
        path: '/user/companies/:id/show',
        name: 'company-show',
        component: () => import('pages/User/Companies/Show.vue')
      },
      {
        path: '/user/companySectors/',
        name: 'Setores',
        component: () => import('pages/CompanySector/List.vue')
      }
    ]
  },

]

// Always leave this as last one
if (process.env.MODE !== 'ssr') {
  routes.push({
    path: '*',
    component: () => import('pages/Error404.vue')
  })
}

export default routes
