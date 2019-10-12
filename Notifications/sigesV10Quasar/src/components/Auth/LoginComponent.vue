<template>
    <form @submit.prevent="submitForm">
        <div class="row q-mb-md">
            <form-input-email-component 
                id="email"
                textLabel="E-mail"
                iconName="mail"
                :value.sync="credentials.email" 
                :error="errors.has('email')"
                :errorMessage="errors.first('email')"
                autofocus="true"
            />
        </div>

        <div class="row q-mb-md">
            <form-input-password-component 
                id="password"
                textLabel="Senha"
                iconName="lock"
                :value.sync="credentials.password" 
                :error="errors.has('password')"
                :errorMessage="errors.first('password')"
            />
        </div>

        <div class="row">
            <q-space />
            <q-btn 
                type="submit"
                color="primary" 
                :loading="submiting"
                :disable="submiting"
                :label="btnSubmitLabel" />
        </div>
    </form>
</template>

<script>
    import axios from 'axios'
    import { CONFIG } from '../../config'
    import { SessionStorage } from 'quasar'
    import { mapActions } from 'vuex'

    export default {
        data() {
            return {
                credentials: {
                    email: '',
                    password: ''
                },
                submiting: false,
                btnSubmitLabel: "Entrar"
            }
        },
        methods: {
            ...mapActions('auth', ['actAuthClear']),
            ...mapActions('auth', ['actAuthUserLoggedIn']),
            ...mapActions('auth', ['actAuthUser']),
            ...mapActions('auth', ['actAuthUserCompanies']),
            ...mapActions('auth', ['actAuthUserPage']),

            submitForm() {
                this.submiting = true
                this.$q.loadingBar.start()
                
                //return new Promise((response, reject) => {
                    axios.post(CONFIG.api_url + '/auth/login', this.credentials)
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

                            this.actAuthUserPage({ pageTitle:'EMPRESAS', pageSubTitle:'Pesquisa' })
                            this.$router.push('/user/companies');
                            
                            this.$q.loadingBar.stop()
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
                            this.$q.loadingBar.stop() 
                            this.submiting = false      
                        })
                //})
            },
        },
        created() {
            SessionStorage.set('loggedIn', false)
            this.actAuthClear()
            this.actAuthUserPage({ pageSlug:'auth', pageTitle:'Login', pageSubTitle:'Informe seu acesso' })
        },
        components: {
            'form-input-email-component': require('components/Forms/InputEmailComponent.vue').default,
            'form-input-password-component': require('components/Forms/InputPasswordComponent.vue').default
        }
    }
</script>

<style>

</style>


