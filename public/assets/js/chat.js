function displayMessage(message) {
    const currentTime = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    const messageElement = document.createElement('div');
    messageElement.classList.add('media', 'media-chat', 'media-chat-reverse', 'new-message'); // Add any desired classes
    messageElement.innerHTML = `<div class="media-body">
        <p>${message.message}</p>
        <p class="meta"><time datetime="${message.created_at}">${currentTime}</time></p>
    </div>`;
    const chatContent = document.getElementById('chat-content');
    chatContent.appendChild(messageElement);
    chatContent.scrollTop = chatContent.scrollHeight;
}
