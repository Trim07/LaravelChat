
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

require('./bootstrap');

Vue.component('chat-conversations', require('./components/ChatList.vue'));
Vue.component('chat-list-users', require('./components/ChatListUsers.vue'));
Vue.component('chat-messages', require('./components/ChatMessages.vue'));
Vue.component('chat-form', require('./components/ChatForm.vue'));

const app = new Vue({
    el: '#app',

    data: {
        chats: [],
        messages: [],
        currentComponent: 'chat-conversations',
    },

    created() {
        this.fetchChats()
        this.fetchMessages();
        Echo.private('chat')
            .listen('.messagesent', (e) => {
                this.messages.push({
                    message: e.message.message,
                    user: e.user
                });
            });
    },

    methods: {
        fetchChats(){
            axios.get('/chats').then(response => {
                console.log(response)
                // this.messages = response.data;
            });
        },
        fetchMessages() {
            axios.get('/messages').then(response => {
                // console.log(response)
                this.messages = response.data;
            });
        },

        addMessage(message) {
            this.messages.push(message);

            axios.post('/messages', message).then(response => {
                console.log(response.data);
            });
        },

        swapComponent: function(component){
            this.currentComponent = component;
        }

    }
});
