<template>
  <q-page padding>
    <!-- content -->
      <q-list striped-odd dense no-border inset-separator>
      <q-item link multiline v-for="(company, index) in companies" :key="index" :to="'/user/companies/' + company.id + '/show'">
        <q-item-side avatar="assets/img/companies/1.png" />
        <q-item-main>
          <q-item-tile label-lines="1" label>{{ company.name }}</q-item-tile>
          <q-item-tile sublabel-lines="1" sublabel>{{ company.full_name }}</q-item-tile>
          <q-item-tile sublabel-lines="1" sublabel>{{ company.einssa }}</q-item-tile>
        </q-item-main>
      </q-item>
    </q-list>

    <q-page-sticky position="top-right" :offset="[18, 18]">
      <q-btn 
        round 
        color="primary" 
        icon="group">
        <q-chip floating color="red">{{ companiesFilterCounter }}</q-chip>
      </q-btn>
    </q-page-sticky>

    <q-page-sticky position="bottom-right" :offset="[18, 18]">
      <q-btn
        round
        color="secondary"
        @click="goToPageCompaniesNew"
        icon="add"/>
    </q-page-sticky>
  </q-page>
  
</template>

<script>
  import { mapGetters } from 'vuex'
  export default {
    data() {
      return {
        search_terms: '' 
      }
    },
    mounted() {
      this.$store.dispatch('auth/actPageSet', ['MINHAS EMPRESAS', '']);
      //this.$store.dispatch('user/actUserCompaniesAll');
      return this.$store.getters['user/getUserCompaniesAll']; 
    },
    methods: {
      ...mapGetters('auth', ['getAuthUserCompanies']),
      companyShow () {
        //alert('OK');
        this.$store.dispatch('auth/actPageSet', ['EMPRESA', 'Consulta']);
      },
      goToPageCompaniesNew () {
        this.$router.push('/user/companies/new');
      }
    },
    computed: {
      companies() {
        return this.getAuthUserCompanies()
        //console.log(this.$store.getters['user/getUserCompanies']);
        // return this.$store.getters['user/getUserCompaniesAll'];   
      },
      companiesFilter() {
        let search_terms = this.search_terms.trim().toLowerCase();
        if (search_terms === '') return this.$store.getters['user/getUserCompaniesAll'];
        return this.$store.getters['user/getUserCompaniesAll'].filter((user) => {
          return user.name.toLowerCase().indexOf(search_terms) > -1 || user.address.toLowerCase().indexOf(search_terms) > -1 || user.mobile.toLowerCase().indexOf(search_terms) > -1;
        });
      },
      companiesFilterCounter() {
        //return this.companiesFilter.length;
      }
    }
  }
</script>

<style>
</style>
