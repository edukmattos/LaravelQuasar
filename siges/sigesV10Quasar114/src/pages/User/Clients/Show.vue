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

    <q-card>
      <q-list class="text-primary">
        <q-item clickable>
          <q-item-section avatar>  
            <q-icon color="primary" name="face" />          
          </q-item-section>

          <q-item-section>
            <q-item-label caption>{{ getCompanyClientById(id).client_type.id == 1 ? 'Nome' : 'Razao Social' }}</q-item-label>
            <q-item-label>{{ getCompanyClientById(id).full_name }}</q-item-label>
          </q-item-section>
        </q-item>

        <q-item clickable>
          <q-item-section avatar>
            <q-icon color="primary" name="face" /> 
          </q-item-section>

          <q-item-section>
            <q-item-label caption>{{ getCompanyClientById(id).client_type.id == 1 ? 'Apelido' : 'Fantasia' }}</q-item-label>
            <q-item-label>{{ getCompanyClientById(id).name }}</q-item-label>
          </q-item-section>
        </q-item>

        <q-item clickable>
          <q-item-section avatar>
            <q-icon color="primary" name="fingerprint" />
          </q-item-section>

          <q-item-section>
            <q-item-label caption>{{ getCompanyClientById(id).client_type.id == 1 ? 'CPF' : 'CNPJ' }}</q-item-label>
            <q-item-label>{{ getCompanyClientById(id).einssa }}</q-item-label>
          </q-item-section>
        </q-item>

        <q-item clickable>
          <q-item-section avatar>
            <q-icon color="primary" name="smartphone" />
          </q-item-section>

          <q-item-section>
            <q-item-label caption>Celular</q-item-label>
            <q-item-label>{{ getCompanyClientById(id).mobile }}</q-item-label>
          </q-item-section>
        </q-item>

        <q-item clickable>
          <q-item-section avatar>
            <q-icon color="primary" name="phone" />
          </q-item-section>

          <q-item-section>
            <q-item-label caption>Telefone</q-item-label>
            <q-item-label>{{ getCompanyClientById(id).phone }}</q-item-label>
          </q-item-section>
        </q-item>

        <q-item clickable>
          <q-item-section avatar>
            <q-icon color="primary" name="email" />
          </q-item-section>

          <q-item-section>
            <q-item-label caption>E-mail</q-item-label>
            <q-item-label>{{ getCompanyClientById(id).email }}</q-item-label>
          </q-item-section>
        </q-item>

        <q-item clickable>
          <q-item-section avatar>
            <q-icon color="primary" name="fingerprint" />
          </q-item-section>

          <q-item-section>
            <q-item-label caption>Tipo</q-item-label>
            <q-item-label>{{ getCompanyClientById(id).client_type.description }}</q-item-label>
          </q-item-section>
        </q-item>

        <q-item clickable>
          <q-item-section avatar>
            <q-icon color="primary" name="how_to_reg" />
          </q-item-section>

          <q-item-section>
            <q-item-label caption>Situacao</q-item-label>
            <q-item-label>{{ getCompanyClientById(id).client_status.description }}</q-item-label>
          </q-item-section>
        </q-item>
      </q-list>
    </q-card>

    <q-dialog v-model="formCompanyClientNewEdit">
      <company-client-new-edit-component 
        @close="formCompanyClientNewEdit = false" 
        :company="getCompanyClientById(id)"
        :id="id"
      />
    </q-dialog>
    
    <q-page-sticky position="bottom-right" :offset="[20, 37]">
      <q-fab
        icon="keyboard_arrow_down"
        direction="up"
        color="accent"
        glossy
      >
        <q-fab-action @click="goToPageCompanyClientsList" color="primary" icon="search" />
        <q-fab-action v-if="!getCompanyClientById(id).deleted" @click="setCompanyIn(id)" color="primary" icon="done" />
        <q-fab-action v-if="!getCompanyClientById(id).deleted" @click="formCompanyClientNewEdit = true" color="secondary" icon="edit" />
        <q-fab-action v-if="!getCompanyClientById(id).deleted" @click="promptToDelete(id)" color="negative" icon="delete" />
      </q-fab>
    </q-page-sticky>
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
        formCompanyClientNewEdit: false,
        deleted: false
      }
    },
    created() {
      // 1. Capturar o id da Company
      this.id = this.$route.params.id
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
      ...mapGetters('clients', ['getAuthUserCompanyClientById'])
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
      setCompanyIn(id) {
        let companyIn = this.getAuthUserCompanyClientById(id)
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
      'company-client-new-edit-component': require('components/Client/Modals/ClientNewEditComponent.vue').default,
    }
  }
</script>

<style>

</style>