<template>
  <div class="media" style="border: 1px solid gray; padding: 10px;" @click="openConversation(conversation.id)">
    <div class="media-left">
      <a href="#">
        <img class="media-object" src="https://down-br.img.susercontent.com/file/br-11134207-7qukw-lfid6l9qv0gu6f" style="width: 35px;">
      </a>
    </div>
    <div class="media-body">
      <span v-if="conversation.participants[0]">{{ conversation.participants[0].name }}</span>
      <p v-if="conversation.last_message">{{ conversation.last_message.message }}</p>
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
    openConversation(id){
      this.$emit('openconversation', id)
    }
  }
}
</script>

<style scoped>

</style>