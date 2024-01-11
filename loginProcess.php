<?php
// Include the database connection file
require_once('connection.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve username, password, and identity from the form
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $identity = isset($_POST['identity']) ? $_POST['identity'] : '';

    // Select the appropriate table based on the user's identity
    switch ($identity) {
        case 'Student':
            $table = 'student';
            $redirectPage = 'homeS.php'; // Redirect to the student home page
            break;
        case 'Teacher':
            $table = 'teacher';
            $redirectPage = 'homeT.php'; // Redirect to the teacher home page
            break;
        case 'Admin':
            $table = 'admin';
            $redirectPage = 'homeA.php'; // Redirect to the admin home page
            break;
        default:
            // unknown user type
            echo "<script>alert('Invalid login, Unknown User Type. Please try again.');window.location.href='login.php'</script>";
            exit();
    }

    // Prepare SQL statement
    $sql = "SELECT * FROM $table WHERE {$identity}Username = ? AND {$identity}Password = ?";
    $stmt = $DBconn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if a matching user is found
    if ($result->num_rows == 1) {
        // Successful login, redirect to a welcome page based on user type
        header("Location: $redirectPage");
        exit();
    } else {
        // Invalid login, redirect back to the login form with an error message
        echo "<script>alert('Invalid login. Please try again.');window.location.href='login.php'</script>";
        exit();
    }

    // Close the prepared statement
    $stmt->close();
} else {
    // If someone tries to access this page directly, redirect them to the login form
    header("Location: login.php");
    exit();
}