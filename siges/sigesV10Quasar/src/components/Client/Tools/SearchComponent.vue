<template>
    <q-input 
        @keyup.esc="searchTerms=''"
        rounded 
        outlined 
        dense 
        class="q-mr-xs" 
        bg-color="white" 
        v-model="searchTerms" 
        placeholder="Filtrar">
        <template v-slot:prepend>
            <q-icon name="search" />
        </template>
    </q-input>
</template>

<script>
    import { mapState, mapActions } from 'vuex'
    export default {
        computed: {
            ...mapState('clients', ['search']),
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
            ...mapActions('clients', ['actSetSearch'])
        }
    }
</script>

<style>

</style>


