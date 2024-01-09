<?php
require_once('connection.php'); 

//student with classID
function registerStudentWithClassID($DBconn, $username, $fullname, $password, $classID) {
    registerUser($DBconn, $username, $fullname, $password, 'Student', $classID);
}

// student without classID
function registerStudentWithoutClassID($DBconn, $username, $fullname, $password) {
    registerUser($DBconn, $username, $fullname, $password, 'Student');
}

// teacher
function registerTeacher($DBconn, $username, $fullname, $password) {
    registerUser($DBconn, $username, $fullname, $password, 'Teacher');
}

// registration function
function registerUser($DBconn, $username, $fullname, $password, $identity, $classID = null) {
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

    // Check if the provided class ID is not empty
    if (!empty($classID)) {
    // Check if the provided class ID exists in the class table
    $checkClassSql = "SELECT * FROM class WHERE classID = ?";
    $checkClassStmt = $DBconn->prepare($checkClassSql);
    $checkClassStmt->bind_param("s", $classID);
    $checkClassStmt->execute();
    $checkClassResult = $checkClassStmt->get_result();

    if ($checkClassResult->num_rows == 0) {
        // Invalid Class ID, show an alert and redirect back to register.php
        echo "<script>alert('Invalid Class ID.');</script>";
        echo "<script>window.location.href = 'register.php';</script>";
        exit();
    }
}


    // Insert user data
    $insertUserSql = "INSERT INTO $table ({$identity}Username, {$identity}FullName, {$identity}Password";

    
    // Add classID column for students if classID is provided
    if ($identity === 'Student' && isset($classID)) {
        $insertUserSql .= ", ClassID";
    }

    $insertUserSql .= ") VALUES ('$username', '$fullname', '$password'";


    // Add classID value for students if classID is provided
    if ($identity === 'Student' && isset($classID)) {
        $insertUserSql .= ", $classID";
    }

    $insertUserSql .= ")";

    $insertUserResult = $DBconn->query($insertUserSql);

    // Check if the user record was inserted successfully
    if (!$insertUserResult) {
        // error or log the issue
        if ($identity === 'Student') {
            header("Location: register.php?error=studentinserterror");
        } else {
            header("Location: register.php?error=teacherinserterror");
        }
        exit();
    }

    // Redirect to success page
    header("Location: $redirectPage?success=1");
    exit();
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve registration data from the form
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $fullname = isset($_POST['fullname']) ? $_POST['fullname'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $identity = isset($_POST['identity']) ? $_POST['identity'] : '';
    $classID = isset($_POST['classID']) ? $_POST['classID'] : null;

    // Determine which registration function to call based on the identity
    if ($identity === 'Student' && empty($classID)) {
        registerStudentWithoutClassID($DBconn, $username, $fullname, $password);
    } elseif ($identity === 'Student' && isset($classID)) {
        registerStudentWithClassID($DBconn, $username, $fullname, $password, $classID);
    } elseif ($identity === 'Teacher') {
        registerTeacher($DBconn, $username, $fullname, $password);
    } else {
        header("Location: register.php?error=unknownidentity");
        exit();
    }
} else {
    header("Location: register.php");
    exit();
}


// alert

if (isset($_GET['error']) && $_GET['error'] === 'usernametaken') {
    echo "<script>alert('The Username is Already Taken. Please Choose Another Username.');</script>";
}

if (isset($_GET['error']) && $_GET['error'] === 'invalidclassid') {
    echo "<script>alert('Invalid Class ID.');</script>";
}

if (isset($_GET['error'])) {
    $error = $_GET['error'];
    if ($error === 'studentinserterror' || $error === 'teacherinserterror') {
        echo "<script>alert('Insert Error. Please Try Again.');</script>";
    }
}

?>
