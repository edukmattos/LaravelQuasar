<template>
    <q-input 
        @keyup.esc="searchTerms=''"
        dense
        v-model="searchTerms" 
        label="Filtrar"
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
            ...mapState('auth', ['search']),
            searchTerms: {
                get() {
                    return this.search
                },
                set(value) {
                    this.actSetSearch(value)
                }
            }
        },
        methods: {
            ...mapActions('auth', ['actSetSearch'])
        }
    }
</script>

<style>

</style>


