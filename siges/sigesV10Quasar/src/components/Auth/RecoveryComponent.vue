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
    
    export default {
        data() {
            return {
                credentials: {
                    email: ''
                },
                submiting: false,
                btnSubmitLabel: "Enviar"
            }
        },
        methods: {
            submitForm() {
                this.submiting = true
                this.$q.loadingBar.start()

                axios.post(CONFIG.api_url + '/auth/login', this.credentials)
                    .then(response => {
                        let token = response.data.token
                        SessionStorage.set('token', token)

                        let user = response.data.user
                        SessionStorage.set('user', user)
                        
                        ////this.$store.dispatch('auth/actUserLogged', user);
                        
                        ////this.$store.dispatch('auth/actPageSet', ['Empresas', 'Pesquisa']);
                        
                        this.submiting = false;
                        ////this.$q.loadingBar.stop();

                        //Atualiza state.user.companies
                        this.actCompanies()
                        this.$router.push('/user/companies');
                        this.$q.loadingBar.stop()
                    })
                    .catch(errors => {
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
                    });     
            }
        },
        components: {
            'form-input-email-component': require('components/Forms/InputEmailComponent.vue').default
        }
    }
</script>

<style>

</style>


