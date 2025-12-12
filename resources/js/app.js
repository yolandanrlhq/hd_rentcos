import Echo from 'laravel-echo';
window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true
});

// Listen pesan masuk
const userId = document.querySelector('meta[name="user-id"]').content;

Echo.channel('chat.' + userId)
    .listen('MessageSent', (e) => {
        // append pesan ke chat-area
        addMessageToChat(e.message, e.message.sender_id == userId ? 'sent' : 'received');
    });

// fungsi kirim pesan
document.querySelector('.chat-input-placeholder button').addEventListener('click', () => {
    const message = document.querySelector('.chat-input-placeholder input').value;
    const receiver_id = document.querySelector('.chat-user-info').dataset.receiverId;

    axios.post('/chat/send', { receiver_id, message }).then(res => {
        document.querySelector('.chat-input-placeholder input').value = '';
    });
});

function addMessageToChat(message, type) {
    const chatBody = document.querySelector('.chat-body');
    const messageDiv = document.createElement('div');
    messageDiv.classList.add('message', type);
    messageDiv.innerHTML = `<div class="message-content"><p>${message.message}</p><div class="message-time">${message.created_at}</div></div>`;
    chatBody.appendChild(messageDiv);
    chatBody.scrollTop = chatBody.scrollHeight;
}
