<template>
  <q-page padding>
    <div class="q-pa-sm">
      <div class="item">
        <customers-total-component 
          title="Clientes" 
          iconName="people"
          :total="getCustomersTotal" 
          backgroundColor="secondary"
          textColor="white">
        </customers-total-component>
      </div>

      <div>
        <materials-total-component 
          title="Materiais" 
          iconName="all_inbox"
          :total="getMaterialsTotal" 
          backgroundColor="primary"
          textColor="white">
        </materials-total-component>
      </div>

      <div>
        <users-total-component 
          title="Usuarios" 
          iconName="all_inbox"
          :total="getUsersTotal" 
          backgroundColor="green"
          textColor="white">
        </users-total-component>
      </div> 

      <div>
        <employees-total-component 
          title="Funcionários" 
          iconName="people"
          :total="getEmployeesTotal" 
          backgroundColor="info"
          textColor="white">
        </employees-total-component>
      </div>
    </div> 
  </q-page>
</template>

<script>
import CustomersTotalComponent from '../components/customers/Total';
import MaterialsTotalComponent from '../components/materials/Total';
import UsersTotalComponent from '../components/users/Total';
import EmployeesTotalComponent from '../components/employees/Total';

export default {
  // name: 'PageName',
  components: {
    CustomersTotalComponent,
    MaterialsTotalComponent,
    UsersTotalComponent,
    EmployeesTotalComponent
  },
  computed: {
    getCustomersTotal() {
      return this.$store.getters['customers/getCustomersTotal'];
    },
    getMaterialsTotal() {
      return this.$store.getters['materials/getMaterialsTotal'];
    },
    getUsersTotal() {
      return this.$store.getters['users/getUsersTotal'];
    },
    getEmployeesTotal() {
      return this.$store.getters['employees/getEmployeesTotal'];
    }
  },
  mounted () {
    this.$store.dispatch('customers/actCustomersAll');
    this.$store.dispatch('materials/actMaterialsAll');
    this.$store.dispatch('users/actUsersAll');
    this.$store.dispatch('employees/actEmployeesAll');
  }
}
</script>

<style>
</style>
