<template>
    <q-input 
        @keyup.esc="searchTerms=''"
        clearable
        dense
        v-model="searchTerms" 
        label="Empresas"
        class="q-pm-xs bg-white">
        <template v-slot:before>
          <q-icon name="search" />
        </template>
    </q-input>
</template>

<script>
    import { mapState, mapActions } from 'vuex'
    export default {
        computed: {
            ...mapState('auth', ['searchCompaniesTerms']),
            searchTerms: {
                get() {
                    return this.searchCompaniesTerms
                },
                set(value) {
                    this.actSetSearchCompaniesTerms(value)
                }
            }
        },
        methods: {
            ...mapActions('auth', ['actSetSearchCompaniesTerms'])
        }
    }
</script>

<style>

</style>


