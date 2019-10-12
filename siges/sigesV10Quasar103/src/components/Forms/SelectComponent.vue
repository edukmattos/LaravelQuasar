<template>
    <q-select
        type="text"
        :id="id"
        :label="textLabel"
        class="col" 
        color="teal"
        outlined
        dense
        options-dense
        :value="value"
        @input="$emit('update:value', $event)"
        use-input
        fill-input   
        hide-selected
        transition-show="flip-up"
        transition-hide="flip-down"
        autocomplete="off"         
        :options="filterOptions"
        @filter="filterFn"
        map-options
        emit-value
        behavior="menu"
        :error="error"
        :error-message="errorMessage"
    >
        <template v-slot:prepend>
            <q-icon 
                :name="iconName"
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
    export default {
        data() {
            return {
                filterOptions: []
            }
        },
        props: {
            id: String,
            textLabel: String,
            value: [String, Number, Array, Object],
            iconName: String,
            error: Boolean,
            errorMessage: String,
            selectOptions: Array,
            options: Array
        },
        methods: {
            filterFn (val, update) {
                update(() => {
                    if (val === '') {
                        this.filterOptions = this.selectOptions
                    }
                    else {
                        const needle = val.toLowerCase()
                        //console.log(needle)
                        this.filterOptions = this.selectOptions.filter(v => v.label.toLowerCase().indexOf(needle) > -1)
                    }
                })
            }
        }
    }
</script>

<style>

</style>

