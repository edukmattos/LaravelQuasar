<template>
    <div class="q-pa-sm row items-start q-gutter-sm">
    <q-card class="my-card bg-secondary text-white">
      <q-card-section>
        <div class="text-h3">{{ total }}</div>
        <div class="text-subtitle2">{{ title }}</div>
      </q-card-section>

      <q-card-section>
     
      </q-card-section>

      <q-separator dark />

      <q-card-actions>
        <q-btn flat to="/user/companies">ver</q-btn>
      </q-card-actions>
    </q-card>

    
    </div>
</template>

<script>
    export default {
        data () {
            return {
                options: {
                    separator: '.'
                }
            }
        },
        props: [
            'title', 
            'total', 
            'backgroundColor', 
            'iconName'
        ],
        watch: {
            total () {
                //this.countUp.start()
            }
        }
    }
</script>

<style scoped>
  i {
    font-size: 54px;
  }
</style>