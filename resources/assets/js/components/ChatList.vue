<template>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h5>Conversas</h5>
    </div>
    <div class="panel-body">
      <button class="btn btn-primary" @click="swapToListUsersComponent">Nova conversa</button>
<!--      <chat-conversations :chats="chats"></chat-conversations>-->
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    swapToListUsersComponent() {
      console.log(this.$emit('swap', 'chat-list-users'))
    }
  }
}
</script>

<style scoped>

</style>