<?php
//file checking part
$_SESSION['TeacherUsername']="maow";
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
    //Question Set Name 
    $QuestionSetName = $_POST['QuestionSetName'];
    //Getting the topicID from the topic name
    $TopicName = $_POST['SelectedTopic']; 
    $resultTopicID = mysqli_fetch_assoc(mysqli_query($conn, "SELECT TopicID FROM Topic WHERE TopicTitle = '$TopicName'"));
    $TopicID = $resultTopicID['TopicID'];
    //Teacher Username from session variable
    $TeacherUsername = $_SESSION['TeacherUsername']; //remember to change this to session variable
    $ApprovalStatus = "Pending";
    $QuestionSetQuery = mysqli_query($conn, "INSERT INTO Question_Set VALUES ('DEFAULT', '$QuestionSetName', '$TeacherUsername', '$TopicID', '$ApprovalStatus')");
    //Getting the SetID from the Question_Set table
    $resultSetID = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SetID FROM Question_Set WHERE SetName = '$QuestionSetName' AND TeacherUsername = '$TeacherUsername'"));
    $SetID = $resultSetID['SetID'];
    //Question insertion part  
    $file = fopen($targetfile, "r");
    //mysqli_begin_transaction($conn); IMPLEMENT TRANSACTION IF TIME ALLOWS
    $counter = 1;
    while (($data = fgetcsv($file)) ==! FALSE){
        $import = "INSERT INTO Question VALUES ('DEFAULT', '$SetID', '$data[0]', '$data[1]', '$data[2]', '$data[3]', '$data[4]', '$data[5]', '$data[6]')";
        if(mysqli_query($conn, $import)){
            echo "<br>Record $counter added successfully.";
            $counter++;
        }
        else{
            echo "An error occured while adding record $counter." ."<br>".mysqli_error($conn);
            $counter++;
        }
    }
    fclose($file);
}
?>