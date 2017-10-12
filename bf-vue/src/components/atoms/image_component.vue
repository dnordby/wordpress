<template>
  <div class="noshadow-container" v-bind:class="[has_overlay, reveal, customclass]" v-bind:style="container_style">
    <!-- add emit events at this level -->
    <slot></slot>
    <div v-if="!nopin" class="pinthis-container">
      <pinthis v-bind:image="image"></pinthis>
    </div>
    <div class="image-background" v-bind:class="[customclass, loaded]" v-bind:style="[background_image, scan_image]" v-on:click="emit_clicked"></div> 
    <div class="image-loader" v-bind:class="loaded" v-on:click="emit_clicked"></div> 
    <div v-if="overlay !== undefined" v-bind:style="overlay_image" class="overlay" v-on:click="emit_clicked"></div> 
  </div>
</template>

<script>
  import make_random_string from '../../utils/make_random_string'
  import pinthis from './pinthis'

  export default {
    data () {
      return {
        container_style: {
          "height": this.height,
          "width": this.width
        },
        has_overlay: this.overlay === undefined ? 'shadow-container' : 'noshadow-container',
        background_image: {},
        scan_image: {},
        overlay_image: {
          "background-image" : "url('" + this.overlay + "')"
        },
        loaded: '',
      }
    },
    methods: {
      emit_clicked () {
        this.$emit('clicked')
      }
    },
    props: ['image', 'overlay', 'height', 'width', 'hoveredstate', 'customclass', 'reveal', 'scan', 'nopin'],
    components: {
      'pinthis': pinthis
    },
    mounted () {
      var context = this
      var downloadingImage = new Image()
      downloadingImage.onload = function(){
        context.background_image = { "background-image" : "url('" + context.image + "')" }
        context.loaded = 'finished'
      }
      downloadingImage.src = this.image; 
      if(this.scan === true) {
        this.scan_image = {
          'background-size': 'contain !important'
        }
      }
    },
    watch: {
      image: function () {
        var context = this
        context.overlay_image = {
          "background-image" : "url('" + this.overlay + "')"
        }
        var context = this
        var downloadingImage = new Image()
        downloadingImage.onload = function(){
          context.background_image = { "background-image" : "url('" + context.image + "')" }
          context.loaded = 'finished'
        }
        downloadingImage.src = this.image; 
      }
    }
  }
</script>

<style scoped lang="scss">
  @import '../../styles/colors.scss';
  @import '../../styles/breakpoints.scss';

  .shadow-container, .noshadow-container {
    position: relative;
    margin: auto;
    width: 100%;
    height: 100%;
    overflow: hidden;
    transition: all 1.2s ease-in-out;
    cursor: pointer;
    user-select: none;
    //ADD BACK IN SOON
    // opacity: 0;
    // transform: translateY(50%);
    &:hover, &.hovered {
      .image-background {
        transform: scale(1.05, 1.05);
        //this is messing up our expand icon ~980-1000 on desktop, and all over tablet/mobile, but only sometimes...
        //one workaround would be to rotate the icons manually instead of in css.
        //TODO -> REDO EXPAND ICONS
        &.no-expand {
          transform: none;
        }
      }
      .pinthis-container {
        opacity: 1;
        margin-top: 12px;
      }
    }
  }
  .shadow-container {
    &:hover {
      box-shadow: 0 2px 20px 0 rgba(0, 0, 0, 0.5);
      &.no-expand {
        box-shadow: none;
      }
      &.noshadow-override {
        box-shadow: none;
      }
    }
  }
  .image-background {
    width: 100%;
    height: 100%;
    margin: auto;
    background: white;
    background-size: cover;
    // background-size: contain;
    background-repeat: no-repeat;
    background-position: center center;
    opacity: 0;
    cursor: pointer;
    // transition: all 0.85s ease-in-out;
    transition: all 1s ease-in-out;
    &.finished {
      opacity: 1;
    }
  }
  .overlay {
    position: absolute;
    pointer-events: none;
    width: 100%;
    height: 100%;
    bottom: 0;
    left: 0;
    right: 0;
    margin: auto;
    opacity: 1;
    // background-size: 150px auto;
    background-size: 230px auto;
    background-position: center center;
    background-repeat: no-repeat;
    background-color: rgba(0, 0, 0, 0.3);
    transition: all 0.6s ease-in-out;
  }

  .image-loader {
    position: absolute;
    pointer-events: none;
    width: 100%;
    height: 100%;
    background: $salt;
    top: 0;
    left: 0;
    transition: all 0.6s ease-in-out;
    &.finished {
      opacity: 0;
      // pointer-events: none;
    }
  }

  .pinthis-container {
    position: absolute;
    z-index: 1;
    top: 0;
    right: 0;
    margin-right: 12px;
    margin-top: -48px;
    padding-top: 6px;
    padding-left: 6px;
    padding-right: 6px;
    background: white;
    transition: all 0.75s ease-in-out; // match expand transition
    opacity: 0;
    transform: scale(1.15, 1.15);
    &:hover {
      transform: scale(1.25, 1.25);
    }
    @media screen and (max-width: 1150px /*$tablet-size*/) {
      opacity: 1;
      margin-top: 12px;
    }
  }
</style>