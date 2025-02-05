<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "birth_registration";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $registration_id = $_POST['registration_id'];
    $action = $_POST['action'];

    if ($action === 'verify') {
        $new_status = 'verified';

        // Update status in the database
        $query = "UPDATE status SET status_details = ? WHERE registration_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $new_status, $registration_id);

        if ($stmt->execute()) {
            echo "<script>
                alert('Status updated to Verified!');
                window.location.href = 'AdminDashboard.php'; // Redirect to admin dashboard
            </script>";
        } else {
            echo "<script>alert('Error updating status.');</script>";
        }
    } elseif ($action === 'reject') {
        // STEP 1: Delete related status entry first
        $query = "DELETE FROM status WHERE registration_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $registration_id);
        $stmt->execute();
        $stmt->close();

        // STEP 2: Delete from registrations
        $query = "DELETE FROM registrations WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $registration_id);

        if ($stmt->execute()) {
            echo "<script>
                alert('Registration Rejected & Removed!');
                window.location.href = 'AdminDashboard.php'; // Redirect to admin dashboard
            </script>";
        } else {
            echo "<script>alert('Error rejecting registration.');</script>";
        }
    }

    $stmt->close();
    $conn->close();
}
?>
