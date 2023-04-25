
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

Vue.component('chat-conversations', require('./components/ChatListConversations.vue'));
Vue.component('chat-conversations-item', require('./components/ChatConversationItem.vue'));
Vue.component('chat-list-users', require('./components/ChatListUsers.vue'));
Vue.component('chat-messages', require('./components/ChatMessages.vue'));
Vue.component('chat-form', require('./components/ChatForm.vue'));

