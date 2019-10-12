<template>
    <dashboard-user-companies-total-component :key="componentKey" title="Empresas" :total="getAuthUserCompaniesTotal" />
</template>

<script type="text/javascript">
    import { mapGetters } from 'vuex'
    
    export default {
        data() {
            return {
                componentKey: 0
            }
        },
        components: {
            'dashboard-user-companies-total-component': require('components/Dashboard/User/CompaniesTotalCardComponent.vue').default
        },
        computed: {
            ...mapGetters('auth', ['getAuthUserCompaniesTotal'])
        }
    }
</script>
<style></style>

