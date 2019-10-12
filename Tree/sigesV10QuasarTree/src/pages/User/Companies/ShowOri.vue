<template>
    <q-layout view="hHh Lpr lFf">
        <q-page padding>
            <q-card color="white" text-color="primary">
                <q-item>
                    <q-item-main>
                        <q-item-tile label>{{ company.name }}</q-item-tile>
                        <q-item-tile sublabel>{{ company.full_name }}</q-item-tile>
                        <q-item-tile sublabel>{{ company.einssa }}</q-item-tile>
                    </q-item-main>
                    <q-item-side right>
                        <q-btn flat color="primary" label="Entrar" @click.prevent="onSubmit()"/>
                    </q-item-side>
                </q-item>
                <q-card-separator />
                <q-card-actions>
                    <q-btn flat round dense icon="event" />
                    <q-btn flat label="5:30PM" />
                    <q-btn flat label="7:30PM" />
                    <q-btn flat label="9:00PM" />
                </q-card-actions>
            </q-card>      
        </q-page>
    </q-layout>  
</template>

<script>
    import axios from 'axios';
    import { CONFIG } from '../../../config';
    import { SessionStorage } from 'quasar';
    
    export default {
        data() {
            return {
                company: this.$store.getters['user/getUserCompanyById'](this.$route.params.id)
            }
        },
        mounted() {
            this.$store.dispatch('auth/actPageSet', ['MINHA EMPRESA', '']);
        },
        methods: {      
            onSubmit() {
                SessionStorage.set('company', this.company);
    
                axios
                    .get(CONFIG.api_url + '/tenant/' + company.id)
                    .then((response) => {
                        return response;
                    })
            }
        }
    }
</script>

<style>
</style>
