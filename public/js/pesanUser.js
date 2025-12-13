const messageInput = document.getElementById('message-input');
const sendBtn = document.getElementById('send-btn');
const chatBody = document.getElementById('chat-body');

/* ================= UTIL ================= */
function scrollToBottom() {
    chatBody.scrollTop = chatBody.scrollHeight;
}

function appendMessage(msg, type, time = '') {
    const safeMsg = msg
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/\n/g, "<br>");

    chatBody.innerHTML += `
        <div class="message-bubble message-${type}">
            <div class="message-text">${safeMsg}</div>
            ${time ? `<span class="time">${time}</span>` : ''}
        </div>
    `;
    scrollToBottom();
}

/* ================= SEND MESSAGE ================= */
sendBtn.addEventListener('click', sendMessage);

messageInput.addEventListener('keydown', e => {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        sendMessage();
    }
});

function sendMessage() {
    const message = messageInput.value.trim();
    if (!message) return;

    fetch(CHAT_SEND_URL, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": CSRF_TOKEN
        },
        body: JSON.stringify({
            receiver_id: ADMIN_ID,
            message: message
        })
    });

    // tampil langsung (optimistic UI)
    appendMessage(
        message,
        "sent",
        new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
    );

    messageInput.value = "";
}

/* ================= LOAD CHAT AWAL ================= */
function loadChatUser() {
    fetch(CHAT_MESSAGES_URL)
        .then(res => res.json())
        .then(messages => {
            chatBody.innerHTML = "";
            messages.forEach(msg => {
                const type = msg.sender_id === ADMIN_ID ? "received" : "sent";
                appendMessage(msg.message, type, msg.time);
            });
        });
}

loadChatUser();

/* ================= PUSHER ================= */
const pusher = new Pusher(PUSHER_KEY, {
    cluster: PUSHER_CLUSTER,
    forceTLS: true
});

// USER listen ke channel sendiri
const channel = pusher.subscribe(`chat.${CURRENT_USER_ID}`);

channel.bind('message.sent', data => {
    // abaikan pesan sendiri
    if (data.sender_id === CURRENT_USER_ID) return;

    appendMessage(
        data.message,
        "received",
        data.created_at
            ? data.created_at.slice(11, 16)
            : ''
    );
});
