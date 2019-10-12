<template>
  <q-page class="q-pa-xs">
    <q-toolbar class="q-pa-xs bg-purple text-white">
      <q-toolbar-title>
        {{ page().title }}
      </q-toolbar-title>
      <q-space />
      <company-search-component />
    </q-toolbar>
    
    <q-pull-to-refresh @refresh="refresh">
      <q-list 
        separator
        bordered>         
        <user-companies-component
          v-for="(company, key) in getAuthUserCompaniesFiltered"
          :key="key"
          :company="company"
          :id="company.id"
          @click="true"
          clickable
          v-ripple>
        </user-companies-component>
      </q-list>
    </q-pull-to-refresh>

    <q-page-sticky 
      position="bottom-right" 
      :offset="[18, 18]">
      <q-btn 
        fab 
        icon="add"
        color="primary" 
        @click="formCompanyNewEdit = true" />
    </q-page-sticky>

    <q-dialog v-model="formCompanyNewEdit">
      <company-new-edit-component @close="formCompanyNewEdit = false" />
    </q-dialog>
  </q-page>
</template>

<script>
  import { mapActions, mapGetters, mapState } from 'vuex'
  import axios from 'axios'
  import { CONFIG } from '../../../config'
  
  export default {
    data() {
      return {
        formCompanyNewEdit: false
      }
    },
    methods: {
      ...mapActions('auth', ['actAuthUserPage']),
      ...mapActions('auth', ['actAuthUserCompanies']),
      ...mapState('auth', ['page']),
      refresh (done) {
        axios.get(CONFIG.api_url + '/myCompanies')
          .then(response => {
            let companies = response.data
            console.log('companies: ', companies)
            this.actAuthUserCompanies(companies)
          })
          .catch(errors => {
            //reject(errors)
            // console.log('errors: ', errors)
            if (errors.response) {
              this.$setErrorsFromResponse(errors.response.data)

              this.$q.notify({
                color: 'negative',
                textColor: 'white',
                message: 'Ops... encontramos alguns problemas !',
                icon: 'warning',
                position: 'bottom-right'
              });
            }  
          })
        done()
      }
    },
    created() {
      this.actAuthUserPage(
        { 
          pageSlug:'company', 
          pageTitle:'Empresas', 
          pageSubTitle:'Informe seu acesso' 
        }
      )
    },    
    computed: {
      ...mapGetters('auth', ['getAuthUserCompaniesFiltered'])
    },
    components: {
      'user-companies-component': require('components/Company/CompanyListComponent.vue').default,
      'company-new-edit-component': require('components/Company/Modals/CompanyNewEditComponent.vue').default,
      'company-search-component': require('components/Company/Tools/SearchComponent.vue').default
    }
  }
</script>

<style>
</style>
