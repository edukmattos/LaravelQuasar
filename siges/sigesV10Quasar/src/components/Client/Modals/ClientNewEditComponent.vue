<template padding>
    <q-card>
        <modal-header-component>{{ headerTitle }}</modal-header-component>

        <q-separator />

        <form @submit.prevent="submitForm">
            <q-card-section class="row">
                <form-input-text-component 
                    id="full_name"
                    textLabel="Nome/Razão Social"
                    iconName="face"
                    :clearable="false"
                    :value.sync="clientToSubmit.full_name" 
                    :error="errors.has('full_name')"
                    :errorMessage="errors.first('full_name')"
                    autofocus="true"
                />
            </q-card-section>

            <q-card-section class="row">
                <form-input-text-component 
                    id="name"
                    textLabel="Apelido/Nome Fantasia"
                    iconName="face"
                    :clearable="false"
                    :value.sync="clientToSubmit.name" 
                    :error="errors.has('name')"
                    :errorMessage="errors.first('name')"
                />
            </q-card-section>

            <q-card-section class="row">
                <form-input-text-component 
                    id="einssa"
                    textLabel="CPF/CNPJ"
                    iconName="fingerprint"
                    :clearable="false"
                    :value.sync="clientToSubmit.einssa" 
                    :error="errors.has('einssa')"
                    :errorMessage="errors.first('einssa')"
                />
            </q-card-section>

            <q-card-section class="row">
                <form-input-text-component 
                    id="mobile"
                    textLabel="Celular"
                    iconName="smartphone"
                    :clearable="false"
                    :mask="'## #####-####'"
                    unmasked-value
                    :value.sync="clientToSubmit.mobile" 
                    :error="errors.has('mobile')"
                    :errorMessage="errors.first('mobile')"
                />
            </q-card-section>

            <q-card-section class="row">
                <form-input-text-component 
                    id="phone"
                    textLabel="Telefone"
                    iconName="phone"
                    :clearable="false"
                    :mask="'## ####-####'"
                    :value.sync="clientToSubmit.phone" 
                    :error="errors.has('phone')"
                    :errorMessage="errors.first('phone')"
                />
            </q-card-section>

            <q-card-section class="row">
                <form-input-email-component 
                    id="email"
                    textLabel="E-mail"
                    iconName="mail"
                    :clearable="false"
                    :value.sync="clientToSubmit.email" 
                    :error="errors.has('email')"
                    :errorMessage="errors.first('email')"
                />
            </q-card-section>
        
            <q-separator />

            <q-card-actions align="right">
                <q-btn 
                    :label="btnCancelLabel" 
                    color="negative" 
                    v-close-popup />
                <q-btn 
                    :label="btnSubmitLabel" 
                    :loading="submiting"
                    :disable="submiting" 
                    type="submit" 
                    color="primary" />
            </q-card-actions>
        </form>
    </q-card>
</template>

<script>
    import axios from 'axios'
    import { CONFIG } from '../../../config'
    import { mapActions } from 'vuex'

    export default {
        props: [
            'client',
            'id'
        ],
        data() {
            return {
                btnSubmitLabel: "Salvar",
                submiting: false,
                btnCancelLabel: "Cancelar",
                clientToSubmit: [],
                headerTitle: '',
                selectOptions: [],
                filterOptions: [],
                formAction: '',
            }
        },
        methods: {
            ...mapActions('clients', ['actAuthUserCompanyClientAdd']),
            ...mapActions('clients', ['actAuthUserCompanyClientUpdate']),
            submitForm() {
                this.submiting = true
                this.$q.loadingBar.start()
                this.btnSubmitLabel = "Verificando"

                if (this.formAction=='edit') {
                    axios.post(CONFIG.api_url + '/clients/' + this.id + '/update', 
                        {
                            name: this.clientToSubmit.name,
                            full_name: this.clientToSubmit.full_name,
                            einssa: this.clientToSubmit.einssa,
                            mobile: this.clientToSubmit.mobile,
                            phone: this.clientToSubmit.phone,
                            email: this.clientToSubmit.email
                        })
                        .then(response => {
                            //console.log(response.data)
                            let payload = response.data
                            //this.actAuthUserCompanyClientUpdate({
                            //    id: this.id,
                            //    updates: this.clientToSubmit
                            //})
                            this.actAuthUserCompanyClientUpdate(payload)
                            this.$q.loadingBar.stop()
                            this.closeForm()
                        })
                        .catch(errors => {
                            if (errors.response) {
                                this.$setErrorsFromResponse(errors.response.data)
                            }  
                            this.$q.loadingBar.stop()  
                            this.submiting = false      
                            this.btnSubmitLabel = "Salvar"
                        });
                }

                if (this.formAction=='new') {
                    //console.log('clientToSubmit_new: ', this.clientToSubmit)
                    axios.post(CONFIG.api_url + '/clients', this.clientToSubmit)
                        .then(response => {
                            let client = response.data
                            console.log(response.data)
                            this.actAuthUserCompanyClientAdd(client)
                            this.$q.loadingBar.stop()
                            this.closeForm()
                        })
                        .catch(errors => {
                            if (errors.response) {
                                this.$setErrorsFromResponse(errors.response.data)
                            }  
                            this.$q.loadingBar.stop()  
                            this.submiting = false      
                            this.btnSubmitLabel = "Salvar"
                        });
                }                       
            },
            closeForm() {
                this.$emit('close')
            }
        },
        components: {
            'modal-header-component': require('components/Client/Modals/Shared/HeaderComponent.vue').default,
            'form-input-email-component': require('components/Forms/InputEmailComponent.vue').default,
            'form-input-text-component': require('components/Forms/InputTextComponent.vue').default
        },
        created() {
            this.clientToSubmit = Object.assign({}, this.client)
            //console.log(this.client)
            this.formAction = this.client == undefined ? 'new' : 'edit'
            //console.log(this.formAction)
            if (this.formAction == 'edit') {
                //this.clientToSubmit = Object.assign({}, this.client)
                console.log('clientToSubmit_edit: ', this.clientToSubmit)
                
                this.clientToSubmit.business_type_id = this.client.business_type.id
                //console.log('clientToSubmit.business_type_id: ', this.clientToSubmit.business_type_id)
                this.selected = {
                    'label': this.client.business_type.description,
                    'value': this.client.business_type.id
                }
                console.log('selected: ', this.selected)
            }
            this.headerTitle = this.formAction == 'new' ? 'Novo Cliente' : 'Editar Cliente'
        },
        mounted() {
           axios
                .get(CONFIG.api_url + '/businessTypes/autocomplete')
                .then((results) => {
                    this.selectOptions = results.data;
                    //console.log(this.selectOptions);
                })
        }
    }
</script>

<style>
</style>

