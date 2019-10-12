<template padding>
    <q-card>
        <modal-header-component>{{ headerTitle }}</modal-header-component>

        <q-separator />
        
        <form @submit.prevent="submitForm">
            <q-card-section class="row">
                <form-input-text-component 
                    id="code"
                    textLabel="Código"
                    iconName="face"
                    :value.sync="companySectorToSubmit.code" 
                    :error="errors.has('code')"
                    :errorMessage="errors.first('code')"
                />
            </q-card-section>

            <q-card-section class="row">
                <form-input-text-component 
                    id="description"
                    textLabel="Descrição"
                    iconName="face"
                    :value.sync="companySectorToSubmit.description" 
                    :error="errors.has('description')"
                    :errorMessage="errors.first('description')"
                />
            </q-card-section>

            <q-card-section class="row">
                <form-select-component 
                    id="parent_id"
                    textLabel="Setor Pai"
                    iconName="mail"
                    :selectOptions="selectOptions"
                    :value.sync="companySectorToSubmit.parent_id" 
                    :error="errors.has('parent_id')"
                    :errorMessage="errors.first('parent_id')"
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
            'companySector',
            'id'
        ],
        data() {
            return {
                btnSubmitLabel: "Salvar",
                submiting: false,
                btnCancelLabel: "Cancelar",
                companySectorToSubmit: {},
                headerTitle: '',
                selectOptions: [],
                filterOptions: [],
                formAction: ''
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
                            code: this.companySectorToSubmit.code,
                            description: this.companySectorToSubmit.description,
                            parent_id: this.companySectorToSubmit.parent_id
                        })
                        .then(response => {
                            //console.log(response.data)
                            let payload = response.data
                            //this.actAuthUserCompanyUpdate({
                            //    id: this.id,
                            //    updates: this.companySectorToSubmit
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
                    axios.post(CONFIG.api_url + '/companies', this.companySectorToSubmit)
                        .then(response => {
                            let companySector = response.data
                            this.actAuthUserCompanyAdd(companySector)
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
                //console.log('Close Form Edit')
                this.$emit('close')
            }
        },
        components: {
            'modal-header-component': require('components/Company/Modals/Shared/HeaderComponent.vue').default,
            'form-select-component': require('components/Forms/SelectComponent.vue').default,
            'form-input-text-component': require('components/Forms/InputTextComponent.vue').default
        },
        created() {
            //console.log(this.company)
            this.formAction = this.companySector == undefined ? 'new' : 'edit'
            //console.log(this.formAction)
            this.headerTitle = this.formAction == 'new' ? 'Novo Setor' : 'Editar Setor'
        },
        mounted() {
            this.companySectorToSubmit = Object.assign({}, this.companySector)

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

