<template>  
  <q-page>
    <div class="row no-wrap shadow-1">
      <q-toolbar class="bg-purple text-white">
        <q-btn flat round dense icon="assignment_ind">
        </q-btn>
        <q-toolbar-title>
          {{ page().title }}
        </q-toolbar-title>
        <q-btn 
          flat 
          round 
          dense 
          to="/user/clients"
          icon="search" 
          class="q-mr-xs">
        </q-btn>
        
        <q-btn 
          flat 
          round 
          dense 
          icon="more_vert" 
          class="q-mr-xs">
          <q-menu 
            transition-show="flip-right"
            transition-hide="flip-left"
            auto-close 
            :offset="[60, 0]">
              <q-list style="min-width: 100px">
                <q-item clickable>
                  <q-item-section side>
                    <q-icon name="edit" color="primary" />
                  </q-item-section>
                  <q-item-section>Alterar</q-item-section>
                </q-item>
                <q-item clickable>
                  <q-item-section side>
                    <q-icon name="delete" color="red" />
                  </q-item-section>
                  <q-item-section>Excluir</q-item-section>
                </q-item>
              </q-list>
            </q-menu>
        </q-btn>
      </q-toolbar>
    </div>
    <q-list separator>         
      <user-company-client-data-expansible-component
        :client="getCompanyClientById(id)">
      </user-company-client-data-expansible-component>
    </q-list>
    
    <q-separator spaced inset vertical dark />

    <q-card>
        <q-tabs
          v-model="tab"
          dense
          class="bg-grey-3 text-grey-7"
          active-color="primary"
          indicator-color="purple"
          align="justify"
        >
          <q-tab name="locations" label="" icon="room"/>
          <q-tab name="alarms" label="Alarms" />
          <q-tab name="movies" label="Movies" />
        </q-tabs>

        <q-separator />

        <q-tab-panels v-model="tab" animated class="bg-white">
          <q-tab-panel name="locations" class="q-pa-xs">
            <div class="row no-wrap shadow-1">
              <q-toolbar class="q-pa-xs bg-white text-white">
                <div class="col-11">
                  <company-clients-locations-search-component />
                </div>
                <div class="col-1 text-right">
                  <q-btn 
                    round 
                    dense 
                    icon="add" 
                    class="q-pa-xs"
                    color="green">
                    <q-menu 
                      transition-show="flip-right"
                      transition-hide="flip-left"
                      auto-close 
                      :offset="[60, 0]">
                        <q-list style="min-width: 100px">
                          <q-item clickable>
                            <q-item-section side>
                              <q-icon name="edit" color="primary" />
                            </q-item-section>
                            <q-item-section>Alterar</q-item-section>
                          </q-item>
                          <q-item clickable>
                            <q-item-section side>
                              <q-icon name="delete" color="red" />
                            </q-item-section>
                            <q-item-section>Excluir</q-item-section>
                          </q-item>
                        </q-list>
                      </q-menu>
                  </q-btn>
                </div>
              </q-toolbar>
            </div>
            
            <div class>
              <q-list separator>         
                <user-company-client-location-expansible-component
                  v-for="(location, key) in getAuthUserCompanyClientLocationsFiltered(clientKey)"
                  :key="key"
                  :location="location"
                  :id="id"
                  @click="true">
                </user-company-client-location-expansible-component>
              </q-list>
            </div>

          </q-tab-panel>

          <q-tab-panel name="alarms" class="bg-purple-2">
            <div class="text-h6">Alarms</div>
            Lorem ipsum dolor sit amet consectetur adipisicing elit.
          </q-tab-panel>

          <q-tab-panel name="movies">
            <div class="text-h6">Movies</div>
            Lorem ipsum dolor sit amet consectetur adipisicing elit.
          </q-tab-panel>
        </q-tab-panels>
      </q-card>
  </q-page>
</template>

<script>
  import { mapActions, mapGetters, mapState } from 'vuex'
  import axios from 'axios'
  import { CONFIG } from '../../../config'

  export default {
    data () {
      return {
        tab: 'one',
        id: '0',
        clientKey: '',
        formCompanyClientNewEdit: false,
        deleted: false
      }
    },
    created() {
      // 1. Capturar o id da Company
      this.id = this.$route.params.id
      this.clientKey = this.$route.params.clientKey
      //let companyIn = this.getCompanyClientById(this.id)
      
      // 2. Atualiza a companyIn na store
      // this.actAuthUserCompanyIn(companyIn)

      this.actAuthUserPage(
        { 
          pageSlug: 'client', 
          pageTitle: 'Cliente', 
          pageSubTitle: 'Informe seu acesso' 
        }
      )
    },
    computed: {
      ...mapGetters('clients', ['getAuthUserCompanyClientById']),
      //...mapGetters('clients', ['getAuthUserCompanyClientLocationsById']),
      ...mapGetters('clients', ['getAuthUserCompanyClientLocationsFiltered'])
    },
    methods: {
      ...mapActions('auth', ['actAuthUserPage']),
      ...mapActions('clients', ['actAuthUserCompanyClientDestroy']),
      ...mapActions('auth', ['actAuthUserCompanyIn']),
      ...mapActions('auth', ['actAuthUserCompanyOut']),
      ...mapState('auth', ['page']),
      
      // 3. Recupera os dados da company da Store
      getCompanyClientById(id) {
        return this.getAuthUserCompanyClientById(id)
      },
      // 4. Exclusao da company
      promptToDelete(id) {
        //console.log(company.id)
        this.$q.dialog({
          title: 'Opss...',
          message: 'Deseja realmente EXCLUIR ?',
          ok: {
            push: true,
            label: 'SIM',
            color: 'negative'
          },
          cancel: {
            label: 'Cancelar',
            color: 'primary'
          },
          persistent: true
        }).onOk(() => {
          // 4.1 Exclusao da company
          this.setAuthUserCompanyClientDestroy(id)
          // 4.2 Risca os dados da company
          this.deleted = true
        })
      },
      setAuthUserCompanyClientDestroy(id) {
        // 4.1.1 Exclui a company no DB
        axios.get(CONFIG.api_url + '/companies/'+ id +'/destroy')
          .then(response => {
            // 4.1.1 Atualiza na store o campo delete para true
            this.actAuthUserCompanyClientDestroy(
              { 
                id: id, 
                updates: { 
                  deleted: true 
                }
              })
            // 4.1.1 Atualiza o campo delete para true e assim modificar o style para riscar os dados
            //this.deleted = true
            //console.log(this.deleted)
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
      goToPageCompanyClientsList() {
        // 5 Sai da company selecionada (store => companyIn = null)
        //this.actAuthUserCompanyOut()
        // 6 Redireciona de volta para a lista de companies
        this.$router.push('/user/clients')
      }
    },
    components: {
      'user-company-client-data-expansible-component': require('components/Client/ClientDataExpansibleComponent.vue').default,
      'user-company-client-location-expansible-component': require('components/Client/ClientLocationExpansibleComponent.vue').default,
      'company-client-new-edit-component': require('components/Client/Modals/ClientNewEditComponent.vue').default,
      'company-clients-locations-search-component': require('components/Client/Tools/SearchLocationsComponent.vue').default
    }
  }
</script>

<style>

</style>