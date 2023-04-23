
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

Vue.component('chat-conversations', require('./components/ChatListConversations.vue'));
Vue.component('chat-conversations-item', require('./components/ChatConversationItem.vue'));
Vue.component('chat-list-users', require('./components/ChatListUsers.vue'));
Vue.component('chat-messages', require('./components/ChatMessages.vue'));
Vue.component('chat-form', require('./components/ChatForm.vue'));

const app = new Vue({
    el: '#app',

    data: {
        conversations: [],
        messages: [],
        currentComponent: 'chat-conversations',
    },

    created() {
        this.fetchConversations()
        // this.fetchMessages();
        Echo.private('chat')
            .listen('.messagesent', (e) => {
                this.messages.push({
                    message: e.message.message,
                    user: e.user
                });
            });
    },

    methods: {
        fetchConversations(){
            axios.get('/conversations').then(response => {
                this.conversations = response.data.conversations;
            });
        },
        fetchMessages(chatId) {
            axios.get('/messages', {params: {'chatId': chatId}}).then(response => {
                if(Object.keys(response.data).length > 0){
                    let messages = response.data.messages[0].messages;
                    for (let i = 0; i < Object.keys(messages).length; i++) {
                        console.log(messages[i])
                        this.messages.push({
                            message: messages[i].message,
                            user: {
                                'id': messages[i].chatParticipantId,
                                'name': messages[i].name
                            },
                        });
                    }
                    // $.each(response.data.messages[0].messsages, function (index, data){
                    //     console.log(this)
                    // });
                    console.log(this.messages)
                    // this.messages = response.data.messages[0];
                }
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
        },

        openConversation(id) {
            this.fetchMessages(id);
        }

    }
});
