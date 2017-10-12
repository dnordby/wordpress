<template>
<div>

  <!-- v-on:click="scroll_to('second_grid')" -->
  <!-- removed internal scroll method in favor of just using parent scroll method. -->
  <div v-if="imagelist[0] || imagelist[1]" class="individual-grid first tall scroll-hook"  v-bind:class="first_grid">
     <div class="wrapper no-cover tall-wrapper"> 
      <div v-if="imagelist[0]" class="tall-image reveal alt">
        <image-component v-bind:image="imagelist[0]" customclass="no-expand" v-on:clicked="emit_clicked"></image-component>
      </div>
      <div v-if="imagelist[1]" class="tall-image bottom reveal alt query-first">
        <image-component v-bind:image="imagelist[1]" customclass="no-expand" v-on:clicked="emit_clicked"></image-component>
      </div>
     </div>
  </div>

  <!-- used to calculate space for arrow button/scrolling on mobile -->
  <div v-if="imagelist[1]" class="mobile-spacer scroll-hook"></div>

  <!-- v-on:click="scroll_to('third_grid')" -->
  <div v-if="imagelist[2]" class="individual-grid scroll-hook" v-bind:class="second_grid">
     <div class="wrapper">
      <div class="wide-image left-anchor reveal query-second">
        <image-component v-bind:image="imagelist[2]" customclass="no-expand" v-on:clicked="emit_clicked"></image-component>
      </div>
     </div>
  </div>

  <!-- v-on:click="scroll_to('fourth_grid')" -->
  <div v-if="imagelist[3] || imagelist[4]" class="individual-grid tall scroll-hook" v-bind:class="third_grid">
     <div class="wrapper no-cover tall-wrapper">
      <div v-if="imagelist[3]" class="tall-image reveal query-third">
        <image-component v-bind:image="imagelist[3]" customclass="no-expand" v-on:clicked="emit_clicked"></image-component>
      </div>
      <div v-if="imagelist[4]" class="tall-image bottom reveal">
        <image-component v-bind:image="imagelist[4]" customclass="no-expand" v-on:clicked="emit_clicked"></image-component>
      </div>
     </div> 
  </div>

  <div v-if="imagelist[4]" class="mobile-spacer scroll-hook"></div>

  <!-- v-on:click="scroll_to('next')"  -->
  <div v-if="imagelist[5]" class="individual-grid last scroll-hook" v-bind:class="fourth_grid">
     <div class="wrapper">
        <div class="wide-image reveal query-fourth">
          <image-component v-bind:image="imagelist[5]" customclass="no-expand" v-on:clicked="emit_clicked"></image-component>
        </div>
     </div>
  </div>
</div>
</template>

<script>
  import image_component from '../atoms/image_component'
  import vanilla_scroll from '../../utils/vanilla_smooth_scroll'
  import make_random_string from '../../utils/make_random_string'

  export default {
    components: {
      'image-component': image_component    
    },
    props: ['imagelist', 'ind'],
    data () {
      return {
        first_grid: make_random_string() + '-scrollhere-first',
        second_grid: make_random_string() + '-scrollhere-second',
        third_grid: make_random_string() + '-scrollhere-third',
        fourth_grid: make_random_string() + '-scrollhere-fourth',
        next_sibling: null
      }
    },
    methods: {
      emit_clicked () {
        this.$emit('clicked')
      }
    },
    mounted() {
      // set next sibling
      if(document.getElementsByClassName(this.fourth_grid).length) {
        var el = document.getElementsByClassName(this.fourth_grid)[0]
        var next_dom_sibling = el.parentElement.nextSibling
        if(next_dom_sibling) {
          this.next_sibling = next_dom_sibling.firstChild
        }
      }

      // set scroll element for parent if first grid
      if(this.ind === 0) {
        this.$emit('setfirst', document.getElementsByClassName(this.first_grid)[0])
      }
    }
  }
</script>

<style scoped lang="scss">
  @import '../../styles/breakpoints.scss';

  .mobile-spacer {
    position: absolute;
    margin-top: -420px;
    pointer-events: none;
  }

  .individual-grid {
    position: relative;
    width: calc(100% - 128px);
    margin-left: 128px;
    margin-bottom: 10%;
    padding-bottom: 50%;
    &.first {
      margin-top: 15%
    }
    @media screen and (min-width: 1281px) {
      width: 100%;
      margin-left: 0px;
    }
    @media screen and (max-width: $mobile-grid) {
      width: 100%;
      margin-left: 0px;
      margin-bottom: 0px;
      padding-bottom: 0%;
      height: 420px;
      &.tall {
        height: 840px;
      }
      &.first {
        margin-top: 0px;
      }
    }
  }
  .wrapper {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    &.tall-wrapper {
      @media screen and (max-width: 1150px) { // vertically center images better on scroll method
        margin-top: 5%;
      }
      @media screen and (max-width: $mobile-grid) {
        margin-top: auto;
      }
    }
    &.no-cover {
      @media screen and (min-width: 1281px) {
        width: calc(100% - 25% - 128px);
        left: 0;
        right: 0;
        margin: auto;
      }
    }

  }
  .tall-image {
    position: absolute;
    top: 0;
    left: 0;
    height: 80%;
    width: 35%;
    right: 0;
    @media screen and (min-width: 1281px) {
      width: 45%;
    }
    &.alt {
      @media screen and (min-width: 761px) {
        top: auto;
        bottom: 0;
      }
    }
    &.bottom {
      top: auto;
      bottom: 0;
      margin-left: calc(35% + 10%);
      &.alt {
        @media screen and (min-width: 761px) {
          top: 0;
          bottom: auto;
        }
      }
      @media screen and (min-width: 1281px) {
        left: auto;
        right: 0;
      }
      @media screen and (max-width: $mobile-grid) {
        margin-bottom: 36px;
      }
    }
    @media screen and (max-width: $mobile-grid) {
      height: calc(50% - 36px - 18px);
      margin-left: auto !important;
      margin-top: 36px;
      width: 100%;
    }
  }
  .wide-image {
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    margin: auto;
    margin-right: 0px;
    width: calc(35% + 35% + 10%);
    height: 80%;
    background: rgba( 255, 0, 0, 0.25);
    &.left-anchor {
      margin-right: auto;
      margin-left: -128px;
    }
    @media screen and (max-width: $mobile-grid) {
      margin-left: auto !important;
      margin-right: auto;
      width: 100%;
      height: 100%;
    }
  }
</style>
