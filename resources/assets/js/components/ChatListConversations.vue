<template>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h5>Conversas</h5>
    </div>
    <div class="panel-body">
      <button class="btn btn-primary" @click="swapToListUsersComponent">Nova conversa</button>
      <div v-for="conversation in conversations">
        <chat-conversations-item :conversation="conversation" @openconversation="openConversation"></chat-conversations-item>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['conversations'],
  methods: {
    swapToListUsersComponent() {
      this.$emit('swap', 'chat-list-users')
    },
    openConversation(id){
      this.$emit('openconversation', id)
    }
  }
}
</script>

<style scoped>

</style>