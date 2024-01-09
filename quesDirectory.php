<?php
$SetID = $_POST['SetID'];
$TrialID = $_POST['TrialID'];
$Mode = $_POST['Mode'];
$currentQuestionNum = $_POST['quesNo'];

//sql to get number questions - Q1, Q2, Q3
$SQLnumques = "SELECT * FROM question WHERE SetID = '$SetID';";
$runSQLnumques = mysqli_query($DBconn, $SQLnumques);
?>

<script>
    //submit form automatically
    function submitForm() {
        document.getElementById('directoryForm').submit();
    }
</script>

<table border="1">
    <?php
    while ($data = mysqli_fetch_array($runSQLnumques)) {
        $quesID = $data['QuestionID'];
        $quesnum = $data['QuestionNumber'];

        //sql to check whether the question is answered 
        $SQLcheck = "SELECT * FROM student_answer WHERE TrialID = '$TrialID' AND QuestionID = '$quesID';";
        $runSQLcheck = mysqli_query($DBconn, $SQLcheck);
        $num = mysqli_num_rows($runSQLcheck);

        ?>
        <tr><td><form id='directoryForm' method='post' action=''>
        <input type="hidden" name="SetID" value="<?php echo $SetID;?>">
        <input type="hidden" name="TrialID" value="<?php echo $TrialID;?>">
        <input type="hidden" name="Mode" value="<?php echo $Mode;?>">
        <input type="hidden" name="quesNo" value="<?php echo $quesnum;?>">
        <input type="hidden" name="beginquiz" value="">
        <button onclick="submitForm()" <?php if ($quesnum == $currentQuestionNum) echo "style='background-color: rgba(71, 168, 237, 0.25); font-weight: bold; color: black;'"; ?>>
        <?php
        if ($num > 0) {
            //if the question is answered
            echo "Question ".$quesnum."&check;";
        } else {
            //if the question is not answered
            echo "Question ".$quesnum;
        }
        echo "</button></form></td></tr>";
    }
    ?>
</table>