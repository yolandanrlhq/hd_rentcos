let currentUserId = null;
const userList = document.getElementById('user-list');
const chatBody = document.getElementById('chat-body');
const chatHeader = document.getElementById('chat-header');
const chatInputArea = document.getElementById('chat-input-area');
const adminInput = document.getElementById('admin-chat-input');
const sendBtn = document.getElementById('admin-send-btn');

function scrollToBottom(){ chatBody.scrollTop = chatBody.scrollHeight; }

function loadUsers(){
    fetch('/admin/chat/users')
        .then(res=>res.json())
        .then(users=>{
            userList.innerHTML = '';
            users.forEach(u=>{
                const div = document.createElement('div');
                div.className = 'user-item'; // tambahkan class CSS bubble
                div.textContent = u.name;
                div.addEventListener('click', ()=> selectUser(u.id,u.name));
                userList.appendChild(div);
            });
        });
}

function selectUser(id,name){
    currentUserId = id;
    chatHeader.style.display = 'flex';
    chatInputArea.style.display = 'flex';
    document.getElementById('chat-user-name').textContent = name;
    loadChat(id);
}

function loadChat(userId){
    fetch(`/admin/chat/messages/${userId}`)
        .then(res=>res.json())
        .then(messages=>{
            let bubbles = '';
            messages.forEach(msg=>{
                if(msg.sender_id===1){ // admin
                    bubbles += `<div class="message sent"><div class="message-content"><p>${msg.message}</p><div class="message-time">${msg.time}</div></div></div>`;
                }else{
                    bubbles += `<div class="message received"><i class="fas fa-user-circle message-avatar"></i><div class="message-content"><p>${msg.message}</p><div class="message-time">${msg.time}</div></div></div>`;
                }
            });
            chatBody.innerHTML = bubbles;
            scrollToBottom();
        });
}

sendBtn.addEventListener('click', sendMessageAdmin);
adminInput.addEventListener('keypress', e=>{ if(e.key==='Enter') sendMessageAdmin(); });

function sendMessageAdmin(){
    const msg = adminInput.value.trim();
    if(!msg || !currentUserId) return;

    fetch(ADMIN_CHAT_SEND_URL,{
        method:'POST',
        headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF_TOKEN_ADMIN},
        body: JSON.stringify({receiver_id: currentUserId, message: msg})
    }).then(()=>{
        adminInput.value='';
        loadChat(currentUserId);
    });
}

loadUsers();
setInterval(()=>{ if(currentUserId) loadChat(currentUserId); },3000);
