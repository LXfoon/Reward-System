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
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="title">
    <img src="source.gif" alt="star" class = "img"><h1>Productivity Reward System</h1><img src="source.gif" alt="star" class = "img" id="img2">
    </div>

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
                
                echo "<p id = 'totPoint'>".$sum - $minus."</p>";
                echo "<br><p id = 'current'>Current points</p>";
            ?>
        </h2>
    </div>
    
<div id="wrap">
    <div class="quick">
        <h3>Quick Select</h3>

        <div id="quickBtn">
        <form action="" method = "post">
            <div id="btnsTop">
            <button name = "quickSel" value="five" class="btns">
                <h4>+5</h4>
                <p>Small tasks</p>
            </button>
            
            <button name = "quickSel" value="ten" class="btns">
                <h4>+10</h4>
                <p>Medium tasks</p>
            </button>
            </div>

            <div id="btnsBottom">
            <button name = "quickSel" value="twenty" class="btns">
                <h4>+20</h4>
                <p>Big tasks</p>
            </button>

            <button name = "quickSel" value="fifty" class="btns">
                <h4>+50</h4>
                <p>Hard tasks</p>
            </button>
            </div>
        </form>
        </div>
    </div>

    <div class="custPoint">
         <form action="" method = "post">
            <h3>Custom Point</h3>

            <p>Point Amount: <br>
            <input type="number" name="pointAmount" class="txtCust" placeholder= "Enter amount..." require>
            </p>

            <p id="desc">Description: <br>
            <input type="text" name="description" class="txtCust" placeholder="Enter details..."> 
            </p>

            <div id="custBtnsCon">
            <button name="custBtn" value="pos" class="custBtns">+</button>
            <button name="custBtn" value  = "neg" class="custBtns">-</button>
            </div>

        </form>
    </div>
    </div>

    <br>

    <h3 id= "subH3">Point Distribution</h3>
    <div id="details">
        <div id="earnP">
        <h4>Earn Points</h4>
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
                <td>Wake up early (b4 11am)</td>
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
                <td>Drink 2 cups of water (per day)</td>
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
                <td>Workout</td>
                <td>10</td>
            </tr>
        </table>
        </div>

        <div id="rewardP">
        <h4>Rewards</h4>
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
    </div>

    <br><h3 id= "subH3">History</h3>
    <div id="history">
        <div id="earnHis">
        <h4>Earned</h4>
            <?php 
            $earnSql = "SELECT * FROM point WHERE cal = 'P' ORDER BY pointID DESC";
            $earnRes = mysqli_query($conn, $earnSql);

            if(mysqli_num_rows($earnRes) >0){?>
            <table>
                <tr>
                    <th>Tasks</th>
                    <th>Points gained</th>
                </tr>

                <?php
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
            }else{
                echo "<p>No results found</p>";
            }
            ?>
            </table>
        </div>

        <div id="usedHis">
            <h4>Used</h4>
            <?php 
                $usedSql = "SELECT * FROM point WHERE cal = 'N'  ORDER BY pointID DESC";
                $usedRes = mysqli_query($conn, $usedSql);

                if(mysqli_num_rows($usedRes)>0) {?>

                <table>
                    <tr>
                        <th>Reward</th>
                        <th>Points used</th>
                    </tr>

                    <?php
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
                    }else{
                        echo "<p>No results found</p>";
                    }
                    ?>
                </table>
            </div>
    </div>

</body>

<footer>
    <p>Foon | laufoonxuan@gmail.com</p>
</footer>
</html>