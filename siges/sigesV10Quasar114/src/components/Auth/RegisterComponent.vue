<template>
    <form @submit.prevent="submitForm">
        <div class="row q-mb-md">
            <form-input-text-component 
                id="name"
                textLabel="Nome"
                iconName="face"
                :value.sync="register.name" 
                :error="errors.has('name')"
                :errorMessage="errors.first('name')"
            />
        </div>
        
        <div class="row q-mb-md">
            <form-input-email-component 
                id="email"
                textLabel="E-mail"
                iconName="mail"
                :value.sync="register.email" 
                :error="errors.has('email')"
                :errorMessage="errors.first('email')"
            />
        </div>

        <div class="row q-mb-md">
            <form-input-password-component 
                id="password"
                textLabel="Senha"
                :value.sync="register.password" 
                :error="errors.has('password')"
                :errorMessage="errors.first('password')"
            />
        </div>

        <div class="row q-mb-md">
            <form-input-password-component 
                id="password_confirmation"
                textLabel="Confirmar Senha"
                :value.sync="register.password_confirmation" 
                :error="errors.has('password_confirmation')"
                :errorMessage="errors.first('password_confirmation')"
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
                register: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                },
                submiting: false,
                btnSubmitLabel: "Registrar",
                isPwd: true,
                isPwdConfirm: true
            }
        },
        methods: {
            submitForm() {
                this.submiting = true
                this.$q.loadingBar.start()

                //return new Promise((response, reject) => {
                    axios.post(CONFIG.api_url + '/auth/signup', this.register)
                        .then(response => {
                            console.log(response)
                            // this.$store.dispatch('auth/actUserLogout');
                            // this.$store.dispatch('auth/actPageSet', ['LOGIN', 'Identificação']);
                            // this.$router.push('/login');
                        
                            // this.registerUser(this.register) 
                            
                            this.$q.notify({
                                color: 'positive',
                                textColor: 'white',
                                message: 'Obrigado pelo seu registro ! Verifique o seu e-mail para confirmar a sua conta.',
                                icon: 'thumb_up_alt',
                                position: 'center',
                                timeout: 3000
                            })

                            this.$router.push('/about')

                            this.$q.loadingBar.stop()
                            this.submiting = false

                        })
                        .catch(errors => {
                            //reject(errors)
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
  
            }
        },
        components: {
            'form-input-email-component': require('components/Forms/InputEmailComponent.vue').default,
            'form-input-text-component': require('components/Forms/InputTextComponent.vue').default,
            'form-input-password-component': require('components/Forms/InputPasswordComponent.vue').default
        }
    }
</script>