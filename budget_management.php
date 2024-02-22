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
        <h2 style='margin-right: auto;'>Budget Management</h2>
        <button type="button" onclick="window.location.href = 'add_new_budget.php'" class='standard_button add_button' style='margin-left:auto'><i class="fa-solid fa-plus"></i>Add New</button>
    </div>
    <hr>
    <div style='display:flex'>
        <input type="text" class="search_box" onkeyup="searchCategory()" placeholder="Search.." title="Search for a category">
    </div>
    <div>
    <table class='standard_table'>
        <tr>
            <th>ID</th>
            <th>Date created</th>
            <th>Category</th>
            <th>Amount</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
        <?php
            $query = mysqli_prepare($conn, "SELECT * FROM budget_management");
            mysqli_stmt_execute($query);
            $result = mysqli_stmt_get_result($query);
            $rows = mysqli_num_rows($result);
            $srn=0;
            if ($rows > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>".(++$srn)."</td>";
                    echo "<td>".$row["datecreated"]."</td>";
                    echo "<td>".$row["category"]."</td>";
                    echo "<td>".$row["amount"]."</td>";
                    echo "<td>".$row["description"]."</td>";
                    echo "<td><select onclick='disableActionOption()' onchange='handleBudgetListAction(this, \"" . $row["id"] . "\")')'>
                        <option value='' class='actionOption' selected >Action</option>
                        <option value='edit'>Edit</option>
                        <option value='delete'>Delete</option>
                        </select></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>0 results</td></tr>";
            }
            mysqli_close($conn);
        ?>
    </table>
    </div>
</div>
</div>
</body>
</html>