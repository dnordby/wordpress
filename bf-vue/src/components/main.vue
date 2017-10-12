<template>
  <div class="main">
    <div class="router-wrapper" v-bind:class="[router_transition]">
      <router-view v-on:nav="do_nav" v-on:setnav="set_nav"></router-view>
    </div>
    <navigation v-if="this.$route.name !== 'landing'" v-on:nav="do_nav" v-bind:main="nav_route"></navigation>
  </div>
</template>

<script>
  import footer from './organisms/footer'
  import navigation from './organisms/navigation'

  import scroll_reveal from '../utils/scroll_reveal'

  export default {
    components: {
      'navigation': navigation,
      'vfooter': footer
    },
    data () {
      return {
        footer_color: 'frost',
        footer_type: 'twentyfive-percent', //can make responsive if needed.
        router_transition: '',
        nav_route: {
          title: this.$route.name,
          url: null
        }
      }
    },
    methods: {
      route_has_footer: function () {
        var no_footer = ['about', 'portfolio', 'landing']
        return no_footer.indexOf(this.$route.name.toLowerCase()) === -1
      },
      do_nav: function () {
        var context = this
        this.router_transition = 'change'
        setTimeout(function () {
          context.router_transition = ''
        }, 600)
      },
      set_nav (route) {
        this.nav_route = route
      }
    },
    mounted () {
      var context = this
      setTimeout(function () {
        document.body.scrollTop = 0;
      })
      window.onbeforeunload = function () {
        document.body.scrollTop = 0;
      }
    },
    watch: {
      $route: function () {
        this.do_nav()
        this.nav_route = {
          title: this.$route.name,
          url: null // default for all routes except when 'setnav' is emitted from individual_page
        }
      }
    }
  }
</script>

<style scoped lang='scss'>
  .router-wrapper {
    transition: opacity 0.6s ease-in-out;
    &.change {
      opacity: 0;
    }
  }
</style>
