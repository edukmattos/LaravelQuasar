<template padding>
    <q-card>
        <modal-header-component>{{ headerTitle }}</modal-header-component>

        <q-separator />
        
        <form @submit.prevent="submitForm">
            <q-card-section class="row">
                <form-input-text-component 
                    id="full_name"
                    textLabel="Razão Social"
                    iconName="face"
                    :value.sync="companyToSubmit.full_name" 
                    :error="errors.has('full_name')"
                    :errorMessage="errors.first('full_name')"
                />
            </q-card-section>

            <q-card-section class="row">
                <form-input-text-component 
                    id="name"
                    textLabel="Nome Fantasia"
                    iconName="face"
                    :value.sync="companyToSubmit.name" 
                    :error="errors.has('name')"
                    :errorMessage="errors.first('name')"
                />
            </q-card-section>

            <q-card-section class="row">
                <form-input-text-component 
                    id="einssa"
                    textLabel="CPF/CNPJ"
                    iconName="fingerprint"
                    :value.sync="companyToSubmit.einssa" 
                    :error="errors.has('einssa')"
                    :errorMessage="errors.first('einssa')"
                />
            </q-card-section>

            <q-card-section class="row">
                <form-select-component 
                    id="business_type_id"
                    textLabel="Ramo Atividade"
                    iconName="mail"
                    v-model="selected"
                    :selectOptions="selectOptions"
                    :value.sync="companyToSubmit.business_type_id" 
                    :error="errors.has('business_type_id')"
                    :errorMessage="errors.first('business_type_id')"
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
            'company',
            'id'
        ],
        data() {
            return {
                btnSubmitLabel: "Salvar",
                submiting: false,
                btnCancelLabel: "Cancelar",
                companyToSubmit: [],
                headerTitle: '',
                selectOptions: [],
                filterOptions: [],
                formAction: '',
                businessType: ''
            }
        },
        methods: {
            ...mapActions('auth', ['actAuthUserCompanyAdd']),
            ...mapActions('auth', ['actAuthUserCompanyUpdate']),
            submitForm() {
                this.submiting = true
                this.$q.loadingBar.start()
                this.btnSubmitLabel = "Verificando"

                if (this.formAction=='edit') {
                    axios.post(CONFIG.api_url + '/companies/' + this.id + '/update', 
                        {
                            name: this.companyToSubmit.name,
                            full_name: this.companyToSubmit.full_name,
                            einssa: this.companyToSubmit.einssa,
                            business_type_id: this.companyToSubmit.business_type_id
                        })
                        .then(response => {
                            //console.log(response.data)
                            let payload = response.data
                            //this.actAuthUserCompanyUpdate({
                            //    id: this.id,
                            //    updates: this.companyToSubmit
                            //})
                            this.actAuthUserCompanyUpdate(payload)
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
                    //console.log('companyToSubmit_new: ', this.companyToSubmit)
                    axios.post(CONFIG.api_url + '/companies', this.companyToSubmit)
                        .then(response => {
                            let company = response.data
                            this.actAuthUserCompanyAdd(company)
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
            },
            changeBusinessType() {

            }
        },
        components: {
            'modal-header-component': require('components/Company/Modals/Shared/HeaderComponent.vue').default,
            'form-select-component': require('components/Forms/SelectComponent.vue').default,
            'form-input-text-component': require('components/Forms/InputTextComponent.vue').default
        },
        created() {
            //this.companyToSubmit = Object.assign({}, this.company)
            //console.log(this.company)
            this.formAction = this.company == undefined ? 'new' : 'edit'
            //console.log(this.formAction)
            if (this.formAction == 'edit') {
                this.companyToSubmit = Object.assign({}, this.company)
                console.log('companyToSubmit_edit: ', this.companyToSubmit)
                
                this.companyToSubmit.business_type_id = this.company.business_type.id
                //console.log('companyToSubmit.business_type_id: ', this.companyToSubmit.business_type_id)
                this.selected = {
                    'label': this.company.business_type.description,
                    'value': this.company.business_type.id
                }
                console.log('selected: ', this.selected)
            }
            this.headerTitle = this.formAction == 'new' ? 'Nova Empresa' : 'Editar Empresa'
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

