<template>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h5>Usuarios</h5>
    </div>
    <div class="panel-body">
      <button class="btn btn-primary" @click="swapToListConversationsComponent">Voltar</button>
<!--      <div v-for="user in users" class="media">-->
<!--        <div class="media-left">-->
<!--          <a href="#">-->
<!--            <img class="media-object" src="https://down-br.img.susercontent.com/file/br-11134207-7qukw-lfid6l9qv0gu6f" style="width: 20px;">-->
<!--          </a>-->
<!--        </div>-->
<!--        <div class="media-body">-->
<!--          <h4 class="media-heading">{{user.name}}</h4>-->
<!--          <button class="btn btn-primary">+</button>-->
<!--        </div>-->
<!--      </div>-->
    </div>
  </div>
</template>

<script>
export default {
  users: [],
  mounted() {
    this.getUsers()
  },
  methods:{
    getUsers(){
      axios.get('/getUsers').then(response => {
        console.log(response)
        // this.messages = response.data;
      });
    },
    swapToListConversationsComponent() {
      console.log(this.$emit('swap', 'chat-conversations'))
    }
  }
}
</script>

<style scoped>

</style>