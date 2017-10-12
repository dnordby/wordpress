<template>
  <div v-on:click="share">
    <pinterest></pinterest>
  </div>
</template>

<script>
  import pinterest from '../SVG/pinterest'
  export default {
    props: ['image'],
    components: {
      'pinterest': pinterest
    },
    methods: {
      share () {
        var website = 'bandf8440.wpengine.com'
        var image = this.image.replace('https://', '').replace(website, '')
        console.log(image)
        var url = "http://www.pinterest.com/pin/create/bookmarklet/?url=https%3A%2F%2F" + website + "%2Ftitle-of-the-pin%2F&media=https%3A%2F%2F" + website + "%2F" + image + "&is_video=false" //"&description=Some+additional+text+to+accompany."
        window.open(url, null, "height=500, width=600")
      }
    },
  }
</script>
