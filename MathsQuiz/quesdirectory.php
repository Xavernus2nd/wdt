<?php
$set = $_POST['setID'];
$trialID = $_POST['trialID'];
$mode = $_POST['mode'];

//sql to get number questions - Q1, Q2, Q3
$SQLnumques = "SELECT * FROM question WHERE SetID = '$set';";
$runSQLnumques = mysqli_query($DBconn, $SQLnumques);

?>
<table border="1">
    <?php
    while ($data = mysqli_fetch_array($runSQLnumques)) {
        $quesID = $data['QuestionID'];
        $quesnum = $data['QuestionNumber'];

        //sql to check whether the question is answered 
        $SQLcheck = "SELECT * FROM student_answer WHERE TrialID = '$trialID' AND QuestionID = '$quesID';";
        $runSQLcheck = mysqli_query($DBconn, $SQLcheck);
        $num = mysqli_num_rows($runSQLcheck);

        ?>
        <tr><td><form id='directoryForm' method='post' action=''>
        <input type="hidden" name="setID" value="<?php echo $set;?>">
        <input type="hidden" name="trialID" value="<?php echo $trialID;?>">
        <input type="hidden" name="mode" value="<?php echo $mode;?>">
        <input type="hidden" name="quesNo" value="<?php echo $quesnum;?>">
        <input type="hidden" name="beginquiz" value="">
        <button onclick="directForm()">
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

<script>
    //submit form automatically
    function submitForm() {
        document.getElementById('directoryForm').submit();
    }
</script>