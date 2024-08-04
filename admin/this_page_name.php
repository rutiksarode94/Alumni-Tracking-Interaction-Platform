<?php include 'db_connect.php' ?>

<?php
if(isset($_POST['id']) && isset($_POST['status'])) {
    $alumni_id = $_POST['id'];
    $status = $_POST['status'];

    // Perform the update query using prepared statements
    $updateQuery = $conn->prepare("UPDATE alumnus_bio SET status = ? WHERE id = ?");
    $updateQuery->bind_param("ii", $status, $alumniId);
    if ($updateQuery->execute()) {
        echo 1; // Return 1 for successful update
    } else {
        echo 0; // Return 0 for failure
    }
}
?>
