<template>
  <div class="media" style="border: 1px solid gray; padding: 10px;">
    <div class="media-left">
      <a href="#">
        <img class="media-object" src="https://down-br.img.susercontent.com/file/br-11134207-7qukw-lfid6l9qv0gu6f" style="width: 35px;">
      </a>
    </div>
    <div class="media-body">
      <span>{{ conversation.participants.name }}</span>
      <p>{{ conversation.last_message.message }}</p>
    </div>
  </div>
</template>

<script>
export default {
  props: ['conversation']
}
</script>

<style scoped>

</style>