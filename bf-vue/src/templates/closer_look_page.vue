<template>
  <div class="fonts">

    <div class="header-wrapper">
      <div class="page-header" v-bind:class="[is_visible]">
        <dropdown category="A Closer Look" v-bind:subcategory="page_title" v-bind:list="navigation_list" v-on:clicked="nav_to_closer_look"></dropdown>
        <div class="page-description">
          <div class="p">
            {{page_description}}
          </div>
        </div>
      </div>
    </div>

    <r-featured-grid v-for="array in page_images" type="image" v-on:clicked="scrolldown" v-on:expand="open_popup" v-bind:imagelist="array" v-bind:key="array"></r-featured-grid>

    <div class="load-more">
      <div v-if="page_queue.length" class="load-more-hook">
        <vbutton v-if="page_queue.length" type="standard" v-on:clicked="load_more">Load More</vbutton>
      </div>
    </div>

    <div class="down-button" v-on:click="scrolldown"><down-arrow></down-arrow></div>

    <vfooter v-bind:wait="wait" v-bind:color="footer_color" v-bind:list="footer_list" footertype="twentyfive-percent"  v-on:nav="emit_nav">See More</vfooter>

    <popup v-bind:inactive="popup_state" v-on:clicked="close_popup" v-bind:imagelist="current_image_list" v-bind:wait="wait" type="popup-swiper"></popup>

  </div>
</template>

<script>
  import featured_grid from '../components/organisms/featured_grid'
  import dropdown from '../components/molecules/dropdown'
  import button from '../components/atoms/button'
  import responsive_featured_grid from '../components/organisms/responsive_featured_grid'
  import popup from '../components/organisms/popup'
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
    components: {
      'featured-grid': featured_grid,
      'dropdown': dropdown,
      'vbutton': button,
      'r-featured-grid': responsive_featured_grid,
      'popup': popup,
      'vfooter': footer,
      'down-arrow': down_arrow
    },
    data () {
      return {
        page_title: '',
        navigation_list: [],
        popup_state: 'inactive',
        is_visible: 'invisible',
        current_image_list: [],
        wait: true,
        page_images: [],
        page_queue: [],
        footer_color: 'chiffon',
        footer_list: [],
        footer_title: '',
        page_description: '',
        grids: [],
        grids_mobile: [],
        current_scrollto: null,
        current_scrollto_mobile: null
      }
    },
    props: ['page'],
    methods: {
      emit_nav: function () {
        this.$emit('nav')
      },
      open_popup: function (image) {
        this.current_image_list = [image]
        this.popup_state = ''
      },
      close_popup: function () {
        this.popup_state = 'inactive'
      },
      nav_to_closer_look: function (url) {
        this.$emit('nav')
        var context = this
        setTimeout(function () {
          document.body.scrollTop = 0; 
          context.$router.push({
            path: '/closer-look/' + url
          })
        }, 600)
      },
      load_more: function () {
        //render images from queue
        //capture stopping point to scroll to.
        var old_length = this.grids.length
        var context = this
        this.page_images.push(this.page_queue[0])
        this.page_images.push(this.page_queue[1])
        this.page_images.push(this.page_queue[2])
        this.page_queue = this.page_queue.slice(3)
        setTimeout(function () {
          sr.reveal('.reveal')
          // re init array here.
          context.setup_scroll(false)
          context.setup_scroll_mobile(false)
          // scroll to newly loaded images after render.
          setTimeout(() => {
            vanilla_scroll(context.grids[old_length], 1200)
          })
        })
      },
      init_sr: function () {
        window.sr = scroll_reveal(sr_options)
        sr.reveal('.reveal')
      },
      scroll_to_bottom () {
        if(document.getElementsByClassName('load-more-hook').length) {
          // scroll to load more button
          vanilla_scroll(document.getElementsByClassName('load-more-hook')[0], 1200)
        } else {
          // scroll to bottom
          vanilla_scroll(document.body.scrollHeight, 1200)
        }
      },
      scrolldown () {
        var context = this
        if(window.innerWidth > 760) {
          if(!this.current_scrollto) {
            this.scroll_to_bottom()
          } else {
            vanilla_scroll(this.current_scrollto, 1200)
          }
        } else {
          // same logic, but for mobile
          if(!this.current_scrollto_mobile) {
            this.scroll_to_bottom()
          } else {
            vanilla_scroll(this.current_scrollto_mobile, 1200)
            setTimeout(() => { // lazy fix handle navbar spacing
              vanilla_scroll(window.scrollY - 60, 0)
            }, 1200)
          }   
        }
      },
      check_scrolls () {
        // if window scroll is less than item offsetY, set this item as the next one to scroll to.
        for(var i = 0; i < this.grids.length; i ++) {
          if (this.grids[i].offsetTop < window.pageYOffset + 10) {
            this.current_scrollto = this.grids[i + 1]
          }
        }
        // get mobile
        for(var j = 0; j < this.grids_mobile.length; j ++) {
          if (this.grids_mobile[j].offsetTop < window.pageYOffset + 70) { // 70 to account for navbar
            this.current_scrollto_mobile = this.grids_mobile[j + 1]
          }
        }
      },
      setup_scroll (bool) {
        // get elements for arrow reference
        var context = this
        var grids = []
        var el = document.getElementsByClassName('scroll-hook')
        for(var i = 0; i < el.length; i++) {
          grids.push(el[i])
        }
        this.grids = grids
        if(bool) { // run first time
          this.current_scrollto = this.grids[0]
          window.addEventListener('scroll', throttle(this.check_scrolls, 1000/24)) // 24 fps
        } 
      },
      setup_scroll_mobile (bool) {
        // same as desktop, just different selector
        var context = this
        var grids = []
        var el = document.getElementsByClassName('scroll-hook-mobile')
        for(var i = 0; i < el.length; i++) {
          grids.push(el[i])
        }
        this.grids_mobile = grids
        if(bool) { // run first time
          this.current_scrollto_mobile = this.grids_mobile[0]
        } 
      },
      init: function () {
        this.wait = true
        var context = this

        //set page title, set slider images
        axios.get(addresses.live_production + 'pages/?slug=' + this.page)
        .then(function(response) {
          context.page_description = response.data[0].acf.page_description
          //REPLACE WP CHARACTERS
          context.page_title = chars(response.data[0].title.rendered)

          //set navigation links and footer links.
          axios.get(addresses.live_production + 'pages/?slug=navigation')
          .then(function (response) {
            var nav_links = response.data[0].acf.closer_look_navigation
            context.navigation_list = nav_links.filter(function(item) {
              return item.title !== context.page_title
            })
            context.footer_list = nav_links.map(function (item) {
              return {
                label: item.title,
                image: item.rollover_image.url,
                url: item.url,
              }
            })
            setTimeout(function () {
              context.wait = false
            })
          })

        })

        //get images for page
        axios.get(addresses.live_production + 'pages/?slug=' + this.page)
        .then(function (response) {
          var final = []
          var temp = []
          var images = response.data[0].acf.image
          for (var i = 0; i < images.length; i++) {
            if(temp.length > 3) {
              final.push(temp)
              temp = []
            }
            temp.push(images[i].main_image.url)
          }
          final.push(temp)
          context.page_images = [final[0], final[1], final[2]]
          context.page_queue = final.slice(3)
          setTimeout(function() {
            context.init_sr()
          })
          setTimeout(function() {
            context.is_visible = ''
            // init scroll
            context.setup_scroll(true)
            context.setup_scroll_mobile(true)
          }, 600)
        })
      }
    },
    watch: {
      '$route': function () {
        this.init()
      }
    },
    mounted () {
      this.init()
    }
  }
</script>

<style scoped lang="scss">
  @import '../styles/breakpoints.scss';
  @import '../styles/page_headers.scss';

  .load-more {
    position: relative;
    display: inline-block;
    margin-top: calc(120px - 108px);
    margin-bottom: 120px;
    @media screen and (max-width: $tablet-size) {
      margin-top: 48px;
      margin-bottom: 48px;
    }
  }

  .header-wrapper {
    width: 100%;
    @media screen and (min-width: 1281px) {
      width: calc(100% - 10%);
      margin-left: 10%;
    }
  }

  .down-button {
    position: fixed;
    top: 0;
    right: 0;
    // margin-top: 15vh;
    z-index: 1;
    margin-top: calc(144px + 12px);
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
    @media screen and (max-width: $mobile-grid) {
      margin-top: calc(144px + 48px);
      margin-right: 20px;
    }
  }
</style>
