<template>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h5>Usuarios</h5>
    </div>
    <div class="panel-body">
      <button class="btn btn-primary" @click="swapToListConversationsComponent">Voltar</button>
      <hr>
      <div v-for="user in users" class="media" style="border: 1px solid gray; padding: 10px;">
        <div class="media-left">
          <a href="#">
            <img class="media-object" src="https://down-br.img.susercontent.com/file/br-11134207-7qukw-lfid6l9qv0gu6f" style="width: 35px;">
          </a>
        </div>
        <div class="media-body">
          <h4 class="media-heading">{{user.name}} <button class="btn btn-primary pull-right" @click="newConversation(user.id)">+</button></h4>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data(){
    return {
      users: [],
    }
  },
  mounted() {
    this.getUsers()
  },
  methods:{
    getUsers(){
      axios.get('/get-users').then(response => {
        this.users = response.data
      });
    },

    swapToListConversationsComponent() {
      this.$emit('swap', 'chat-conversations')
    },

    newConversation(id){
      axios.post('/create-conversation', {
        userId: id,
      })
      .then(function (response) {
        console.log(response);
      })
      .catch(function (error) {
        console.log(error);
      });
    }
  }
}
</script>

<style scoped>

</style>