<template>
    <q-input 
        type="text"
        id="einssa"
        label="CPF/CNPJ"
        class="col" 
        color="teal" 
        outlined
        clearable
        dense
        :value="value"
        @input="$emit('update:value', $event)"
        @keyup.esc.stop="value=''"
        :error="error"
        :error-message="errorMessage">
        <template v-slot:prepend>
            <q-icon 
                name="fingerprint"
                :color="error ? 'negative' : 'primary'" />
        </template>
    </q-input>
</template>

<script>
    export default {
        props: [
            'value',
            'error',
            'errorMessage'
        ]
    }
</script>

<style>

</style>
