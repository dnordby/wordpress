<template>
  <div>
    sandbox

    <div class="padding"></div>

    <div class="form-input-container fonts">
      <input type="text" placeholder="PASSWORD" class="match-it-here utility form-input"></input>
      <div class="form-label make-sure-the-fonts-match utility">PASSWORD</div>
    </div>
  </div>
</template>

<style scoped lang="scss">

  .padding {
    margin: 120px auto;
  }
  
  .form-input-container {
    position: relative;
    margin: auto;
    height: 48px;
    width: 200px;
    border-bottom: 1px solid black;
  }

  .form-input {
    border: none;
    position: absolute;
    left: 0;
    top: 0;
    background: none;
    height: calc(100% - 2px);
    width: calc(100% - 20px);
    &::selection {
      background: lightblue;
    }
    &::placeholder {
      color: black;
      opacity: 1;
      transition: all 0.6s ease-in-out
    }
    &:active, &:focus {
      outline: none;
      & + .form-label {
        transform: translateY(-18px) ;
        opacity: 1;
      }
      &::placeholder {
        opacity: 0;
      }
    }
  }
  
  .form-label {
    position: absolute;
    color: black;
    height: 24px;
    top: 0; left: 0; bottom: 0;
    margin: auto;
    pointer-events: none;
    opacity: 0;
    transition: all 0.6s ease-in-out;
  }
</style>

