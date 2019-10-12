<template>
    <q-select
        type="text"
        id="business_type_id"
        label="Ramo Atividade"
        class="col" 
        color="teal"
        outlined
        clearable
        dense
        options-dense
        :value="value"
        @input="$emit('update:value', $event)"
        use-input
        hide-selected
        fill-input   
        transition-show="flip-up"
        transition-hide="flip-down"
        autocomplete="off"         
        :options="filterOptions"
        @filter="filterFn"
        input-debounce="0"
        map-options
        emit-value
        :error="error"
        :error-message="errorMessage"
    >
        <template v-slot:prepend>
            <q-icon 
                name="mail"
                :color="error ? 'negative' : 'primary'" />
        </template>
                    
        <template v-slot:no-option>
            <q-item>
                <q-item-section class="text-grey">
                    Sem registros
                </q-item-section>
            </q-item>
        </template>
    </q-select>
</template>

<script>
    import axios from 'axios'
    import { CONFIG } from '../../../../config'
    
    export default {
        data() {
            return {
                selectBusinessTypesOptions: [],
                filterOptions: []
            }
        },
        props: [
            'value',
            'error',
            'errorMessage'
        ],
        mounted() {
            axios
                .get(CONFIG.api_url + '/businessTypes/autocomplete')
                .then((results) => {
                    this.selectBusinessTypesOptions = results.data;
                    // console.log(this.selectBusinessTypesOptions);
                })
        },
        methods: {
            filterFn (val, update) {
                update(() => {
                    if (val === '') {
                        this.filterOptions = this.selectBusinessTypesOptions
                    }
                    else {
                        const needle = val.toLowerCase()
                        // console.log(needle)
                        this.filterOptions = this.selectBusinessTypesOptions.filter(v => v.label.toLowerCase().indexOf(needle) > -1)
                    }
                })
            }
        }
    }
</script>

<style>

</style>
