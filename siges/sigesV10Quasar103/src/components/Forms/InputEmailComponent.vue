<template>
    <q-input 
        type="email"
        :id="id"
        :label="textLabel"
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
                :name="iconName"
                :color="error ? 'negative' : 'primary'" />
        </template>
    </q-input>
</template>

<script>
    export default {
        props: {
            id: String,
            textLabel: String,
            value: String,
            iconName: String,
            error: Boolean,
            errorMessage: String
        },
    }
</script>

<style>

</style>
