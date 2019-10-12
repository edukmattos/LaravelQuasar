<template>
  <q-layout view="hHh Lpr lFf">
    <div class="flex-container fixed-center bg-grey-2 text-white">
      <q-card round-borders class="flex-center text-center" style="width: 350px; padding:5px">
        <!-- Notice the slot="overlay" -->
        <q-card-title>
          <img src="~assets/img/logo-icon.png" /> 
          <br>
          <img src="~assets/img/logo-text.png" /> 
         
          <q-card-media>
            <br>
            <q-icon name="fingerprint" color="primary" style="font-size: 70px"/>
          </q-card-media>
        </q-card-title>

        <q-card-main>
          <form>
            <div class="text-left q-pa-sm">
              <q-field
                icon="mail"
                iconColor="primary"
                :error="errors.has('email')"
                :error-label="errors.first('email')">
                  <q-input
                    id="email"
                    float-label="E-mail"
                    type="text"
                    v-model.trim="credentials.email">
                  </q-input>
              </q-field>

              <br>

              <q-field
                icon="lock"
                iconColor="primary"
                :error-label="errors.first('password')"
                :error="errors.has('password')">
                <q-input
                  id="password"
                  float-label="Senha"
                  type="password"
                  v-model.trim="credentials.password">
                </q-input>
              </q-field>

              <br>

              <q-btn
                :loading="submiting"
                :disable="submiting"
                :label="btnSubmitLabel"
                class="full-width"
                color="primary"
                @click.prevent="onSubmit()">
              </q-btn>
                
              <br>
            </div>
          </form>
        </q-card-main>
      </q-card>
    </div>
    
    <q-layout-footer class="fixed-bottom">
      <q-tabs align="center">
        <!-- Tabs - notice slot="title" -->
        <q-tab two-lines label="Conta" slot="title" name="tabRegister" icon="person_add" @click="tabRegisterSelected"/>
        <q-tab two-lines label="Senha" slot="title" name="tabRecover" icon="contact_mail" @click="tabRecoverySelected"/>
      </q-tabs>
    </q-layout-footer>    
  </q-layout>
</template>

<script>
  import axios from 'axios';
  import { CONFIG } from '../../config';
  import { SessionStorage } from 'quasar';

  export default
  {
    data () {
      return {
        credentials: {
          email: 'edukmattos@gmail.com',
          password: 'secret'
        },
        submiting: false,
        btnSubmitLabel: "Entrar"
      }
    },

    mounted () {
      this.$store.dispatch('auth/actUserLogout');
      this.$store.dispatch('auth/actPageSet', ['IDENTIFIQUE-SE', '']);

      //Clear states (vuex)
      this.$store.dispatch('user/actUserCompaniesClear');
    },

    methods: {
      tabRegisterSelected() {
        this.tabSelected = 'tabRegister';
        //this.$store.dispatch('auth/actPageSet', ['REGISTRO', 'Crie uma nova conta']);
        //this.$router.push('/register');
        this.$router.push('/register');
      },
      
      tabRecoverySelected() {
        this.tabSelected = 'tabRecovery';
        //this.$store.dispatch('auth/actPageSet', ['RECUPERAÇÂO DA SENHA', 'Recupere a sua senha de acesso']);
        this.$router.push('/recovery');
      },

      onSubmit () {
        axios.post(CONFIG.api_url + '/auth/login', this.credentials)
          .then(response => {
            //console.log(response.data.token);

            this.submiting = true;
            this.btnSubmitLabel = "Verificando...";
            //this.$q.loadingBar.start();
            
            let token = response.data.token;
            SessionStorage.set('token', token);

            //let client_name = response.data.client_name;
            //SessionStorage.set('client_name', client_name);

            let user = response.data.user;
            //console.log("user: ", response.data.user);
            SessionStorage.set('user', user);
            
            this.$store.dispatch('auth/actUserLogged', user);
            
            this.$store.dispatch('auth/actPageSet', ['Empresas', 'Pesquisa']);
            
            this.submiting = false;
            this.$q.loadingBar.stop();

            //Atualiza state.user.companies
            this.$store.dispatch('user/actUserCompaniesAll');
            this.$router.push('/user/companies');
            
          })
          .catch(errors => {
            console.log(errors.response);
            if (errors.response) {
              this.$setErrorsFromResponse(errors.response.data);

              this.submiting = false;
              this.btnSubmitLabel = "Entrar";

              this.$q.notify({
                message: 'Ops... encontramos alguns problemas !',
                icon: 'warning',
                position: 'top-right'
              });
            }  
            this.$q.loadingBar.stop();          
          });        
      }
    }
  }
</script>

<style scoped>
</style>