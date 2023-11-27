<?php
//file checking part
if (isset($_POST['import'])){
    $targetdir = "CSV/";
    $targetfile = $targetdir . basename($_FILES["fileToUpload"]["name"]);
    $filetype = strtolower(pathinfo($targetfile,PATHINFO_EXTENSION));
    if ($filetype != "csv"){
        die("Only CSV files are allowed.");
    }
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetfile)){
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        die("Sorry, there was an error uploading your file.");
    }
    //Question Set Part
    //auto-increment for the set id
    $sqlMaxSetID = "SELECT MAX(CAST(SUBSTRING(setID, 2) AS UNSIGNED)) AS maxID FROM question_set";
    $resultMaxSetID = mysqli_query($conn, $sqlMaxSetID);
    $rowMaxSetID = mysqli_fetch_assoc($resultMaxSetID);
    $maxSetID = $rowMaxSetID['maxID'];
    $nextID = $maxSetID + 1;
    $QuestionSetId = "S" . str_pad($nextID, 3, "0", STR_PAD_LEFT);
    //auto-increment for the question id
    $sqlMaxQuestionID = "SELECT MAX(CAST(SUBSTRING(questionID, 2) AS UNSIGNED)) AS maxID FROM question";
    $resultMaxQuestionID = mysqli_query($conn, $sqlMaxQuestionID);
    $rowMaxQuestionID = mysqli_fetch_assoc($resultMaxQuestionID);
    $maxQuestionID = $rowMaxQuestionID['maxID'];
    $nextID = $maxQuestionID + 1;
    $QuestionID = "Q" . str_pad($nextID, 5, "0", STR_PAD_LEFT);
    //Question Set Name 
    $QuestionSetName = $_POST['QuestionSetName'];
    //Getting the topicID from the topic name
    $TopicName = $_POST['TopicName']; 
    $sqlTopicID = "SELECT TopicID FROM Topic WHERE TopicTitle = '$TopicName'";
    $resultTopicID = mysqli_query($conn, $sqlTopicID);
    $rowTopicID = mysqli_fetch_assoc($resultTopicID);
    $TopicID = $rowTopicID['TopicID'];
    //Teacher Username from session variable
    $TeacherUsername = $_SESSION['TeacherUsername']; //remember to change this to session variable
    $ApprovalStatus = "Pending";
    $QuestionSetQuery = mysqli_query($conn, "INSERT INTO QuestionSet VALUES ('$QuestionSetID', '$QuestionSetName', '$TeacherUsername', '$TopicID', '$ApprovalStatus')");
    //Question insertion part  
    $file = fopen($targetfile, "r");
    //mysqli_begin_transaction($conn); IMPLEMENT TRANSACTION IF TIME ALLOWS
    while (($data = fgetcsv($file)) ==! FALSE){
        $import = "INSERT INTO Question VALUES ('$data[0]', '$data[1]', '$data[2]', '$data[3]', '$data[4]', '$data[5]', '$data[6])";
        if(mysqli_query($conn, $import)){
            echo "Records added successfully.";
        }
        else{
            echo "An error occured while adding records. " ."<br>".mysqli_error($conn);
            
        }
    }
    mysqli_query($conn, $QuestionSetQuery);
    fclose($file);
}
?>