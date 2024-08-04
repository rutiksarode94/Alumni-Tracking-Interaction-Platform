<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Chat</title>
    <style>
        /* Add your CSS styles as needed */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: url('background-image.jpg') center center fixed;
            background-size: cover;
        }

        #chat-container {
            max-width: 600px;
            margin: 20px auto;
            border: 1px solid #ccc;
            border-radius: 8px;
            overflow: hidden;
            background-color: #fff; /* Set a background color for the chat container */
        }

        #alumni-details {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        #chat-header {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        #chat-messages {
            max-height: 300px;
            overflow-y: auto;
            padding: 10px;
        }

        #send-message-form {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background-color: #fff;
        }

        #file-input {
            margin-right: 10px;
        }

        #back-button {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border: none;
            cursor: pointer;
        }

        #back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div id="chat-container">
        <div id="alumni-details"></div>
        <div id="chat-header"></div>
        <div id="chat-messages"></div>
        <form id="send-message-form">
            <textarea id="chat-message-input" name="message" placeholder="Type your message..."></textarea>
            <input type="file" id="file-input" name="file_upload" accept=".txt, .pdf, .png">
            <button type="button" onclick="sendMessage()">Send</button>
            <button type="button" onclick="deleteChat()">Delete Chat</button>
        </form>
        <button id="back-button" onclick="goBack()">Back</button>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        // Function to open the chat modal
        function openChatModal(alumniId, alumniName, alumniBatch) {
            // Fetch alumni details using Ajax
        // Example AJAX call
$.ajax({
    url: 'ajax.php?action=save_user',
    method: 'POST',
    data: { alumni_id: alumniId }, // Ensure this matches the server-side variable name
    dataType: 'json',
    success: function(response) {
        // Log the response for debugging
        console.log(response);

        // Update the alumni details in the chat container
        $('#alumni-details').html(`Alumni Name: ${response.name} | Batch: ${response.batch}`);
    },
    error: function() {
        // Handle errors
        $('#alumni-details').text('Error fetching Alumni Details');
    }
});

            
            // Set alumni name in the chat header
            $('#chat-header').text(`Chatting with ${alumniName}`);

            // TODO: Fetch and display chat messages
            $('#chat-messages').html('');

            // Set alumni ID in the hidden field
            $('#chat-alumni-id').val(alumniId);

            // Show the chat modal
            $('#chat-container').show();
        }

        // Function to send a message
        function sendMessage() {
            var message = $('#chat-message-input').val();
            var file = $('#file-input')[0].files[0];

            // TODO: Implement logic to send the message and handle file upload
            // For now, let's just display the message in the chat
            var messageText = message ? `<p><strong>You:</strong> ${message}</p>` : '';
            var fileText = file ? '<p><strong>You:</strong> File attached</p>' : '';

            // Prepend the message to show user messages at the top
            $('#chat-messages').prepend(messageText + fileText);

            // Clear input fields
            $('#chat-message-input').val('');
            $('#file-input').val('');
        }

        // Function to delete the chat (clear messages)
        function deleteChat() {
            $('#chat-messages').html('');
        }

        // Function to navigate back to the previous page
        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html
