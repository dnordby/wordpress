<template>
  <div class="fonts">
    <div class="splash-container" v-bind:class="[splash_visible]">
      <div class="splash-inner">
        <highlight type="h1" color="#EFE8F6" paddingtype="no-padding">
          {{ title }}
        </highlight>
      </div>
    </div>
    <div class="header-image" v-bind:class="[is_visible]">
      <image-component v-bind:image="header_image" customclass="no-expand" v-on:clicked="scrolldown(false)"></image-component>
    </div>
    <div class="grid-container">
      <r-individual-grid v-for="(array, index) in page_images" v-bind:imagelist="array" v-bind:ind="index" v-bind:key="array" v-on:setfirst="set_first" v-on:clicked="scrolldown(true)"></r-individual-grid>
    </div>
    <div class="down-button" v-bind:class="down_arrow_class" v-on:click="scrolldown(true)"><down-arrow></down-arrow></div>
    <vfooter v-bind:wait="wait" v-bind:color="footer_color" v-bind:list="footer_list" footertype="twentyfive-percent" v-bind:viewall="viewall">More {{footer_title}}</vfooter>
  </div>
</template>

<script>
  import individual_grid from '../components/organisms/individual_grid'
  import highlight from '../components/atoms/highlight_component'
  import responsive_individual_grid from '../components/organisms/responsive_individual_grid'
  import image_component from '../components/atoms/image_component'
  import footer from '../components/organisms/footer'
  import down_arrow from '../components/SVG/down_arrow'

  import scroll_reveal from '../utils/scroll_reveal'
  import sr_options from '../utils/sr_options'
  import chars from '../utils/replace_wp_chars'
  import addresses from '../utils/api_addresses'
  import vanilla_scroll from '../utils/vanilla_smooth_scroll'
  import throttle from 'lodash.throttle'
  import "babel-polyfill"
  import axios from 'axios'

  export default {
    data () {
      return {
        title: '',
        header_image: '',
        splash_visible: 'invisible',
        is_visible: 'invisible',
        page_images: [],
        footer_color: 'frost',
        footer_title: '',
        footer_list: [],
        wait: true,
        viewall: '',
        prev_scroll: 0,
        multiplier: 0,
        first_el: null,
        grids: [],
        mobile_grids: [],
        current_scrollto: null,
        current_scrollto_mobile: null,
        down_arrow_class: 'down-arrow-landing'
      }
    },
    props: ['page', 'category'],
    components: {
      'individual-grid': individual_grid,
      'r-individual-grid': responsive_individual_grid,
      'highlight': highlight,
      'image-component': image_component,
      'vfooter': footer,
      'down-arrow': down_arrow
    },
    methods: {
      check_scrolls () {
        // if window scroll is less than item offsetY, set this item as the next one to scroll to.
        for(var i = 0; i < this.grids.length; i ++) {
          if (this.grids[i].offsetTop < window.pageYOffset + 10) {
            this.current_scrollto = this.grids[i + 1]
          }
        }
      },
      check_scrolls_mobile () {
        // if window scroll is less than item offsetY, set this item as the next one to scroll to.
        for(var i = 0; i < this.mobile_grids.length; i ++) {
          if(this.mobile_grids[i].offsetTop < window.pageYOffset + 70) {
            this.current_scrollto_mobile = this.mobile_grids[i + 1]
          }
        }
      },
      setup_scroll () {
        // get elements for arrow reference
        var grids = []

        var el = document.getElementsByClassName('individual-grid')
        for(var i = 0; i < el.length; i++) {
          grids.push(el[i])
        }

        this.grids = grids

        // throttle this for performance
        window.addEventListener('scroll', throttle(this.check_scrolls, 1000/24)) // 24 fps

        // set initial value
        this.current_scrollto = this.grids[0]
      },
      setup_scroll_mobile () {
        // another that handles mobile
        var mobile_grids = []
        var mobile_el = document.getElementsByClassName('scroll-hook')
        for(var i = 0; i < mobile_el.length; i++) {
          mobile_grids.push(mobile_el[i])
        }
        this.mobile_grids = mobile_grids
        window.addEventListener('scroll', throttle(this.check_scrolls_mobile, 1000/24)) // 24 fps

        // set initial value again
        this.current_scrollto_mobile = this.mobile_grids[0]
      },
      set_first (el) {
        this.first_el = el
        this.current_scrollto = el
        this.current_scrollto_mobile = el
      },
      scrolldown (bool) {
          var context = this
          if (bool && document.body.scrollTop > window.innerHeight /2) {
            // do that arrow magic
            if(window.innerWidth > 760) {
              if(!this.current_scrollto) {
                // scroll to bottom if no element assigned
                vanilla_scroll(document.body.scrollHeight, 1200)
              } else {
                vanilla_scroll(this.current_scrollto, 1200)
              }
            } else {
              // same logic, but for mobile
              if(!this.current_scrollto_mobile) {
                vanilla_scroll(document.body.scrollHeight, 1200)
              } else {
                vanilla_scroll(this.current_scrollto_mobile, 1200)
                setTimeout(() => {
                  vanilla_scroll(window.scrollY - 60, 0)
                }, 1200)
              }   
            }

            
          } else {
            // scroll from main image to first grid
            if(window.innerWidth > 760) {
              vanilla_scroll(this.first_el, 1200)
            } else {
              vanilla_scroll(this.first_el, 1200)
              setTimeout(() => {
                vanilla_scroll(window.scrollY - 60, 0)
              }, 1200)
            }
          }
      },
      init: function () {
        //hide header image before reload
        this.is_visible = 'invisible'

        var context = this

        //get images for page (same as closer look page)
        axios.get(addresses.live_production + 'pages/?slug=' + this.page)
        .then(function(response) {
          
          //render title
          context.title = chars(response.data[0].title.rendered)

          //render header image
          var loadme = new Image()
          var header_image = response.data[0].acf.main_image.url
          loadme.onload = function () {
            context.header_image = header_image
            setTimeout(function () {
              context.is_visible = ''
            }, 600)
          }
          loadme.src = header_image

          //render grids
          var final = []
          var temp = []
          var images = response.data[0].acf.additional_images
          for (var i = 0; i < images.length; i++) {
            if(temp.length > 5) {
              final.push(temp)
              temp = []
            }
            temp.push(images[i].url)
          }
          final.push(temp)
          context.page_images = final
          setTimeout(function () {
            window.sr = scroll_reveal(sr_options)
            sr.reveal('.reveal')
            // init scroll array
            context.setup_scroll()
            context.setup_scroll_mobile()
          })
        })
      }
    },
    mounted () {

      this.viewall = '/portfolio/' + this.category

      var context = this
      //scroll handler for title
      window.addEventListener('scroll', function () {
        var vh = document.documentElement.clientHeight * 1.25
        var half_vh = document.documentElement.clientHeight * 0.4
        if (window.scrollY < half_vh && context.splash_visible !== '') {
          context.splash_visible = 'invisible'
        }
        else if (window.scrollY > vh) {
          context.splash_visible = 'half-visible'
        }
        else {
          context.splash_visible = ''
        }
      })

      setTimeout(function() {
        context.is_visible = ''
      })

      this.init()

      // get footer content once.
      axios.get(addresses.live_production + 'pages?slug=' + context.category)
      .then(function (response) {
        context.footer_title = response.data[0].title.rendered
        context.footer_list = response.data[0].acf.portfolio_link.map(function (item) {
          return {
            label: item.title,
            image: item.rollover_image.url,
            url: item.url,
          }
        })
        setTimeout(function () {
          // set navigation back to portfolio here.
          context.$emit('setnav', {
            title: context.footer_title,
            url: context.viewall.substr(1)
          })
          context.wait = false
        })
      })
    },
    watch: {
      '$route': function () {
        this.init()
      }
    }
  }
</script>

<style scoped lang="scss">
  @import '../styles/breakpoints.scss';

  .header-image {
    position: relative;
    z-index: 1;
    width: 100%;
    height: 100vh;
    transition: all 0.6s ease-in-out;
    &.invisible {
      opacity: 0;
    }
  }
  .splash-container {
    position: fixed;
    left: 0;
    width: calc(100% - 128px);
    margin-left: 128px;
    margin-top: 5vh; //20vh; //40vh
    opacity: 1;
    transition: all 0.6s ease-in-out;
    @media screen and (max-width: $mobile-grid) {
      position: absolute;
      margin-top: calc(100vh + 72px);
      width: 100%;
      margin-left: 0px;
    }
    @media screen and (min-width: 1281px) {
      width: calc(100% - 25% - 128px);
      left: 0;
      right: 0;
      margin: auto;
      margin-top: 5vh; // 20vh;
    }
    &.half-visible {
      opacity: 0.3;
    }
    &.invisible {
      opacity: 0;
    }
  }

  .splash-inner {
    position: absolute;
    z-index: -1;
    left: 0;
    width: 35%;
    text-align: left;
    @media screen and (max-width: $mobile-grid) {
      right: 0;
      margin: auto;
      width: calc(100% - 48px);
    }
    @media screen and (min-width: 1281px) {
      width: 45%;
    }
  }

  .grid-container {
    // margin-top: calc(-15% + 120px);
    padding-bottom: 120px;
    @media screen and (max-width: $tablet-size) {
      margin-top: 240px;
    }
  }

  .down-button {
    position: fixed;
    top: 0;
    right: 0;
    z-index: 1;
    margin-top: 15vh;
    margin-right: 48px;
    background: rgba(255, 255, 255, 0.75);
    padding-top: 6px;
    padding-left: 6px;
    padding-right: 6px;
    transform: scale(1.5, 1.5);
    cursor: pointer;
    @media screen and (min-width: 1281px) {
      margin-top: 20vh;
    }
    @media screen and (max-width: $mobile-size) {
      margin-right: 24px;
    }
    &.down-arrow-landing {
      margin-top: calc(100vh - 120px);
    }
  }

</style>
