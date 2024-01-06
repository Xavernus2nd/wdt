<?php
require_once('connection.php'); // Include the database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve registration data from the form
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $fullname = isset($_POST['fullname']) ? $_POST['fullname'] : '';
    $identity = isset($_POST['identity']) ? $_POST['identity'] : '';

    // Validate input data (you may want to perform more validation)
    if (empty($username) || empty($password) || empty($fullname) || empty($identity)) {
        // Redirect back to the registration form with an error message
        header("Location: register.php?error=emptyfields");
        exit();
    }

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
        default:
            // Handle unknown user type
            header("Location: register.php?error=unknownidentity");
            exit();
    }

    // Check if the username is already taken
    $checkUsernameSql = "SELECT * FROM $table WHERE {$identity}Username = ?";
    $checkUsernameStmt = $DBconn->prepare($checkUsernameSql);
    $checkUsernameStmt->bind_param("s", $username);
    $checkUsernameStmt->execute();
    $checkUsernameResult = $checkUsernameStmt->get_result();

    if ($checkUsernameResult->num_rows > 0) {
        // Redirect back to the registration form with an error message
        header("Location: register.php?error=usernametaken");
        exit();
    }

    // Hash the password (you should use a stronger hashing method in production)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert the user into the database
    $insertUserSql = "INSERT INTO $table ({$identity}Username, {$identity}FullName, {$identity}Password) VALUES (?, ?, ?)";
    $insertUserStmt = $DBconn->prepare($insertUserSql);
    $insertUserStmt->bind_param("sss", $username, $fullname, $hashedPassword);
    $insertUserStmt->execute();

    // Redirect to a success page or login page
    header("Location: $redirectPage");
    exit();

    // Close the prepared statements
    $checkUsernameStmt->close();
    $insertUserStmt->close();
} else {
    // If someone tries to access this page directly, redirect them to the registration form
    header("Location: register.php");
    exit();
}
?>
