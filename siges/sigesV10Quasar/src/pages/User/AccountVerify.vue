<template>

</template>

<script>
  import axios from 'axios'
  import { CONFIG } from '../../config'
  import { SessionStorage } from 'quasar'
  import { mapActions } from 'vuex'
  
  export default {
    data() {
      return {
        email: this.$route.params.email,
        activationCode: this.$route.params.activationCode
      }
    },
    methods: {
      ...mapActions('auth', ['actAuthClear']),
      ...mapActions('auth', ['actAuthUserLoggedIn']),
      ...mapActions('auth', ['actAuthUser']),
      ...mapActions('auth', ['actAuthUserCompanies']),
      ...mapActions('auth', ['actAuthUserPage'])
    },
    created() {
      SessionStorage.set('loggedIn', false)
      this.actAuthClear()
      
      axios.get(CONFIG.api_url + '/auth/activation/' + this.email + '/' + this.activationCode)
        .then(response => {
          let loggedIn = true
          SessionStorage.set('loggedIn', loggedIn)

          //console.log('response: ', response.data.access.token)
          let token = response.data.access.token
          SessionStorage.set('token', token)

          let user = response.data
          SessionStorage.set('user', user)
                        
          this.actAuthUserLoggedIn(loggedIn)
          this.actAuthUser(user)

          let companies = response.data.companies
          // console.log('companies: ', companies)
          this.actAuthUserCompanies(companies)

          this.$q.notify({
              color: 'positive',
              textColor: 'white',
              message: 'E-mail confirmado com sucesso ! Conta ativada.',
              timeout: 3000,
              icon: 'warning',
              position: 'center'
             });

          this.actAuthUserPage({ pageTitle:'EMPRESAS', pageSubTitle:'Pesquisa' })
          this.$router.push('/user/companies');
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
    }
  }
</script>

<style>
</style>
