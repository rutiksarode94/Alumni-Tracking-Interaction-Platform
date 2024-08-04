<?php
include 'db_connect.php';

if(isset($_POST['id']) && isset($_POST['status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];

    // Perform the update query using prepared statements
    $updateQuery = $conn->prepare("UPDATE alumnus_bio SET status = ? WHERE id = ?");
    $updateQuery->bind_param("ii", $status, $id);
    if ($updateQuery->execute()) {
        echo 1; // Return 1 for successful update
    } else {
        echo 0; // Return 0 for failure
    }
}
?>
<script>
$(document).ready(function(){
    $('.update').click(function(){
        var newStatus = $(this).data('status');
        var action = newStatus == 1 ? 'verify' : 'unverify';
        console.log("ID:", <?php echo $id ?>); // Debugging message to check the value of ID
        console.log("New Status:", newStatus); // Debugging message to check the new status
        $.ajax({
            url: 'verify.php', // Updated URL to point to verify.php
            method: 'POST',
            data: { id: <?php echo $id ?>, status: newStatus },
            success: function(resp) {
                console.log("Response:", resp); // Debugging message to check the response
                if (resp == 1) {
                    alert("Alumnus/Alumna account successfully " + action + "ed.");
                    window.location.reload();
                } else {
                    alert("Error occurred while " + action + "ing account.");
                }
            },
            error: function(xhr, status, error) {
                alert("Error occurred: " + error);
            }
        });
    });

    $('.close_modal').click(function(){
        window.history.back();
    });
});
</script>
