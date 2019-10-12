<template>
    <q-layout view="hHh Lpr lFf">
        <div class="flex-container fixed-center bg-grey-2 text-white">
            <q-card round-borders class="flex-center text-center" style="width: 350px; padding:5px">
                <q-card-main>
                    <form>
                        <div class="text-left q-pa-sm">
                            <q-field
                                icon="fingerprint"
                                iconColor="primary"
                                :error="errors.has('einssa')"
                                :error-label="errors.first('einssa')">
                                <q-input
                                    autofocus
                                    id="einssa"
                                    float-label="CPF/CNPJ"
                                    type="text"
                                    v-model.trim="company.einssa">
                                </q-input>
                            </q-field>

                            <q-field
                                icon="face"
                                iconColor="primary"
                                :error="errors.has('full_name')"
                                :error-label="errors.first('full_name')">
                                <q-input
                                    id="full_name"
                                    float-label="Razão Social"
                                    type="text"
                                    v-model.trim="company.full_name">
                                </q-input>
                            </q-field>
                                
                            <q-field
                                icon="face"
                                iconColor="primary"
                                :error="errors.has('name')"
                                :error-label="errors.first('name')">
                                <q-input
                                    id="name"
                                    float-label="Nome Fantasia"
                                    type="text"
                                    v-model.trim="company.name">
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
                                    v-model.trim="company.email">
                                </q-input>
                            </q-field>

                            <q-field
                                icon="mail"
                                iconColor="primary"
                                :error="errors.has('business_type_id')"
                                :error-label="errors.first('business_type_id')">
                                <q-select
                                    no-icon
                                    v-model="company.business_type_id"
                                    float-label="Ramo Atividade"
                                    :options="selectBusinessTypesOptions">
                                </q-select>
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
                        </div>
                    </form>
                </q-card-main>
            </q-card>
        </div>
    </q-layout>
</template>

<script>
  import axios from 'axios';
  import { CONFIG } from '../../../config';
  
  export default {
    name: "CompanyRegister",
    data() {
        return {
            company: {
                einssa: '',
                full_name: '',
                name: '',
                email: ''
            },
            submiting: false,
            btnSubmitLabel: "Enviar",
            selectBusinessTypesOptions: []
        }
    },

    mounted() {
        this.$store.dispatch('auth/actPageSet', ['MINHA EMPRESA', 'Inclusão']);

        axios
            .get(CONFIG.api_url + '/businessTypes/autocomplete')
            .then((results) => {
                this.selectBusinessTypesOptions = results.data;
                //console.log(this.selectBusinessTypesOptions);
            })
    },

    methods: {   
        onSubmit() {
            this.submiting = true;
            this.btnSubmitLabel = "Verificando...";

            this.$q.loadingBar.start()

            console.log(this.company);

            axios
                .post(CONFIG.api_url + '/companies', this.company)
                .then(response => {
                    //console.log('success: ', response.status);
                    //this.$router.push('/verify');
                    this.submiting = false;
                    this.btnSubmitLabel = "Verificado";

                    let company = response.data.data;
                    //console.log('company: ', company);
                        
                    this.$store.dispatch('user/actUserCompanyAdd', company);

                    this.$store.dispatch('auth/actPageSet', ['EMPRESAS', 'Pesquisa']);
                    this.$router.push('/user/companies');
                })
                .catch(error => {
                    console.log('error: ', error);
                    if (error.response.status === 422) {
                        this.$setErrorsFromResponse(error.response.data);

                        this.submiting = false;
                        this.btnSubmitLabel = "Enviar";

                        this.$q.notify({
                            message: 'Ops... encontramos alguns problemas !',
                            icon: 'warning',
                            position: 'top-right'
                        });
                    }
                });
            this.$q.loadingBar.stop();
        }
    }
}
</script>

<style>  
</style>


