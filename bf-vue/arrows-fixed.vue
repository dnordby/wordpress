<template lang='pug'>
  div(class='arrow-container text')
    div(class='left-arrow' v-bind:class="prevclass" v-on:click="change_count(true)")
      left-arrow
    div(class='utility')
      | {{ computed_index }} / {{ length }}
    div(class='right-arrow' v-bind:class="nextclass" v-on:click="change_count(false)")
      right-arrow
</template>

<script>
  import right_arrow from '../SVG/right_arrow'
  import left_arrow from '../SVG/left_arrow'
  export default {
    props: ['index', 'length', 'prevclass', 'nextclass'],
    data () {
      return {
        computed_index: 1
      }
    }, 
    methods: {
      change_count: function(bool) {
        if(bool && this.computed_index > 1) {
          this.computed_index = this.computed_index - 1
        } else if (!bool && this.computed_index < this.length) {
          this.computed_index = this.computed_index + 1
        }
      }
    },
    components: {
      'right-arrow': right_arrow,
      'left-arrow': left_arrow
    },
    mounted () {
      this.computed_index = this.index
    },
  }
</script>

<style scoped lang='scss'>
  .arrow-container {
    position: relative;
    cursor: pointer;
    width: 89px;
    height: 24px;
    display: flex;
  }
  .utility {
    height: 24px;
    margin: auto;
    user-select: none;
  }
  .left-arrow, .right-arrow {
    position: absolute;
    transition: transform 0.2s ease;
    user-select: none;
  }
  .left-arrow {
    left: 0;
    padding-right: 29px;
    &:hover {
      transform: translateX(-4px);
    }
  }
  .right-arrow {
    right: 0;
    padding-left: 29px;
    &:hover {
      transform: translateX(4px);
    }
  }
</style>
