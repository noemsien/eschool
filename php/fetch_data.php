<?php
// fetch_data.php
// This script fetches all necessary data from the database and returns it as JSON.

// Include the database connection file
include '../php/db_connection.php';

// Set the content type header to application/json to ensure the browser interprets the response correctly
header('Content-Type: application/json');

// Initialize an empty array to hold all the fetched data
$data = [];

// --- Fetch Students Data ---
$sql_students = "SELECT id, name, email, course FROM students";
$result_students = $conn->query($sql_students);
$students = [];
if ($result_students->num_rows > 0) {
    // Loop through each row and add it to the students array
    while($row = $result_students->fetch_assoc()) {
        $students[] = $row;
    }
}
$data['students'] = $students; // Add students data to the main data array

// --- Fetch Courses Data ---
$sql_courses = "SELECT id, title, credits, department FROM courses";
$result_courses = $conn->query($sql_courses);
$courses = [];
if ($result_courses->num_rows > 0) {
    while($row = $result_courses->fetch_assoc()) {
        $courses[] = $row;
    }
}
$data['courses'] = $courses; // Add courses data to the main data array

// --- Fetch Teachers Data ---
$sql_teachers = "SELECT id, name, email, department FROM teachers";
$result_teachers = $conn->query($sql_teachers);
$teachers = [];
if ($result_teachers->num_rows > 0) {
    while($row = $result_teachers->fetch_assoc()) {
        $teachers[] = $row;
    }
}
$data['teachers'] = $teachers; // Add teachers data to the main data array

// --- Fetch Admissions Data ---
// Note: 'app_id' is used as the primary key in the database
$sql_admissions = "SELECT app_id, student_name, course_applied, status, date FROM admissions";
$result_admissions = $conn->query($sql_admissions);
$admissions = [];
if ($result_admissions->num_rows > 0) {
    while($row = $result_admissions->fetch_assoc()) {
        $admissions[] = $row;
    }
}
$data['admissions'] = $admissions; // Add admissions data to the main data array

// --- Fetch Recent Activities Data ---
// Order by timestamp in descending order and limit to the last 10 activities
$sql_activities = "SELECT description FROM activities ORDER BY timestamp DESC LIMIT 10";
$result_activities = $conn->query($sql_activities);
$activities = [];
if ($result_activities->num_rows > 0) {
    while($row = $result_activities->fetch_assoc()) {
        $activities[] = $row['description']; // Only fetch the description
    }
}
$data['activities'] = $activities; // Add activities data to the main data array

// Encode the entire data array as a JSON string and output it
echo json_encode($data);

// Close the database connection
$conn->close();
?>
