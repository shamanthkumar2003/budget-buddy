<?php session_start(); require('config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budget Buddy</title>
</head>
<body>

<?php include 'navbar.php' ?>
<div class='main'>
<div class='sub_main_rounded'>
<div style='display:flex; '>
    <h2 style='margin-right: auto;'>Budget Report</h2>
</div>
<hr>
<div>
    <form method='post'>
        <div class='dates'>
            <div>
                <label for='datestart'>Date Start</label>
                <input type="date" id='datestart' name='datestart'>
            </div>
            <div>
                <label for='dateend'>Date End</label>
                <input type="date" id='dateend' name='dateend'>
            </div>
        </div>
        <div class = 'filter_and_print'>
            <button type='submit' name='filter' class='standard_button filter_button'><i class="fa-solid fa-filter"></i>Filter</button>
            <button type='button' onclick='printTable("printable")' class='standard_button print_button'><i class="fa-solid fa-print"></i>Print</button>
        </div>
    </form>
</div>
<hr>
<div id='printable'>
    <h3 style='text-align:center'>Budget and Expense Tracker System</h3>
    <h3 style='text-align:center'>Budget Report</h3>
    <?php
        if(isset($_POST['filter'])){
            if(empty($_POST['datestart'])||empty($_POST['dateend'])){
                echo '<script>alert("Choose a Start Date and an End Date");</script>';
            }
            $datestart = $_POST['datestart'];
            $dateend = $_POST['dateend'];
        }
    ?>
    <pre style='text-align:right; font-size:15px'><b>From: <?php if(isset($datestart)){echo $datestart ;}?>   To: <?php if(isset($dateend)){echo $dateend ;}?></b></pre>
    <table class='standard_table'>
        <tr>
            <th>ID</th>
            <th>Date created</th>
            <th>Category</th>
            <th>Amount</th>
            <th>Description</th>
        </tr>
        <?php
            if(isset($_POST['filter'])){
                $query = mysqli_prepare($conn, "SELECT * FROM budget_management WHERE datecreated BETWEEN ? AND ?");
                mysqli_stmt_bind_param($query, "ss", $datestart, $dateend);
                mysqli_stmt_execute($query);
                $result = mysqli_stmt_get_result($query);
                $rows = mysqli_num_rows($result);
                if ($rows > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>".$row["id"]."</td>";
                        echo "<td>".$row["datecreated"]."</td>";
                        echo "<td>".$row["category"]."</td>";
                        echo "<td>".$row["amount"]."</td>";
                        echo "<td>".$row["description"]."</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>0 results</td></tr>";
                }
                mysqli_close($conn);
            }
        ?>
    </table>
</div>
</div>
</div>
</body>
</html>