<template>
    <q-input 
        :type="isPwd ? 'password' : 'text'"
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
                :name="isPwd ? 'visibility_off' : 'visibility'"
                :color="error ? 'negative' : 'primary'" 
                @click="isPwd = !isPwd" />
        </template>
    </q-input>
</template>

<script>
    export default {
        data () {
            return {
                isPwd: true
            }
        },
        props: {
            id: String,
            textLabel: String,
            value: String,
            error: Boolean,
            errorMessage: String
        },
    }
</script>

<style>

</style>
