<?php
// add_course.php
// This script handles adding a new course record to the database.

include '../php/db_connection.php'; // Include the database connection file

header('Content-Type: application/json'); // Set content type to JSON

$response = ['success' => false, 'message' => '']; // Initialize response array

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and retrieve POST data for course details
    $courseTitle = $_POST['courseTitle'] ?? '';
    $courseCredits = $_POST['courseCredits'] ?? ''; // This should be an integer
    $courseDepartment = $_POST['courseDepartment'] ?? '';

    // Basic validation: Check if any required field is empty
    if (empty($courseTitle) || empty($courseCredits) || empty($courseDepartment)) {
        $response['message'] = 'All fields are required!';
    } else {
        // Validate credits as an integer
        if (!is_numeric($courseCredits) || $courseCredits <= 0) {
            $response['message'] = 'Credits must be a positive number.';
            echo json_encode($response);
            $conn->close();
            exit();
        }

        // Prepare a statement to check if the course title already exists to prevent duplicates
        $stmt_check = $conn->prepare("SELECT id FROM courses WHERE title = ? AND department = ?");
        $stmt_check->bind_param("ss", $courseTitle, $courseDepartment); // 'ss' for two string parameters
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            $response['message'] = 'Course with this title and department already exists.';
        } else {
            $stmt_check->close(); // Close the check statement

            // Prepare an SQL statement for inserting a new course
            $stmt_insert = $conn->prepare("INSERT INTO courses (title, credits, department) VALUES (?, ?, ?)");
            // Bind parameters: 'sis' for string, integer, string
            $stmt_insert->bind_param("sis", $courseTitle, $courseCredits, $courseDepartment);

            // Execute the insert statement
            if ($stmt_insert->execute()) {
                $response['success'] = true;
                $response['message'] = 'Course added successfully!';

                // Add an activity log entry
                $activity_desc = "New course '" . htmlspecialchars($courseTitle) . "' (" . htmlspecialchars($courseDepartment) . ") added.";
                $activity_stmt = $conn->prepare("INSERT INTO activities (description) VALUES (?)");
                $activity_stmt->bind_param("s", $activity_desc);
                $activity_stmt->execute();
                $activity_stmt->close();

            } else {
                $response['message'] = 'Error adding course: ' . $stmt_insert->error;
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
