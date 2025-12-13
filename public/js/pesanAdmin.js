const ADMIN_ID = 1;

let currentUserId = null;

const userList = document.getElementById('user-list');
const chatBody = document.getElementById('chat-body');
const chatHeader = document.getElementById('chat-header');
const chatInputArea = document.getElementById('chat-input-area');
const adminInput = document.getElementById('admin-chat-input');
const sendBtn = document.getElementById('admin-send-btn');
const emptyChatState = document.getElementById('empty-chat-state');

/* ================= INIT STATE ================= */
chatHeader.style.display = 'none';
chatInputArea.style.display = 'none';
emptyChatState.style.display = 'flex';

/* ================= UTIL ================= */
function scrollToBottom() {
    chatBody.scrollTop = chatBody.scrollHeight;
}

function renderMessage(msg) {
    emptyChatState.style.display = 'none';

    if (msg.sender_id === ADMIN_ID) {
        chatBody.insertAdjacentHTML('beforeend', `
            <div class="message sent">
                <div class="message-content">
                    <p>${msg.message}</p>
                    <div class="message-time">${msg.time ?? ''}</div>
                </div>
            </div>
        `);
    } else {
        const avatarSrc = msg.sender_foto
            ? `/storage/${msg.sender_foto}`
            : '/assets/default-profile.jpg';

        chatBody.insertAdjacentHTML('beforeend', `
            <div class="message received">
                <div class="message-avatar">
                    <img src="${avatarSrc}" alt="${msg.sender_name}">
                </div>
                <div class="message-content" data-user="${msg.sender_name}">
                    <p>${msg.message}</p>
                    <div class="message-time">${msg.time ?? ''}</div>
                </div>
            </div>
        `);
    }
}

/* ================= LOAD USERS ================= */
function loadUsers() {
    fetch('/admin/chat/users')
        .then(res => res.json())
        .then(users => {
            userList.innerHTML = '';
            users.forEach(user => {
                const div = document.createElement('div');
                div.className = 'user-item';
                div.onclick = () => selectUser(user.id, user.name, user.foto);

                const avatarSrc = user.foto
                    ? `/storage/${user.foto}`
                    : '/assets/default-profile.jpg';

                div.innerHTML = `
                    <div class="contact-avatar">
                        <img src="${avatarSrc}" alt="${user.name}">
                    </div>
                    <div class="contact-info">
                        <span class="contact-name">${user.name}</span>
                    </div>
                `;

                userList.appendChild(div);
            });
        });
}

/* ================= SELECT USER ================= */
function selectUser(userId, name, foto = null) {
    currentUserId = userId;

    chatHeader.style.display = 'flex';
    chatInputArea.style.display = 'flex';

    document.getElementById('chat-user-name').textContent = name;

    const chatAvatarEl = document.querySelector('.chat-avatar');
    const avatarSrc = foto
        ? `/storage/${foto}`
        : '/assets/default-profile.jpg';

    chatAvatarEl.innerHTML = `<img src="${avatarSrc}" alt="${name}">`;

    loadChat(userId);
}

/* ================= LOAD CHAT ================= */
function loadChat(userId) {
    fetch(`/admin/chat/messages/${userId}`)
        .then(res => res.json())
        .then(messages => {
            chatBody.innerHTML = '';

            if (!messages || messages.length === 0) {
                emptyChatState.style.display = 'flex';
                return;
            }

            emptyChatState.style.display = 'none';

            messages.forEach(renderMessage);
            scrollToBottom();
        });
}

/* ================= SEND MESSAGE ================= */
sendBtn.addEventListener('click', sendMessageAdmin);
adminInput.addEventListener('keypress', e => {
    if (e.key === 'Enter') sendMessageAdmin();
});

function sendMessageAdmin() {
    const message = adminInput.value.trim();
    if (!message || !currentUserId) return;

    fetch(ADMIN_CHAT_SEND_URL, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': CSRF_TOKEN_ADMIN
        },
        body: JSON.stringify({
            receiver_id: currentUserId,
            message
        })
    });

    renderMessage({
        sender_id: ADMIN_ID,
        message,
        time: new Date().toLocaleTimeString([], {
            hour: '2-digit',
            minute: '2-digit'
        })
    });

    adminInput.value = '';
    scrollToBottom();
}

/* ================= PUSHER ================= */
const pusher = new Pusher(PUSHER_KEY, {
    cluster: PUSHER_CLUSTER,
    forceTLS: true
});

const adminChannel = pusher.subscribe(`chat.${ADMIN_ID}`);

adminChannel.bind('message.sent', data => {
    if (data.sender_id === currentUserId) {
        renderMessage(data);
        scrollToBottom();
    }
});

/* ================= INIT ================= */
loadUsers();
