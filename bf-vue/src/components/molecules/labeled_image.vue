<template>
  <!-- take out this emit and move it to the image component itself -->
  <div class="hov-container" v-bind:class="customclasses" >
    <!-- take out nopin -->
    <image-component v-bind:image="image" v-bind:customclass="imageclass" v-on:clicked="emit_clicked">
      <!-- add a popup emit event here -->
      <div v-if="type==='expand'" class="test-hov" v-on:click="emit_expand">
        <expand></expand>
      </div>
      <!-- can keep this as an emit_clicked event -->
      <div v-else class="test-hov" v-on:click="emit_clicked">
        <image-label type="normal"><slot></slot></image-label>
      </div>
    </image-component>
  </div>
</template>

<script>
  import image_label from '../atoms/image_label'
  import image_component from '../atoms/image_component'
  import expand from '../SVG/expand'
  export default {
    props: ['image', 'type', 'customclasses', 'imageclass'],
    components: {
      'expand': expand,
      'image-label': image_label,
      'image-component': image_component
    },
    methods: {
      emit_clicked () {
        this.$emit('clicked')
      },
      emit_expand () {
        this.$emit('expand')
      }
    }
  }
</script>

<style scoped lang='scss'>
  @import '../../styles/breakpoints.scss';

  .hov-container {
    display: inline-block;
    width: 500px;
    height: 300px;
    @media screen and (max-width: $mobile-size) {
      width: 100%;
      height: 240px;
    }
    &.cover {
      width: 100% !important;
      height: 100% !important;
    }
    &:hover {
      .test-hov {
        margin-bottom: 0px;
      }
    }
  }
  .test-hov {
    position: absolute;
    z-index: 1;
    bottom: 0;
    right: 0;
    margin-bottom: -96px;
    max-width: 50%;
    transition: all 0.75s ease-in-out;
    @media screen and (max-width: $tablet-size) {
      margin-bottom: 0px;
      max-width: 100%;
    }
  }
</style>