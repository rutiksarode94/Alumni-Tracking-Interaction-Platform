<?php
include('db_connect.php');
$sql = "SELECT * FROM contact_messages ORDER BY date_created DESC";
$result = $conn->query($sql);

// Check if the query was successful
if ($result) {
    $messages = $result->fetch_all(MYSQLI_ASSOC);
} else {
    // Handle the error, for example, show an error message
    echo "Error fetching contact messages: " . $conn->error;
    $messages = array(); // Set an empty array to avoid further errors
}
?>

<!-- Admin interface HTML code to display messages -->
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Message</th>
            <th>Date Created</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($messages as $message): ?>
            <tr>
                <td><?php echo $message['name']; ?></td>
                <td><?php echo $message['email']; ?></td>
                <td>
                    <a href="#" onclick="showMessageModal(<?php echo $message['id']; ?>)">View Message</a>
                </td>
                <td><?php echo $message['date_created']; ?></td>
                <td>
                    <a href="mailto:<?php echo $message['email']; ?>">Reply</a>
                   
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- JavaScript to handle displaying the reply modal -->
<script>
    function showReplyModal(messageId) {
        document.getElementById('replyMessageId').value = messageId;
        document.getElementById('replyModal').style.display = 'block';
    }

    function closeReplyModal() {
        document.getElementById('replyModal').style.display = 'none';
    }

    function showMessageModal(messageId) {
        // Fetch details of the selected message and display a modal
        // You can use AJAX to fetch details from the server and display a modal
        // or use other methods based on your application architecture

        // For now, let's just display the message in an alert
        var messageContent = "<?php echo addslashes($message['message']); ?>";
        alert("Message content:\n" + messageContent);
    }
</script>

<!-- Your existing modal code remains unchanged -->
<div id="replyModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeReplyModal()">&times;</span>
        <form action="process_reply.php" method="post">
            <input type="hidden" name="message_id" id="replyMessageId">
            <textarea name="admin_reply" placeholder="Enter your reply"></textarea>
            <button type="submit">Reply</button>
        </form>
    </div>
</div>
