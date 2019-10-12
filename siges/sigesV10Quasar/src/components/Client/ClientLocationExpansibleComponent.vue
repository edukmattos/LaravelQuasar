<template>
  <q-expansion-item
    :header-inset-level="0"
    :content-inset-level="0"
    group="location"
    default-closed
    header-class="text-primary"
    expand-icon="map"            
    v-show="!isDeleted()"
    class="bg-white">
    <template v-slot:header>
      <q-item-section>
        <q-item-label 
          v-html="$options.filters.searchHighlight(location.description, searchLocations)">
        </q-item-label>
        <q-item-label
          v-html="$options.filters.searchHighlight(location.address + ', ' + location.building + ' ' + location.building_comments + ' - ' + location.neighborhood, searchLocations)"
          caption
          lines="2">
        </q-item-label>
        <q-item-label
          v-html="$options.filters.searchHighlight(location.city + '/' + location.state + ' - CEP: ' + location.zip_code, searchLocations)"
          caption
          lines="2">
        </q-item-label>
        <q-item-label
          v-html="$options.filters.searchHighlight(location.email, searchLocations)"
          caption
          lines="2">
        </q-item-label>
        <q-item-label
          v-html="$options.filters.searchHighlight(location.mobile + ' ' + location.phone, searchLocations)"
          caption
          lines="2">
        </q-item-label>
      </q-item-section>
    </template>
    
    <q-card>
      Teste {{ id }} {{ location.description }}
    </q-card>

  </q-expansion-item>
</template>

<script>
  import { mapState, mapActions } from 'vuex'
  export default {
    data() {
      return {
        //client_locations: []
      }
    },
    props: [
      'location',
      'id'
    ],
    filters: {
      searchHighlight(value, searchLocations) {
        // console.log('value: ', value)
        // console.log('search: ', search)
        if (searchLocations) {
          let searchRegExp = new RegExp(searchLocations, 'i')
          return value.replace(searchRegExp, (match) => {
            return "<span class='bg-yellow-6'>" + match + "</span>"
          })
        }
        return value
      }
    },
    computed: {
      ...mapState('clients', ['searchLocations'])
    },
    methods: {
      isDeleted() {
        //return this.location.deleted
      }
      //show() {
      //  this.$router.push(
      //    {
      //      name: 'location-show', 
      //      params: { 
      //        id: location.id 
      //      }
      //    }
      //  )
      //}
    }
  }
</script>

<style>

</style>


