<?php
// add_student.php
// This script handles adding a new student record to the database.

// Include the database connection file
include '../php/db_connection.php';

// Set the content type header to application/json for JSON responses
header('Content-Type: application/json');

// Initialize a response array with a default failure status and empty message
$response = ['success' => false, 'message' => ''];

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and retrieve POST data
    // Use the null coalescing operator (??) to provide an empty string if the key doesn't exist
    $studentName = $_POST['studentName'] ?? '';
    $studentEmail = $_POST['studentEmail'] ?? '';
    $studentCourse = $_POST['studentCourse'] ?? '';

    // Basic validation: Check if any required field is empty
    if (empty($studentName) || empty($studentEmail) || empty($studentCourse)) {
        $response['message'] = 'All fields are required!';
    } else {
        // Prepare a statement to check if the email already exists to prevent duplicates
        $stmt_check = $conn->prepare("SELECT id FROM students WHERE email = ?");
        $stmt_check->bind_param("s", $studentEmail); // 's' indicates a string parameter
        $stmt_check->execute();
        $stmt_check->store_result(); // Store the result for checking num_rows

        if ($stmt_check->num_rows > 0) {
            // If a row is found, the email already exists
            $response['message'] = 'Student with this email already exists.';
        } else {
            // Close the check statement as it's no longer needed
            $stmt_check->close();

            // Prepare an SQL statement for inserting a new student
            // Using prepared statements prevents SQL injection
            $stmt_insert = $conn->prepare("INSERT INTO students (name, email, course) VALUES (?, ?, ?)");
            // Bind parameters to the prepared statement
            // 'sss' indicates three string parameters
            $stmt_insert->bind_param("sss", $studentName, $studentEmail, $studentCourse);

            // Execute the insert statement
            if ($stmt_insert->execute()) {
                // If execution is successful, set success to true and provide a success message
                $response['success'] = true;
                $response['message'] = 'Student added successfully!';

                // --- Add an activity log entry ---
                $activity_desc = "New student " . htmlspecialchars($studentName) . " added to " . htmlspecialchars($studentCourse) . ".";
                $activity_stmt = $conn->prepare("INSERT INTO activities (description) VALUES (?)");
                $activity_stmt->bind_param("s", $activity_desc);
                $activity_stmt->execute();
                $activity_stmt->close();

            } else {
                // If execution fails, provide an error message including the MySQL error
                $response['message'] = 'Error adding student: ' . $stmt_insert->error;
            }
            // Close the insert statement
            $stmt_insert->close();
        }
    }
} else {
    // If the request method is not POST, set an appropriate error message
    $response['message'] = 'Invalid request method.';
}

// Encode the response array as a JSON string and output it
echo json_encode($response);

// Close the database connection
$conn->close();
?>
