<template>
  <div class="contact-social">
    <div class="subheader">Follow Us</div>
    <facebook v-if="facebook_url" v-on:clicked="external('facebook_url')"></facebook>
    <instagram v-if="instagram_url" v-on:clicked="external('instagram_url')"></instagram>
    <twitter v-if="twitter_url" v-on:clicked="external('twitter_url')"></twitter>
    <pinterest v-if="pinterest_url" v-on:clicked="external('pinterest_url')"></pinterest>
    <dering-hall v-if="dering_hall_url" v-on:clicked="external('dering_hall_url')"></dering-hall>
    <houzz v-if="houzz_url" v-on:clicked="external('houzz_url')"></houzz>
  </div>
</template>

<script>
  import facebook from '../SVG/facebook'
  import instagram from '../SVG/instagram'
  import twitter from '../SVG/twitter'
  import pinterest from '../SVG/pinterest'
  import dering_hall from '../SVG/dering_hall'
  import houzz from '../SVG/houzz'

  import addresses from '../../utils/api_addresses'
  import "babel-polyfill";
  import axios from 'axios'

  export default {
    data () {
      return {
        instagram_url: '',
        facebook_url: '',
        twitter_url: '',
        pinterest_url: '',
        houzz_url: '',
        dering_hall_url: ''
      }
    },
    methods: {
      external: function (str) {
        window.open(this[str])
      }
    },
    components: {
      'instagram': instagram,
      'facebook': facebook,
      'twitter': twitter,
      'pinterest': pinterest,
      'houzz': houzz,
      'dering-hall': dering_hall
    },
    mounted () {
      var context = this
      axios.get(addresses.live_production + 'pages?slug=navigation')
      .then(function (response) {
        var acf = response.data[0].acf
        context.instagram_url = acf.instagram_url
        context.facebook_url = acf.facebook_url
        context.twitter_url = acf.twitter_url
        context.pinterest_url = acf.pinterest_url
        context.houzz_url = acf.houzz_url
        context.dering_hall_url = acf.dering_hall_url
      })
    }
  }
</script>

<style sceoped lang='scss'>
  .contact-social {
    display: flex;
    justify-content: flex-start;
    margin-bottom: 24px;
    .subheader {
      margin-right: 12px;
    }
    svg {
      margin-left: 12px;
      margin-right: 12px;
    }
  }
</style>