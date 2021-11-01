<template>
  <div>

    <b-alert show variant="success">
        {{ this.title }} {{ this.id }}
        <button v-on:click="$emit('remove')">Удалить</button>
      </b-alert>



</div>
</template>

<script>

export default {
  props: [ 'id','title' ]

//  }
}
</script>

<style scoped>

</style>
