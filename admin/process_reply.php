<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process admin reply and update the database
    $messageId = $_POST['message_id'];
    $adminReply = $_POST['admin_reply'];

    // Update the database with admin reply and set email_sent to true
    $updateSql = "UPDATE contact_messages SET admin_reply = '$adminReply', email_sent = TRUE WHERE id = $messageId";
    // Execute the query

    // Redirect or show a success message
}
?>
