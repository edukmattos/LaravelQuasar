<template>
  <q-item
    :to="{name: 'company-show', params: { id: company.id }}" 
    clickable
    v-ripple
    class="bg-blue-grey-1">
    <q-item-section avatar>
      <q-avatar rounded color="primary" text-color="white">
        {{ company.name }}
      </q-avatar>
    </q-item-section>
  
    <q-item-section>
      <q-item-label 
        v-html="$options.filters.searchHighlight(company.name, search)"
        :style="company.deleted ? 'text-decoration:line-through' : ''">
      </q-item-label>
      <q-item-label
        v-html="$options.filters.searchHighlight(company.full_name, search)"
        caption
        lines="1"
        :style="company.deleted ? 'text-decoration:line-through' : ''">
      </q-item-label>
    </q-item-section>

    <q-item-section side>
      <q-item-label :style="company.deleted ? 'text-decoration:line-through' : ''">{{ company.business_type.code }}</q-item-label>
    </q-item-section>
  </q-item>
</template>

<script>
  import { mapState, mapActions } from 'vuex'
  export default {
    data() {
      return {
      }
    },
    props: [
      'company',
      'id',
      'index'
    ],
    filters: {
      searchHighlight(value, search) {
        // console.log('value: ', value)
        // console.log('search: ', search)
        if (search) {
          let searchRegExp = new RegExp(search, 'i')
          return value.replace(searchRegExp, (match) => {
            return "<span class='bg-yellow-6'>" + match + "</span>"
          })
        }
        return value
      }
    },
    computed: {
      ...mapState('auth', ['search'])
    },
    methods: {
      show() {
        this.$router.push(
          {
            name: 'company-show', 
            params: this.company.id
          }
        )
      }
    }
  }
</script>

<style>

</style>


