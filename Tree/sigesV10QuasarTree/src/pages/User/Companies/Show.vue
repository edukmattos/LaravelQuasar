<template>  
  <div class="q-pa-xs">
    <q-toolbar class="q-pa-xs bg-purple text-white">
      <q-toolbar-title>
        {{ page().title }}
      </q-toolbar-title>
    </q-toolbar>
    
    <q-card class="my-card">
      <q-img src="https://cdn.quasar.dev/img/parallax2.jpg">
        <div class="absolute-bottom">
          <div class="text-h6" :style="this.deleted ? 'text-decoration:line-through' : ''">{{ getCompanyById(id).name }}</div>
          <div class="text-h8" :style="this.deleted ? 'text-decoration:line-through' : ''">{{ getCompanyById(id).full_name }}</div>
          <div class="text-h8" :style="this.deleted ? 'text-decoration:line-through' : ''">{{ getCompanyById(id).business_type.description }}</div>
        </div>
      </q-img>

      <q-card-actions>
        <q-btn flat>Action 1</q-btn>
        <q-btn flat>Action 2</q-btn>
      </q-card-actions>
    </q-card>

      <q-tabs v-model="tab" class="text-teal">
        <q-tab label="Tab one" name="one" />
        <q-tab label="Tab two" name="two" />
      </q-tabs>

      <q-separator />

      <q-tab-panels v-model="tab" animated>
        <q-tab-panel name="one">
          The QCard component is a great way to display important pieces of grouped content.
        </q-tab-panel>

        <q-tab-panel name="two">
          {{ getCompanyById(id) }}
        </q-tab-panel>
      </q-tab-panels>
    

    <q-dialog v-model="formCompanyNewEdit">
      <company-new-edit-component 
        @close="formCompanyNewEdit = false" 
        :company="getCompanyById(id)"
        :id="id"
      />
    </q-dialog>
    
    <q-page-sticky position="top-right" :offset="[20, 30]">
      <q-fab
        icon="keyboard_arrow_down"
        direction="down"
        color="accent"
        glossy
      >
        <q-fab-action @click="goToPageCompaniesList" color="primary" icon="search" />
        <q-fab-action @click="setCompanyIn(id)" color="primary" icon="done" />
        <q-fab-action @click="formCompanyNewEdit = true" color="secondary" icon="edit" />
        <q-fab-action @click="promptToDelete(id)" color="negative" icon="delete" />
      </q-fab>
    </q-page-sticky>
  </div>
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
        formCompanyNewEdit: false,
        deleted: false
      }
    },
    created() {
      // 1. Capturar o id da Company
      this.id = this.$route.params.id
      //let companyIn = this.getCompanyById(this.id)
      
      // 2. Atualiza a companyIn na store
      // this.actAuthUserCompanyIn(companyIn)

      this.actAuthUserPage(
        { 
          pageSlug: 'company', 
          pageTitle: 'Empresa', 
          pageSubTitle: 'Informe seu acesso' 
        }
      )
    },
    computed: {
      ...mapGetters('auth', ['getAuthUserCompanyById'])
    },
    methods: {
      ...mapActions('auth', ['actAuthUserPage']),
      ...mapActions('auth', ['actAuthUserCompanyDestroy']),
      ...mapActions('auth', ['actAuthUserCompanyIn']),
      ...mapActions('auth', ['actAuthUserCompanyOut']),
      ...mapState('auth', ['page']),
      
      // 3. Recupera os dados da company da Store
      getCompanyById(id) {
        return this.getAuthUserCompanyById(id)
      },
      setCompanyIn(id) {
        let companyIn = this.getAuthUserCompanyById(id)
        this.actAuthUserCompanyIn(companyIn)
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
          this.setAuthUserCompanyDestroy(id)
          // 4.2 Risca os dados da company
          this.deleted = true
        })
      },
      setAuthUserCompanyDestroy(id) {
        // 4.1.1 Exclui a company no DB
        axios.get(CONFIG.api_url + '/companies/'+ id +'/destroy')
          .then(response => {
            // 4.1.1 Atualiza na store o campo delete para true
            this.actAuthUserCompanyDestroy(
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
      goToPageCompaniesList() {
        // 5 Sai da company selecionada (store => companyIn = null)
        //this.actAuthUserCompanyOut()
        // 6 Redireciona de volta para a lista de companies
        this.$router.push('/user/companies')
      }
    },
    components: {
      'company-new-edit-component': require('components/Company/Modals/CompanyNewEditComponent.vue').default,
    }
  }
</script>

<style>

</style>