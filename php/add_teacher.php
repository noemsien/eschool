<?php
// add_teacher.php
// This script handles adding a new teacher record to the database.

include '../php/db_connection.php'; // Include the database connection file

header('Content-Type: application/json'); // Set content type to JSON

$response = ['success' => false, 'message' => '']; // Initialize response array

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and retrieve POST data for teacher details
    $teacherName = $_POST['teacherName'] ?? '';
    $teacherEmail = $_POST['teacherEmail'] ?? '';
    $teacherDepartment = $_POST['teacherDepartment'] ?? '';

    // Basic validation: Check if any required field is empty
    if (empty($teacherName) || empty($teacherEmail) || empty($teacherDepartment)) {
        $response['message'] = 'All fields are required!';
    } else {
        // Prepare a statement to check if the email already exists to prevent duplicates
        $stmt_check = $conn->prepare("SELECT id FROM teachers WHERE email = ?");
        $stmt_check->bind_param("s", $teacherEmail); // 's' for string parameter
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            $response['message'] = 'Teacher with this email already exists.';
        } else {
            $stmt_check->close(); // Close the check statement

            // Prepare an SQL statement for inserting a new teacher
            $stmt_insert = $conn->prepare("INSERT INTO teachers (name, email, department) VALUES (?, ?, ?)");
            // Bind parameters: 'sss' for three string parameters
            $stmt_insert->bind_param("sss", $teacherName, $teacherEmail, $teacherDepartment);

            // Execute the insert statement
            if ($stmt_insert->execute()) {
                $response['success'] = true;
                $response['message'] = 'Teacher added successfully!';

                // Add an activity log entry
                $activity_desc = "New teacher " . htmlspecialchars($teacherName) . " (" . htmlspecialchars($teacherDepartment) . ") added.";
                $activity_stmt = $conn->prepare("INSERT INTO activities (description) VALUES (?)");
                $activity_stmt->bind_param("s", $activity_desc);
                $activity_stmt->execute();
                $activity_stmt->close();

            } else {
                $response['message'] = 'Error adding teacher: ' . $stmt_insert->error;
            }
            $stmt_insert->close(); // Close the insert statement
        }
    }
} else {
    $response['message'] = 'Invalid request method.';
}

echo json_encode($response); // Output the JSON response

$conn->close(); // Close the database connection
?>
