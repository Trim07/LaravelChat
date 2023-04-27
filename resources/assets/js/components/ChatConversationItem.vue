<template>
  <div class="media" style="border: 1px solid gray; padding: 10px;" @click="openConversation(conversation.id, conversation.participants[0].userId)">
    <div class="media-left">
      <a href="#">
        <img class="media-object" src="https://down-br.img.susercontent.com/file/br-11134207-7qukw-lfid6l9qv0gu6f" style="width: 35px;">
      </a>
    </div>
    <div class="media-body">
      <span v-if="conversation.participants[0]">{{ conversation.participants[0].name }}</span>
      <p v-if="conversation.last_message">{{ conversation.last_message.message }}<span class="btn btn-primary badge" style="float: right" v-if="conversation.unread_messages_count > 0">{{conversation.unread_messages_count}}</span></p>
    </div>
  </div>
</template>

<script>
export default {
  props: ['conversation'],
  created() {
    console.log(this.conversation)
  },
  methods: {
    openConversation(id, userId){
      this.$emit('openconversation', id, userId)
    }
  }
}
</script>

<style scoped>

</style>