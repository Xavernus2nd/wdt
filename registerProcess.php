<!--still editing-->


<?php
require_once('connection.php'); // Include the database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve registration data from the form
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $fullname = isset($_POST['fullname']) ? $_POST['fullname'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $identity = isset($_POST['identity']) ? $_POST['identity'] : '';
    $classID = isset($_POST['classID']) ? $_POST['classID'] : null;

    // Validate input data (you may want to perform more validation)
    if (empty($username) || empty($fullname) || empty($password) || empty($identity)) {
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
    $checkUsernameSql = "SELECT * FROM $table WHERE {$identity}Username = '$username'";
    $checkUsernameResult = $DBconn->query($checkUsernameSql);

    if ($checkUsernameResult->num_rows > 0) {
        // Redirect back to the registration form with an error message
        header("Location: register.php?error=usernametaken");
        exit();
    }

    if ($identity === 'Student') {
        // Insert the student with optional classID
        $insertUserSql = "INSERT INTO $table ({$identity}Username, {$identity}FullName, {$identity}Password, ClassID) VALUES ('$username', '$fullname', '$password', $classID)";
    
        $insertUserResult = $DBconn->query($insertUserSql);
    
        // Check if the student record was inserted successfully
        if (!$insertUserResult) {
            // Handle error or log the issue
            header("Location: register.php?error=studentinserterror");
            exit();
        }
    } else {
        // Insert the teacher without classID
        $insertUserSql = "INSERT INTO $table ({$identity}Username, {$identity}FullName, {$identity}Password) VALUES ('$username', '$fullname', '$password')";
    
        $insertUserResult = $DBconn->query($insertUserSql);
    
        // Check if the teacher record was inserted successfully
        if (!$insertUserResult) {
            // Handle error or log the issue
            header("Location: register.php?error=teacherinserterror");
            exit();
        }
    }
    

    // Redirect to a success page or login page
    header("Location: $redirectPage");
    exit();
} else {
    // If someone tries to access this page directly, redirect them to the registration form
    header("Location: register.php");
    exit();
}
?>
