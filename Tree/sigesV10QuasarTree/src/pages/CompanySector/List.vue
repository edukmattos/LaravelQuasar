<template>
  <q-page class="q-pa-xs">
    <q-toolbar class="q-pa-xs bg-purple text-white">
      <q-toolbar-title>
        {{ page().title }}
      </q-toolbar-title>
      <q-space />
      <company-sector-search-component />
    </q-toolbar>
    
    <q-pull-to-refresh @refresh="refresh">
      <q-list 
        separator
        bordered>         
        <company-sector-list-component>
        </company-sector-list-component>
      </q-list>
    </q-pull-to-refresh>

    <q-page-sticky 
      position="bottom-right" 
      :offset="[18, 18]">
      <q-btn 
        fab 
        icon="add"
        color="primary" 
        @click="formCompanySectorNewEdit = true" />
    </q-page-sticky>

    <q-dialog v-model="formCompanySectorNewEdit">
      <company-sector-new-edit-component @close="formCompanySectorNewEdit = false" />
    </q-dialog>
  </q-page>
</template>

<script>
  import { mapActions, mapGetters, mapState } from 'vuex'
  import axios from 'axios'
  import { CONFIG } from '../../config'
  
  export default {
    data() {
      return {
        formCompanySectorNewEdit: false
      }
    },
    methods: {
      ...mapActions('auth', ['actAuthUserPage']),
      ...mapActions('company_sectors', ['actCompanySectors']),
      ...mapGetters('company_sectors', ['getCompanySectorsFiltered']),
      ...mapState('auth', ['page']),
      refresh (done) {
        axios.get(CONFIG.api_url + '/companySectors/tree')
          .then(response => {
            let companySectors = response.data
            console.log('companySectors: ', companySectors)
            this.actCompanySectors(companySectors)
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
    mounted: {
      ...mapActions('company_sectors', ['actCompanySectors'])
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
      //...mapGetters('company-sectors', ['getCompanySectorsFiltered'])
    },
    components: {
      'company-sector-list-component': require('components/CompanySector/CompanySectorListComponent.vue').default,
      'company-sector-new-edit-component': require('components/CompanySector/Modals/CompanySectorNewEditComponent.vue').default,
      'company-sector-search-component': require('components/CompanySector/Tools/SearchComponent.vue').default
    }
  }
</script>

<style>
</style>
