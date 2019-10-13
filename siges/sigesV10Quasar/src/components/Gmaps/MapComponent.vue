<template>
  <GmapMap style="width: auto; height: 240px;" 
    :zoom="18" 
    :center="{
      lat: +location.lat, 
      lng: +location.lng
    }"
    :options="{
      zoomControl: false,
      mapTypeControl: false,
      scaleControl: false,
      streetViewControl: false,
      rotateControl: false,
      fullscreenControl: false,
      disableDefaultUi: false
    }"
  >
    <GmapMarker
      :position="google && new google.maps.LatLng(+location.lat, +location.lng)"
    />
    <GmapMarker/>
  </GmapMap>
</template>

<script>
  import { gmapApi } from 'vue2-google-maps'

  export default {
    data() {
      return {
      }
    },
    props: [
      'location'
    ],
    computed: {
      google: gmapApi
    }
  }
</script>

<style>

</style>


