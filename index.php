<?php
include 'conn.php';

//custom points
if(isset($_POST['custBtn'])){
    $pointAmount = $_POST['pointAmount'];
    $tasks = $_POST['description'];

    if($_POST['custBtn'] === 'pos'){
        $cal = "P";
    }elseif($_POST['custBtn'] === 'neg'){
        $cal = "N";
    }

    $custSql = "INSERT INTO point (pointNum, description, cal) VALUES('$pointAmount', '$tasks', '$cal')";
    mysqli_query($conn, $custSql);
    header("Location: index.php"); 
    die(); 
}  

//quick select
if(isset($_POST['quickSel'])){
    if($_POST['quickSel'] === 'five'){
        $pointAmount = 5;
        $tasks = "Small task";

    }elseif($_POST['quickSel'] === 'ten'){
        $pointAmount = 10;
        $tasks = "Medium task";

    }elseif($_POST['quickSel'] === 'twenty'){
        $pointAmount = 20;
        $tasks = "Big task";

    }elseif($_POST['quickSel'] === 'fifty'){
        $pointAmount = 50;
        $tasks = "Hard task";

    }else{
        echo "alert('An error has occured!')";
    }

    $cal = "P";
    $sql = "INSERT INTO point (pointNum, description, cal) VALUES('$pointAmount', '$tasks', '$cal')";
    mysqli_query($conn, $sql);
    header("Location: index.php"); 
    die(); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Point System</title>
</head>
<body>
    <h1>Productivity Reward System</h1>

    <div class="point">
        <h2>
            <?php
                $posSql = "SELECT SUM(pointNum) AS total_sum FROM point WHERE cal='P'";
                $posRes = mysqli_query($conn, $posSql);

                if($posRes){
                    $posRow = mysqli_fetch_assoc($posRes);
                    $sum = $posRow['total_sum'];
                }

                $negSql = "SELECT SUM(pointNum) AS total_neg FROM point WHERE cal='N'";
                $negRes = mysqli_query($conn, $negSql);

                if($negRes){
                    $negRow = mysqli_fetch_assoc($negRes);
                    $minus = $negRow['total_neg'];
                }
                
                echo $sum - $minus;
            ?>
        </h2>
    </div>

    <div class="presetPoint">
        <div class="presetPoin">
        <h3>Quick Select</h3>

        <div class="quick">
                <form action="" method = "post">
                    <button name = "quickSel" value="five">
                        <h4>+5</h4>
                        <p>Small tasks</p>
                    </button>

                    <button name = "quickSel" value="ten">
                        <h4>+10</h4>
                        <p>Medium tasks</p>
                    </button>

                    <button name = "quickSel" value="twenty">
                        <h4>+20</h4>
                        <p>Big tasks</p>
                    </button>

                    <button name = "quickSel" value="fifty">
                        <h4>+50</h4>
                        <p>Hard tasks</p>
                    </button>
                </form>
        </div>
        
    </div>

    <div class="custPoint">
         <form action="" method = "post">
            <hr>
            <h3>Custom Point</h3>

            <p>Point Amount: 
            <input type="number" name="pointAmount" require>
            </p>

            <p>Description: 
            <input type="text" name="description">
            </p>

            <button name="custBtn" value="pos">+</button>
            <button name="custBtn" value  = "neg">-</button>
                
        </form>
    </div>
    
    <br>
    <hr>
    <div id="details">
        <h3>Point Distribution</h3>
        <h4>Earn Points:</h4>
        <table>
            <tr>
                <th>Tasks</th>
                <th>Amount (/h)</th>
            </tr>

            <tr>
                <td>Work</td>
                <td>50</td>
            </tr>

            <tr>
                <td>Wake up early</td>
                <td>20</td>
            </tr>

            <tr>
                <td>New skills/ Project</td>
                <td>20</td>
            </tr>

            
            <tr>
                <td>Save RM100 (per month)</td>
                <td>20</td>
            </tr>

            <tr>
                <td>Revision</td>
                <td>10</td>
            </tr>

            <tr>
                <td>Assignment</td>
                <td>10</td>
            </tr>

            <tr>
                <td>Stretch</td>
                <td>5</td>
            </tr>

            <tr>
                <td>Cooking</td>
                <td>5</td>
            </tr>
        </table>

        <h4>Rewards:</h4>
        <table>
            <tr>
                <th>Rewards</th>
                <th>Amount</th>
            </tr>

            <tr>
                <td>Grand items (&ge;RM300)</td>
                <td>500</td>
            </tr>

            <tr>
                <td>Expensive items (&le;RM100)</td>
                <td>300</td>
            </tr>

            <tr>
                <td>Mid range items (&le; RM50)</td>
                <td>100</td>
            </tr>

            <tr>
                <td>Beverage (~RM20)</td>
                <td>30</td>
            </tr>

            <tr>
                <td>Sweets/Snacks(~RM10)</td>
                <td>10</td>
            </tr>
        </table>
    </div>

    <hr>
    <div id="history">
        <h3>History</h3>
        <h4>Earned: </h4>
            <table>
                <tr>
                    <th>Tasks</th>
                    <th>Points</th>
                </tr>

                    <?php
                        $earnSql = "SELECT * FROM point WHERE cal = 'P'";
                        $earnRes = mysqli_query($conn, $earnSql);

                        while($earnRow = mysqli_fetch_assoc($earnRes)){
                                if($earnRow['description'] == null){
                                    $title = "None";
                                }else{
                                    $title = $earnRow['description'];
                                }
                                $earnAmt = $earnRow['pointNum'];?>

                                <tr>
                                    <td><?php echo $title;?></td>
                                    <td><?php echo $earnAmt;?></td>
                                </tr>
                                <?php
                            }
                    ?>
            </table>

        <h4>Used: </h4>
        <table>
            <tr>
                <th>Reward</th>
                <th>Points used</th>
            </tr>

                <?php
                    $usedSql = "SELECT * FROM point WHERE cal = 'N'";
                    $usedRes = mysqli_query($conn, $usedSql);

                    while($usedRow = mysqli_fetch_assoc($usedRes)){
                        if($usedRow['description'] == null){
                                    $reward = "None";
                                }else{
                                    $reward = $usedRow['description'];
                                }
                                $pointUsed = $usedRow['pointNum'];?>

                            <tr>
                                <td><?php echo $reward?></td>
                                <td><?php echo $pointUsed?></td>
                            </tr>
                            <?php
                        }
                ?>
            </table>
    </div>

</body>

<footer>
    <hr>
    <p>Foon | laufoonxuan@gmail.com</p>
</footer>
</html>