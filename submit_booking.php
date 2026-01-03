<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database credentials
$servername = "localhost"; 
$username = "root";        
$password = "";            
$dbname = "booking";  

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $datetime = mysqli_real_escape_string($conn, $_POST['datetime']);
    $destination = mysqli_real_escape_string($conn, $_POST['destination']);
    $persons = mysqli_real_escape_string($conn, $_POST['persons']);
    $categories = mysqli_real_escape_string($conn, $_POST['categories']);
    $special_request = mysqli_real_escape_string($conn, $_POST['special_request']);

    // Format the datetime if necessary
    $datetime = date('Y-m-d H:i:s', strtotime($datetime));

    // Check for empty fields (basic validation)
    if (empty($name) || empty($email) || empty($datetime) || empty($destination) || empty($persons) || empty($categories)) {
        die("All fields must be filled out.");
    }

    // Prepare the SQL query
    $sql = "INSERT INTO bookings (name, email, datetime, destination, persons, categories, special_request)
            VALUES ('$name', '$email', '$datetime', '$destination', '$persons', '$categories', '$special_request')";

    // Debugging: Print the SQL query to check for errors
    echo "SQL Query: " . $sql . "<br>";

    // Execute the query and check for success
    if ($conn->query($sql) === TRUE) {
        echo "Booking submitted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>
