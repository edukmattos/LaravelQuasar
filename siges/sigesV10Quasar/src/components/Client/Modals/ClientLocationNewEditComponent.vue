<template>
    
        <q-stepper
            v-model="step"
            ref="stepper"
            vertical
            color="primary"
            animated
            >            
                <q-step
                    :name="1"
                    title="Localize Endereco"
                    caption="Optional"
                    icon="settings"
                    :done="step > 1">
                    For each ad campaign that you create, you can control how much you're willing to
                    spend on clicks and conversions, which networks and geographical locations you want
                    your ads to show on, and more.
                </q-step>

                <q-step
                    :name="2"
                    title="Create an ad group"
                    caption="Optional"
                    icon="create_new_folder"
                    :done="step > 2">
                    
                        <form @submit.prevent="submitForm">
                            
                            <form-input-text-component 
                                id="full_name"
                                textLabel="Nome/Razão Social"
                                iconName="face"
                                :clearable="false"
                                :value.sync="clientToSubmit.full_name" 
                                :error="errors.has('full_name')"
                                :errorMessage="errors.first('full_name')"
                                autofocus="true"
                                class="row q-mb-sm"
                            />
                            <form-input-text-component 
                                id="name"
                                textLabel="Apelido/Nome Fantasia"
                                iconName="face"
                                :clearable="false"
                                :value.sync="clientToSubmit.name" 
                                :error="errors.has('name')"
                                :errorMessage="errors.first('name')"
                                class="row q-mb-sm"
                            />
                            
                            <form-input-text-component 
                                id="einssa"
                                textLabel="CPF/CNPJ"
                                iconName="fingerprint"
                                :clearable="false"
                                :value.sync="clientToSubmit.einssa" 
                                :error="errors.has('einssa')"
                                :errorMessage="errors.first('einssa')"
                                class="row q-mb-sm"
                            />
                            
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
                                class="row q-mb-sm"
                            />
                            
                            <form-input-text-component 
                                id="phone"
                                textLabel="Telefone"
                                iconName="phone"
                                :clearable="false"
                                :mask="'## ####-####'"
                                :value.sync="clientToSubmit.phone" 
                                :error="errors.has('phone')"
                                :errorMessage="errors.first('phone')"
                                class="row q-mb-sm"
                            />
                            
                            <form-input-email-component 
                                id="email"
                                textLabel="E-mail"
                                iconName="mail"
                                :clearable="false"
                                :value.sync="clientToSubmit.email" 
                                :error="errors.has('email')"
                                :errorMessage="errors.first('email')"
                                class="row q-mb-sm"
                            />
                            
                        
                            <q-separator />

                            <q-card-actions align="right">
                                <q-btn 
                                    :label="btnCancelLabel" 
                                    color="negative" 
                                    v-close-popup 
                                    class="q-ml-sm" />
                                <q-btn 
                                    :label="btnSubmitLabel" 
                                    :loading="submiting"
                                    :disable="submiting" 
                                    type="submit" 
                                    color="primary"
                                    class="q-ml-sm" />
                            </q-card-actions>
                        </form>
                    
                </q-step>

                <template v-slot:navigation>
                    <q-stepper-navigation align="right">
                        <q-btn @click="$refs.stepper.next()" color="primary" :label="step === 2 ? 'Salvar' : 'Avancar'" />
                        <q-btn v-if="step > 1" flat color="primary" @click="$refs.stepper.previous()" label="Voltar" class="q-ml-sm" />
                    </q-stepper-navigation>
                </template>
        </q-stepper>
    
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
                step: 1
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
            this.headerTitle = this.formAction == 'new' ? 'Novo Endereco' : 'Editar Endereco'
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

<style scoped>
    .footer {
	    font-size: 0.7em;
	    margin-top: 20vh;
	  } 
</style>

