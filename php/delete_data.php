<?php
// delete_data.php
// This script handles deleting records (students, courses, teachers) from the database.

// Include the database connection file
include '../php/db_connection.php';

// Set the content type header to application/json for JSON responses
header('Content-Type: application/json');

// Initialize a response array with a default failure status and empty message
$response = ['success' => false, 'message' => ''];

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and retrieve POST data
    $idToDelete = $_POST['id'] ?? '';
    $typeToDelete = $_POST['type'] ?? '';

    // Basic validation: Check if ID or type are missing
    if (empty($idToDelete) || empty($typeToDelete)) {
        $response['message'] = 'Missing ID or type for deletion.';
        echo json_encode($response); // Output response and exit
        $conn->close();
        exit();
    }

    $table = "";
    $idColumn = "id"; // Default ID column name for students, courses, teachers

    // Determine the table name based on the 'type' parameter
    switch ($typeToDelete) {
        case 'student':
            $table = "students";
            break;
        case 'course':
            $table = "courses";
            break;
        case 'teacher':
            $table = "teachers";
            break;
        case 'admission': // Assuming you might add deletion for admissions later
            $table = "admissions";
            $idColumn = "app_id"; // Admissions table uses 'app_id'
            break;
        default:
            $response['message'] = 'Invalid type for deletion.';
            echo json_encode($response); // Output response and exit
            $conn->close();
            exit();
    }

    // Prepare a SQL statement for deleting a record
    // Using prepared statements is crucial for security (prevents SQL injection)
    // The table name is dynamically inserted, but the ID is a bound parameter.
    $stmt = $conn->prepare("DELETE FROM $table WHERE $idColumn = ?");

    // Bind the ID parameter. 'i' indicates an integer type.
    // Adjust 'i' to 's' if your IDs are strings (e.g., UUIDs).
    $stmt->bind_param("i", $idToDelete);

    // Execute the delete statement
    if ($stmt->execute()) {
        // Check if any rows were affected (i.e., if a record was actually deleted)
        if ($stmt->affected_rows > 0) {
            $response['success'] = true;
            $response['message'] = ucfirst($typeToDelete) . ' deleted successfully.';

            // --- Add an activity log entry ---
            $activity_desc = ucfirst($typeToDelete) . " with ID " . htmlspecialchars($idToDelete) . " was deleted.";
            $activity_stmt = $conn->prepare("INSERT INTO activities (description) VALUES (?)");
            $activity_stmt->bind_param("s", $activity_desc);
            $activity_stmt->execute();
            $activity_stmt->close();

        } else {
            // If no rows were affected, it means the record with the given ID was not found
            $response['message'] = 'No ' . $typeToDelete . ' found with ID ' . $idToDelete . '.';
        }
    } else {
        // If execution fails, provide an error message including the MySQL error
        $response['message'] = 'Error deleting ' . $typeToDelete . ': ' . $stmt->error;
    }
    // Close the prepared statement
    $stmt->close();
} else {
    // If the request method is not POST, set an appropriate error message
    $response['message'] = 'Invalid request method.';
}

// Encode the response array as a JSON string and output it
echo json_encode($response);

// Close the database connection
$conn->close();
?>
