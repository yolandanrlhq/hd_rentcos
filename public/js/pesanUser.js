const messageInput = document.getElementById('message-input');
const sendBtn = document.getElementById('send-btn');
const chatBody = document.getElementById('chat-body');

sendBtn.addEventListener('click', sendMessage);
messageInput.addEventListener('keypress', e => { if(e.key==='Enter') sendMessage(); });

function sendMessage() {
    const message = messageInput.value.trim();
    if(!message) return;

    appendMessage(message, "sent");

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
    }).then(res=>res.json())
      .then(data=>console.log("Pesan terkirim:", data))
      .catch(err=>console.error(err));

    messageInput.value = "";
}

function appendMessage(msg, type){
    chatBody.innerHTML += `<div class="message-bubble message-${type}">${msg}</div>`;
    chatBody.scrollTop = chatBody.scrollHeight;
}

function loadChatUser() {
    fetch(CHAT_MESSAGES_URL)
        .then(res=>res.json())
        .then(messages=>{
            chatBody.innerHTML = "";
            messages.forEach(msg=>{
                const type = msg.sender_id===ADMIN_ID ? "received" : "sent";
                appendMessage(msg.message, type);
            });
        });
}

setInterval(loadChatUser, 3000);
loadChatUser();
