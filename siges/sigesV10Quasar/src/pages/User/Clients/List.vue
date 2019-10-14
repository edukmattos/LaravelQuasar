<template>
  <q-page>
    <div class="row no-wrap shadow-1">
      <q-toolbar class="q-pa-xs bg-purple text-white">
        <div class="col-6 q-mb-xs">
          <company-clients-search-component />
        </div>
        <q-toolbar-title class="text-right">
          {{ page().title }}
        </q-toolbar-title>
        <q-btn flat round dense icon="assignment_ind">
          <q-badge floating color="red">
            {{ getAuthUserCompanyClientsFiltered.length }}
          </q-badge>
        </q-btn>
      </q-toolbar>
    </div>

    <q-pull-to-refresh @refresh="refresh">
      <q-list separator>         
        <user-company-client-data-expansible-component
          v-for="(client, key) in getAuthUserCompanyClientsFiltered"
          :key="key"
          :clientKey="key"
          :client="client"
          :id="client.id"
          @click="true">
        </user-company-client-data-expansible-component>
      </q-list>
    </q-pull-to-refresh>

    <q-page-sticky 
      position="bottom-right" 
      :offset="[18, 18]">
      <q-btn 
        fab 
        icon="add"
        color="primary" 
        @click="formClientNewEdit = true" />
    </q-page-sticky>

    <q-dialog v-model="formClientNewEdit">
      <client-new-edit-component @close="formClientNewEdit = false" />
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
        formClientNewEdit: false
      }
    },
    methods: {
      ...mapActions('auth', ['actAuthUserPage']),
      ...mapActions('clients', ['actAuthUserCompanyClients']),
      ...mapState('auth', ['page']),
      loadClients() {
        axios.get(CONFIG.api_url + '/clients')
        .then(response => {
          let clients = response.data
          //console.log('clients: ', clients)
          this.actAuthUserCompanyClients(clients)
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
      },
      refresh (done) {
        this.loadClients()
        done()
      }
    },
    created() {
      this.loadClients(),
      this.actAuthUserPage(
        { 
          pageSlug: 'clients', 
          pageTitle: 'Clientes', 
          pageSubTitle: 'Informe seu acesso' 
        }
      )
    },    
    computed: {
      ...mapGetters('clients', ['getAuthUserCompanyClientsFiltered']),
      ...mapGetters('clients', ['getAuthUserCompanyClientsFilteredTotal'])
    },
    components: {
      'user-company-client-data-expansible-component': require('components/Client/ClientDataExpansibleComponent.vue').default,
      'client-new-edit-component': require('components/Client/Modals/ClientNewEditComponent.vue').default,
      'company-clients-search-component': require('components/Client/Tools/SearchComponent.vue').default
    }
  }
</script>

<style>
</style>
