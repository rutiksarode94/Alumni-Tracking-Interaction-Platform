<?php
// Include database connection
include 'db_connect2.php';

// Get GR number from POST data
$gr_no = $_POST['gr_no'];

// Initialize response array
$response = array();

// Query to check if GR number exists in the student table
$stmt = $conn2->prepare("SELECT * FROM student WHERE gr_no = ?");
$stmt->bind_param("s", $gr_no);
$stmt->execute();
$result = $stmt->get_result();

// Check if result exists
if ($result->num_rows > 0) {
    // If GR number found, fetch the student details
    $row = $result->fetch_assoc();
    $response['status'] = 'found';
    $response['firstname'] = $row['firstname'];
    $response['course_id'] = $row['course_id'];
    $response['batch'] = $row['batch'];
} else {
    // If GR number not found, set status to not found
    $response['status'] = 'not_found';
}

// Return response as JSON
echo json_encode($response);

// Close database connection
$stmt->close();
$conn2->close();
?>
