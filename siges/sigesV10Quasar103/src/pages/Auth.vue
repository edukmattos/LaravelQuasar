<template>
  <q-page class="q-pa-sm">
    <q-card class="auth-tabs">
      <q-card-section class="text-center">
        <img src="~assets/img/logo-icon.png" /> 
        <br>
        <img src="~assets/img/logo-text.png" /> 
      </q-card-section>
      
      <q-tabs
        v-model="tab"
        dense
        class="text-grey"
        active-color="primary"
        indicator-color="primary"
        align="justify"
        narrow-indicator
      >
        <q-tab name="login" label="Login" />
        <q-tab name="register" label="Registro" />
        <q-tab name="recovery" label="Acesso" />
      </q-tabs>

      <q-separator />

      <q-tab-panels v-model="tab" animated>
        <q-tab-panel name="login">
          <login-component />
        </q-tab-panel>

        <q-tab-panel name="register">
          <register-component />
        </q-tab-panel>

        <q-tab-panel name="recovery">
          <recovery-component />
        </q-tab-panel>
      </q-tab-panels>
    </q-card>
  </q-page>
</template>

<script>
  import { mapActions } from 'vuex'
  
  export default {
    data () {
      return {
        tab: 'login'
      }
    },
    methods: {
      ...mapActions('auth', ['actAuthClear']),
      ...mapActions('auth', ['actAuthUserPage']),
    },
    created() {
      this.actAuthClear()
      this.actAuthUserPage({ pageSlug:'auth', pageTitle:'Login', pageSubTitle:'Informe seu acesso' })
    },
    components: {
      'register-component' : require('components/Auth/RegisterComponent.vue').default,
      'login-component' : require('components/Auth/LoginComponent.vue').default,
      'recovery-component' : require('components/Auth/RecoveryComponent.vue').default
    }
  }
</script>

<style>
  .auth-tabs {
    max-width: 500px;
    margin: 0 auto;
  }
</style>
