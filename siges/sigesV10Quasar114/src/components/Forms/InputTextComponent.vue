<template>
    <q-input 
        type="text"
        :id="id"
        :label="textLabel"
        class="col" 
        color="teal" 
        outlined
        :clearable="clearable"
        dense
        :value="value"
        @input="$emit('update:value', $event)"
        @keyup.esc.stop="value=''"
        :error="error"
        :error-message="errorMessage"
        :mask="mask"
        mask-hint="Mask: ###/##">
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
            mask: String,
            value: String,
            iconName: String,
            clearable: Boolean,
            error: Boolean,
            errorMessage: String
        },
    }
</script>

<style>

</style>
