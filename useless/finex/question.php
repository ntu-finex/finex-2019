<?php
$result=mysqli_query($conn,"SELECT * FROM utility WHERE name='current_ques'");
if ($row = mysqli_fetch_array($result)){
    $current = $row['number'];
}
$result=mysqli_query($conn,"SELECT * FROM questions WHERE question_id =".$current);
if ($row = mysqli_fetch_array($result)){
    $question = $row['question'];
    $a = $row['a'];
    $b = $row['b'];
    $c = $row['c'];
    $d = $row['d'];
    $e = $row['e'];
}
if(strcasecmp($a,"-")==0){
    echo "<style>.control_a{display:none}</style>";
}
if(strcasecmp($b,"-")==0){
    echo "<style>.control_b{display:none}</style>";
}
if(strcasecmp($c,"-")==0){
    echo "<style>.control_c{display:none}</style>";
}
if(strcasecmp($d,"-")==0){
    echo "<style>.control_d{display:none}</style>";
}
if(strcasecmp($e,"-")==0){
    echo "<style>.control_e{display:none}</style>";
}
if($answered==$current){
    echo "<style>.control{display:none}</style>";
}
if(isset($_POST['give'])&&($answered<$current)){
    $result=mysqli_query($conn,"SELECT * FROM answers WHERE question_id = ".$current);
    if ($row = mysqli_fetch_array($result)){
        $answer = $row['correct_ans'];
        $diff = $row['difficulty'];
    }
    $result = mysqli_query($conn,"SELECT * FROM utility WHERE name = '".$diff."'");
    if ($row = mysqli_fetch_array($result)){
        $earned_coin = $row['number'];
    }
    if(strcasecmp($answer,$_POST['answer'])==0){
        //correct answer
        $updatedcoin = $coin + $earned_coin;
        $query2 = "UPDATE team SET coin = ".$updatedcoin." WHERE teamname='".$teamname."'";
        mysqli_query($conn,$query2);
        $_SESSION['message'] = "You have answered correctly. Earn ".$earned_coin." share unit(s).";
    }else{
        $_SESSION['message'] = "You have answered wrong. Jiayouus :)";
    }
    $query1 = "UPDATE team SET answered = ".$current." WHERE teamname='".$teamname."'";
    $query3 = "INSERT INTO answer_log (teamname,question_id,answer) VALUES ('".$teamname."',".$current.",'".$answer."')";
    if(mysqli_query($conn,$query1)&&mysqli_query($conn,$query3)){
        echo "<script> location.replace('index.php'); </script>";
    }
}
?>

<div class="container">
    <br/>
    <div class="card mx-auto" style="width:80%;">
        <div class="card-header text-center">
            <h3>Quiz</h3>
        </div>
        <div class="card-body">
            <div class="card">
                <div class="card-body">
                    <?php
                        echo '<h3>'.$question.'</h3>';
                    ?>
                </div>
            </div>
            <br/>
            <div class="text-center">
                <p>
                <?php
                    if($answered==$current){
                        $query = "SELECT * FROM answers WHERE question_id =".$current;
                        $result = mysqli_query($conn,$query);
                        $row = mysqli_fetch_array($result);
                        $correct = strtolower($row['correct_ans']);
                        $query = "SELECT * FROM questions WHERE question_id =".$current;
                        $result = mysqli_query($conn,$query);
                        $row = mysqli_fetch_array($result);
                        echo "<h3 style='color:green;'><u>Answer</u></h3>";
                        echo "<p style='color:green;'>".$row[$correct]."</p>";
                    }
                ?>
                </p>
            </div>
            <div class="control">
            <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <div class="form-group">
                    <div class="form-check">
                        <div class="custom-control custom-radio form-check-input control_a">
                            <input type="radio" id="a" name="answer" class="custom-control-input" value="a">
                            <label class="custom-control-label" for="a">
                                <?php
                                    echo $a;
                                ?>
                            </label>
                        </div>
                        <div class="custom-control custom-radio form-check-input control_b">
                            <input type="radio" id="b" name="answer" class="custom-control-input" value="b">
                            <label class="custom-control-label" for="b">
                                <?php
                                    echo $b;
                                ?>
                            </label>
                        </div>
                        <div class="custom-control custom-radio form-check-input control_c">
                            <input type="radio" id="c" name="answer" class="custom-control-input" value="c">
                            <label class="custom-control-label" for="c">
                                <?php
                                    echo $c;
                                ?>
                            </label>
                        </div>
                        <div class="custom-control custom-radio form-check-input control_d">
                            <input type="radio" id="d" name="answer" class="custom-control-input" value="d">
                            <label class="custom-control-label" for="d">
                                <?php
                                    echo $d;
                                ?>
                            </label>
                        </div>
                        <div class="custom-control custom-radio form-check-input control_e">
                            <input type="radio" id="e" name="answer" class="custom-control-input" value="e">
                            <label class="custom-control-label" for="e">
                                <?php
                                    echo $e;
                                ?>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <input type="submit" name="give" value="Submit" class="btn btn-primary" />
                </div>
            </form>
            </div>
        </div>
    </div>
</div>