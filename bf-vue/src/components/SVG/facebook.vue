<template>
  <svg width="18px" height="18px" viewBox="0 0 18 18" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" v-on:click="emit_clicked">
      <g id="Symbols" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
          <g id="Facebook">
              <path d="M0,9 C0,4.02943701 4.02943701,0 9,0 C13.970563,0 18,4.02943701 18,9 C18,13.970563 13.970563,18 9,18 C4.02943701,18 0,13.970563 0,9 Z M1,9 C1,13.4182782 4.58172178,17 9,17 C13.4182782,17 17,13.4182782 17,9 C17,4.58172178 13.4182782,1 9,1 C4.58172178,1 1,4.58172178 1,9 Z M9.63808316,13.9918038 L7.61215217,13.9918038 L7.61215217,9.0955197 L6.6,9.0955197 L6.6,7.40816724 L7.61215217,7.40816724 L7.61215217,6.39508694 C7.61215217,5.01854748 8.18367656,4.2 9.80744498,4.2 L11.1592776,4.2 L11.1592776,5.88754355 L10.3142865,5.88754355 C9.68219378,5.88754355 9.64037959,6.12335249 9.64037959,6.56344 L9.63808316,7.40797615 L11.1688461,7.40797615 L10.9897245,9.09532861 L9.63808316,9.09532861 L9.63808316,13.9918038 Z" id="Combined-Shape"></path>
          </g>
      </g>
  </svg>
</template>

<script>
    export  default {
        methods: {
            emit_clicked: function () {
                this.$emit('clicked')
            }
        }
    }
</script>

<style scoped lang="scss">
    @import '../../styles/colors.scss';
    svg {
        cursor: pointer;
        user-select: none;
        #Facebook {
            fill: $anchor;
            transition: all 0.4s ease;
        }
        &:hover {
            #Facebook {
                opacity: 0.75;
                fill: $facebook;
            }
        }
    }
</style>