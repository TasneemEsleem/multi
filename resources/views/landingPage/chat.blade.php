<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <link rel="stylesheet" href="{{ asset('assets/css/chat.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body data-user-id="{{ Auth::user()->id }}">
    <div class="page-content page-container" id="page-content">
        <div class="padding">
            <div class="row container d-flex justify-content-center">
                <div class="col-md-6">
                    <div class="card card-bordered">
                        <div class="card-header">
                            <h4 class="card-title"><strong>Chat</strong></h4>
                        </div>
                        <!-- Create a dropdown to select restaurants -->
                        <div class="card-body">
                            <div class="form-group">
                                <label for="restaurant_id">Select Restaurant:</label>
                                <select id="restaurant_id" class="form-control">
                                    <option value="">Select a Restaurant</option>
                                    @foreach ($restaurants as $restaurant)
                                        <option value="{{ $restaurant->id }}">{{ $restaurant->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="ps-container ps-theme-default ps-active-y" id="chat-content"
                            style="overflow-y: scroll !important; height:400px !important;">
                            <!-- All Messages -->
                        </div>
                        <div class="publisher bt-1 border-light">
                            <img class="avatar avatar-xs"
                                src="https://img.icons8.com/color/36/000000/administrator-male.png" alt="...">
                            <input id="newMessage" class="publisher-input" type="text" placeholder="Write something">
                            <span class="publisher-btn file-group">
                                <i class="fa fa-paperclip file-browser"></i>
                                <input type="file">
                            </span>
                            <a class="publisher-btn" href="#" data-abc="true"><i class="fa fa-smile"></i></a>
                            <button class="publisher-btn text-info" onclick="sendMessage()" data-abc="true"
                                id="sendMessageButton">
                                <i class="fa fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="{{asset('assets/js/chat.js') }}"></script>
    <script>
        function sendMessage() {
            const restaurant_id = $('#restaurant_id').val();
            const message = $('#newMessage').val();
            axios.post('/chat/send-message', {
                    restaurant_id: restaurant_id,
                    message: message
                })
                .then(response => {
                    $('#newMessage').val('');
                })
                .catch(error => {
                    console.error(error.response.data);
                });
        }
        $('#sendMessageButton').on('click', function() {
            sendMessage();
        });
        $('#newMessage').on('keypress', function(e) {
            if (e.keyCode === 13) {
                sendMessage();
            }
        });
        // Display the message
        $('#restaurant_id').on('change', function() {
            const restaurant_id = $(this).val();
            if (restaurant_id) {
                axios.get('/chat/' + restaurant_id)
                    .then(response => {
                        const messages = response.data;
                        const chatContent = $('#chat-content');
                        chatContent.empty(); // Clear existing messages
                        messages.forEach(message => {
                            displayMessage(message);
                        });
                    });
            }
        });
    </script>
    <script>
        const user = {{ Auth::id() }}
    </script>
    @vite('resources/js/app.js')
</body>

</html>
