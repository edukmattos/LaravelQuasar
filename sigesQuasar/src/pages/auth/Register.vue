<template>
  <q-layout view="hHh Lpr lFf">
    <div class="fixed fixed-center bg-grey-2 text-white">
      <q-card round-borders class="flex-center text-center" style="width: 350px; padding:10px">
        <!-- Notice the slot="overlay" -->
        <q-card-title>
          <p class="text-primary">
            Informe suas Credenciais
          </p>
          <span slot="subtitle">Subtitle</span>

          <q-card-media>
            
          </q-card-media>
        </q-card-title>

        <q-card-main>
          <form>
            <div class="text-left q-pa-sm">
              <q-field
                icon="face"
                iconColor="primary"
                :error="errors.has('name')"
                :error-label="errors.first('name')">
                  <q-input
                    id="name"
                    float-label="Nome"
                    type="text"
                    v-model.trim="credentials.name">
                  </q-input>
              </q-field>
              
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

              <q-field
                icon="lock"
                iconColor="primary"
                :error-label="errors.first('passwordRepeat')"
                :error="errors.has('passwordRepeat')">
                <q-input
                  id="passwordRepeat"
                  float-label="Repetir Senha"
                  type="password"
                  v-model.trim="credentials.passwordRepeat">
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

    <q-layout-footer>
      <q-tabs align="center">
        <!-- Tabs - notice slot="title" -->
        <q-tab two-lines label="Login" slot="title" name="tabLogin" icon="how_to_reg" @click="tabLoginSelected"/>
        <q-tab two-lines label="Código Ativação" slot="title" name="tabVerify" icon="person_add" @click="tabVerifySelected"/>
        <q-tab two-lines label="Senha" slot="title" name="tabRecovery" icon="contact_mail" @click="tabRecoverySelected"/>
      </q-tabs>
    </q-layout-footer>    
  </q-layout>

</template>

<script>
  import axios from 'axios'
  import { CONFIG } from '../../config'

  export default {
    data () {
      return {
        credentials: {
          name: '',
          email: '',
          password: '',
          passwordRepeat: ''
        },
        submiting: false,
        btnSubmitLabel: "Enviar"
      }
    },

    mounted(){
      this.$store.dispatch('auth/actPageSet', ['CRIAR CONTA', '']);
    },

    computed: {
    },

    methods: {
      tabLoginSelected() {
        this.tabSelected = 'tabLogin';
        this.$router.push('/login');
      },

      tabVerifySelected() {
        this.tabSelected = 'tabVerify';
        this.$router.push('/verify');
      },
      
      tabRecoverySelected() {
        // alert('Motor')
        this.tabSelected = 'tabRecovery';
        this.$router.push('/recovery');
      },

      onSubmit () {
        this.submiting = true;
        this.btnSubmitLabel = "Verificando...";

        this.$q.loadingBar.start()
       
        axios.post(CONFIG.api_url + '/auth/register', this.credentials)
          .then(response => {
            //this.$router.push('/verify');
            this.submiting = false;
            this.btnSubmitLabel = "Verificado";

            this.$store.dispatch('auth/actUserLogout');
            this.$store.dispatch('auth/actPageSet', ['LOGIN', 'Identificação']);
            this.$router.push('/login');
          
            this.$q.notify({
              message: 'Obrigado pelo seu cadastro ! Verifique o seu e-mail para completar o cadastro.',
              icon: 'thumb_up_alt',
              position: 'top-right',
              type: 'positive'
            });

            this.$q.loadingBar.stop();

          })
          .catch(errors => {
            //console.log(errors.response.data.errors);
            if (errors.response.status === 422) {
              this.$setErrorsFromResponse(errors.response.data);

              this.submiting = false;
              this.btnSubmitLabel = "Entrar";

              this.$q.notify({
                message: 'Ops... encontramos alguns problemas !',
                icon: 'warning',
                position: 'top-right'
              });
              this.$q.loadingBar.stop();
            }            
          });
      }
    }
  }
</script>