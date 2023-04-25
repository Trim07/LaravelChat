@extends('layouts.app')

@section('content')

    <div id="app" class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div :is="currentComponent"
                     @swap="swapComponent"
                     @openconversation="openConversation"
                     @messagesent="addMessage"
                     :conversations="conversations"
                     :messages="messages"
                     :user="user">
                </div>
            </div>
        </div>
    </div>

    <script type="application/javascript">
        var vue = new Vue({
            el: '#app',

            data: {
                conversations: [],
                messages: [],
                currentComponent: 'chat-conversations',
                currentChatChannel: null,
                user: @json(Auth::user()),
                conversationUser: null,
                conversatioId: null,
            },

            created() {
                this.fetchConversations();
            },

            methods: {
                fetchConversations(){
                    axios.get('/conversations').then(response => {
                        this.conversations = response.data.conversations;
                    });
                },
                fetchMessages(chatId, userId) {
                    axios.get('/messages', {params: {'conversationId': chatId, 'userId': userId}}).then(response => {
                        console.log(response.data)
                        if(Object.keys(response.data.messages).length > 0 && response.data.messages[0].messages){
                            let messages = response.data.messages[0].messages;
                            this.conversationUser = response.data.messages[0].participants[0].userId
                            for (let i = 0; i < Object.keys(messages).length; i++) {
                                this.messages.push({
                                    message: messages[i].message,
                                    user: {
                                        'id': messages[i].chatParticipantId,
                                        'name': messages[i].name
                                    },
                                });
                            }
                        }
                    });
                },

                addMessage(message) {
                    message.conversationUser = this.conversationUser;
                    message.conversationId = this.conversatioId;
                    this.messages.push(message);

                    axios.post('/messages', message).then(response => {
                        console.log(response.data);
                        this.fetchConversations();
                    });
                },

                swapComponent: function(component){
                    this.currentComponent = component;
                },

                openConversation(id = null, userId = null) {

                    this.conversationUser = userId;
                    this.conversatioId = id;
                    this.fetchMessages(id, userId);

                    Echo.private('chat.'+this.conversatioId)
                        .listen('.messagesent', (e) => {
                            console.log(e)
                            this.messages.push({
                                message: e.message.message,
                                user: e.user
                            });
                            this.fetchConversations();
                        });
                    this.swapComponent('chat-messages');
                },
            }
        });

    </script>
@endsection
