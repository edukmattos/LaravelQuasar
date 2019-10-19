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
      :draggable="markerDraggable"
    />
    <GmapInfoWindow :opened:"false">
                I can use <b>HTML</b> here and expressions too !<br>
                I am not bound to any markers. I'm freeee.
            </GmapInfoWindow>
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
      'location',
      'markerDraggable'
    ],
    computed: {
      google: gmapApi
    }
  }
</script>

<style>

</style>


