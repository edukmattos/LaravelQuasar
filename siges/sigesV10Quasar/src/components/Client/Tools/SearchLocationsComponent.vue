<template>
    <q-input 
        @keyup.esc="searchTerms=''"
        rounded 
        outlined 
        dense 
        class="q-mr-xs" 
        bg-color="white" 
        v-model="searchTerms" 
        placeholder="Filtrar"
        clearable>
        <template v-slot:prepend>
            <q-icon name="search" />
        </template>
    </q-input>
</template>

<script>
    import { mapState, mapActions } from 'vuex'
    export default {
        computed: {
            ...mapState('clients', ['searchLocations']),
            searchTerms: {
                get() {
                    return this.searchLocations
                },
                set(value) {
                    this.actSetSearchLocations(value)
                }
            }
        },
        methods: {
            ...mapActions('clients', ['actSetSearchLocations'])
        }
    }
</script>

<style>

</style>


