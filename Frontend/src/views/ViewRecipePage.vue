<script lang="ts">


 

export default {
  data(){
    return{
      id: this.$route.params.id,
    };
  },

};

/**Displays the recipe title and description on to the screen */
</script>
<template>
  <div class="ViewRecipePage">
    <h1>This recipe is {{ this.$route.params.id }}</h1> 
  </div>
</template>
