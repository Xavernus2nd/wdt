<?php
//file checking part
include 'connection.php';
if (isset($_POST['import'])){
    $targetfile = "CSV/" . $_FILES["fileToUpload"]["name"];
    $filetype = strtolower(pathinfo($targetfile,PATHINFO_EXTENSION));
    if ($filetype != "csv"){
        echo "<script>alert('Only CSV files are allowed.');</script>";
        header("Refresh:0; url=addQuestionSet.php");
        die();
    }
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetfile)){
        echo "<script>alert('The file \"". $_FILES["fileToUpload"]["name"]. "\" has been uploaded.');</script>";
    } else {
        echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
        header("Refresh:0; url=addQuestionSet.php");
        die();
    }
    //Question Set Part
    //Question Set Name 
    $QuestionSetName = $_POST['QuestionSetName'];
    //Getting the topicID from the topic name
    $TopicName = $_POST['SelectedTopic']; 
    $resultTopicID = mysqli_fetch_assoc(mysqli_query($DBconn, "SELECT TopicID FROM Topic WHERE TopicTitle = '$TopicName'"));
    $TopicID = $resultTopicID['TopicID'];
    //Teacher Username from session variable
    $TeacherUsername = $_SESSION['TeacherUsername']; //remember to change this to session variable
    $ApprovalStatus = "PENDING";
    $QuestionSetQuery = mysqli_query($DBconn, "INSERT INTO Question_Set VALUES ('DEFAULT', '$QuestionSetName', '$TeacherUsername', '$TopicID', '$ApprovalStatus')");
    //Getting the SetID from the Question_Set table
    $resultSetID = mysqli_fetch_assoc(mysqli_query($DBconn, "SELECT SetID FROM Question_Set ORDER BY SetID DESC LIMIT 1"));
    $SetID = $resultSetID['SetID'];
    //Question insertion part  
    $file = fopen($targetfile, "r");
    $counter = 1;
    $alert = "";
    while (($data = fgetcsv($file)) ==! FALSE){
        $import = "INSERT INTO Question VALUES ('DEFAULT', '$SetID', '$data[0]', '$data[1]', '$data[2]', '$data[3]', '$data[4]', '$data[5]', '$data[6]')";
        if(mysqli_query($DBconn, $import)){
            $alert = $alert . "Record $counter added successfully." . "\\n";
            $counter++;
        }
        else{
            $alert = $alert . "An error occured while adding record $counter." . "\\n";
            $counter++;
        }
    }
    echo "<script>alert('$alert');</script>";
    fclose($file);
    header("Refresh:0; url=addQuestionSet.php");
}
?>