// resources/assets/js/components/ChatMessages.vue

<template>
  <ul class="chat">
    <li class="left clearfix" v-for="message in messages">
      <div class="chat-body" :class="{ 'pull-right; text-right': user.id ===  message.user.id}">
        <p><strong>{{message.user.name}}</strong></p>
        <div class="row">
          <p>
            {{ message.message }}
          </p>
        </div>
      </div>
    </li>
  </ul>
</template>

<script>
export default {
  props: ['messages', 'user'],
  mounted() {
    console.log(this.messages);
  }
};
</script>
