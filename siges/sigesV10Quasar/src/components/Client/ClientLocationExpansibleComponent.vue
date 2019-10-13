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
    
    <div class="q-pa-xs">
      <q-carousel
        swipeable
        animated
        v-model="slide"
        thumbnails
        infinite
      >
        <q-carousel-slide :name="1" img-src="https://cdn.quasar.dev/img/mountains.jpg" />
        <q-carousel-slide :name="2" img-src="https://cdn.quasar.dev/img/parallax1.jpg" />
        <q-carousel-slide :name="3" img-src="https://cdn.quasar.dev/img/parallax2.jpg" />
        <q-carousel-slide :name="4" img-src="https://cdn.quasar.dev/img/quasar.jpg" />

        <template v-slot:control>
        <q-carousel-control
          position="bottom-right"
          :offset="[18, 18]"
        >
          <q-btn
            push round dense color="white" text-color="primary"
            :icon="fullscreen ? 'fullscreen_exit' : 'fullscreen'"
            @click="fullscreen = !fullscreen"
          />
        </q-carousel-control>
      </template>
      </q-carousel>
    </div>

    <q-card class="q-pa-xs">
      <map-component 
        :location="location"  
      />

      <q-card-actions align="around">
        <q-btn flat round color="red" icon="favorite" />
        <q-btn flat round color="teal" icon="bookmark" />
        <q-btn flat round color="primary" icon="share" />
      </q-card-actions>
    </q-card>
    
  </q-expansion-item>
</template>

<script>
  import { mapState, mapActions } from 'vuex'

  export default {
    data() {
      return {  
        slide: 1,
        fullscreen: false      
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
    },
    components: {
      'map-component': require('components/Gmaps/MapComponent.vue').default
    }
  }
</script>

<style>

</style>


