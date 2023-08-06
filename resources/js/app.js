import './bootstrap';
Echo.private('App.Models.User.' + user)
    .notification((notification) => {
        // const notifications = [];
        const message = notification.message;
        displayMessage(message);
        const receiverId = notification.from;
        console.log('Received message from customer:', receiverId);
        // const no = notifications.push(notification);
        // console.log(no);

        $('#sendMessageButton').on('click', function () {
            callSender(receiverId);
        });

        $('#newMessage').on('keypress', function (e) {
            if (e.keyCode === 13) {
                callSender(receiverId);
            }
        });



    });
// In the Admin If Customer send message Call Customer
function callSender(receiverId) {
    const message = $('#newMessage').val();
    axios.post('/chat/admin/send-message', {
        receiver: receiverId,
        message: message
    })
        .then(response => {
            $('#newMessage').val('');
            console.log('Message sent successfully.');
        })
        .catch(error => {
            console.error(error.response.data);
        });
}
// If the admin Want To Call Customer
$('#sendMessageButton').on('click', function () {
    const receiver = $('#user_id').val();
    const message = $('#newMessage').val();
    callSender(receiver);
})

// To Show All Message from table Messages
function displayMessage(message) {
    const currentTime = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    const messageElement = document.createElement('div');
    messageElement.classList.add('media', 'media-chat', 'media-chat-reverse', 'new-message'); // Add any desired classes
    messageElement.innerHTML = `<div class="media-body">
            <p>${message}</p>
            <p class="meta"><time datetime="2023">${currentTime}</time></p>
        </div>`;
    const chatContent = document.getElementById('chat-content');
    chatContent.appendChild(messageElement);
    chatContent.scrollTop = chatContent.scrollHeight;
}
