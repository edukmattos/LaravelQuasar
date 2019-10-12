<template>
    <q-input 
        @keyup.esc="searchTerms=''"
        clearable
        dense
        v-model="searchTerms" 
        label="Setores"
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
            ...mapState('company_sectors', ['search']),
            searchTerms: {
                get() {
                    return this.search
                },
                set(value) {
                    this.actSetSearchCompaniesTerms(value)
                }
            }
        },
        methods: {
            ...mapActions('company_sectors', ['actSetSearchCompaniesTerms'])
        }
    }
</script>

<style>

</style>


