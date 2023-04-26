// resources/assets/js/components/ChatMessages.vue

<template>
  <div class="panel panel-default">
    <div class="panel-heading"><button class="btn btn-primary" @click="swapToListUsersComponent">Voltar</button> Chats</div>
    <div class="panel-body">
        <ul class="chat">
          <li class="left clearfix" v-for="message in messages">
            <div class="chat-body" :class="{ 'pull-right; text-right': user.id ===  message.user.id}">
              <p><strong>{{message.user.name}} {{message.user.id}}</strong></p>
              <div class="row">
                <p>
                  {{ message.message }}
                </p>
              </div>
            </div>
          </li>
        </ul>
<!--      <chat-messages :messages="messages" :user="user"></chat-messages>-->
    </div>
    <div class="panel-footer">
      <chat-form
          v-on:messagesent="addMessage"
          :user="user"
      ></chat-form>
    </div>
  </div>

</template>

<script>
export default {
  props: ['messages', 'user'],
  methods: {
    addMessage(data){
      this.$emit('messagesent', data);
    },
    swapToListUsersComponent() {
      this.$emit('swap', 'chat-conversations')
    },
  }
};
</script>
