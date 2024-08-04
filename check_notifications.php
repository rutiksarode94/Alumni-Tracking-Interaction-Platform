<?php
session_start();
include('admin/db_connect.php');

// Check if a notification is clicked
if (isset($_GET['read_notification_id'])) {
    $read_notification_id = $_GET['read_notification_id'];
    $stmt = $conn->prepare("UPDATE notifications SET status = 'read' WHERE id = ?");
    $stmt->bind_param("i", $read_notification_id);
    $stmt->execute();
    $stmt->close();
}

// Delete notifications older than 24 hours
$conn->query("DELETE FROM notifications WHERE timestamp < DATE_SUB(NOW(), INTERVAL 1 DAY)");

// Fetch all users
$user_query = $conn->query("SELECT * FROM users");

// Loop through each user
while ($user = $user_query->fetch_assoc()) {
    $user_id = $user['id'];

    // Check for new alumnus_bio entries
    $alumnus_bio_query = $conn->query("SELECT * FROM alumnus_bio WHERE date_created >= DATE_SUB(NOW(), INTERVAL 1 DAY)");
    while ($alumnus_bio = $alumnus_bio_query->fetch_assoc()) {
        $notification_message = 'New alumnus profile added: ' . $alumnus_bio['firstname'] . ' ' . $alumnus_bio['lastname'];
        // Insert notification for the user using prepared statement
        $stmt = $conn->prepare("INSERT INTO notifications (user_id, message, timestamp) VALUES (?, ?, NOW())");
        $stmt->bind_param("is", $user_id, $notification_message);
        $stmt->execute();
        $stmt->close();
    }

    // Check for new careers entries
    $careers_query = $conn->query("SELECT * FROM careers WHERE date_created >= DATE_SUB(NOW(), INTERVAL 1 DAY)");
    while ($career = $careers_query->fetch_assoc()) {
        $notification_message = 'New job posted: ' . $career['job_title'] . ' at ' . $career['company'];
        // Insert notification for the user using prepared statement
        $stmt = $conn->prepare("INSERT INTO notifications (user_id, message, timestamp) VALUES (?, ?, NOW())");
        $stmt->bind_param("is", $user_id, $notification_message);
        $stmt->execute();
        $stmt->close();
    }

    // Check for new events entries
    $events_query = $conn->query("SELECT * FROM events WHERE date_created >= DATE_SUB(NOW(), INTERVAL 1 DAY)");
    while ($event = $events_query->fetch_assoc()) {
        $notification_message = 'New event added: ' . $event['title'];
        // Insert notification for the user using prepared statement
        $stmt = $conn->prepare("INSERT INTO notifications (user_id, message, timestamp) VALUES (?, ?, NOW())");
        $stmt->bind_param("is", $user_id, $notification_message);
        $stmt->execute();
        $stmt->close();
    }
}
$conn->close();?>

<script>
// Add this JavaScript code to periodically check for new notifications
function checkNotifications() {
    $.ajax({
        url: 'check_notifications.php', // Create a new PHP file to handle this request
        type: 'GET',
        success: function (data) {
            $('.notifications').html(data);
            // Update the unread notification count
            updateUnreadCount();
        }
    });
}

// Function to redirect to a specific page based on notification type and mark the notification as read
function redirectPage(page) {
    var notification_id = page.split("=")[1];
    window.location.href = page;
    // Mark the notification as read
    $.ajax({
        url: 'check_notifications.php?read_notification_id=' + notification_id,
        type: 'GET',
        success: function (data) {
            // Update the notifications after marking as read
            checkNotifications();
        }
    });
}

// Function to update the unread notification count
function updateUnreadCount() {
    var unreadCount = $('.notification').length;
    $('.notification-count').text(unreadCount);
}

// Call the function every 30 seconds (adjust the interval as needed)
setInterval(checkNotifications, 30000);
</script>
