<?php
session_start(); 
require('config.php');
$query = mysqli_prepare($conn, "SELECT DISTINCT category FROM category_list;");
mysqli_stmt_execute($query);
$result = mysqli_stmt_get_result($query);
$rows = mysqli_num_rows($result);
$categories = [];
if ($rows > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row['category'];
    }
}
else {
    echo'
    <script>
    alert("An Error Occurred");
    </script>';
    header('Location: expense_management.php');
}
?>

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
        <h2 style='margin-right: auto;'>Add New Expense</h2>
    </div>
    <hr>
    <form method="post" onsubmit='validateNewBudgetOrExpenseForm(document.getElementById("amount"))' class='standard_form'>
        <label for="category">Category</label><br>
        <select id="category" name="category">
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="amount">Amount</label><br>
        <textarea id="amount" name="amount" oninput="formatNumber(this)"></textarea><br><br>

        <label for="description">Description</label><br>
        <textarea id="description" name="description"></textarea><br><br>
        <div class='save_and_cancel'>
            <button type="submit" class="standard_button save_button"><i class="fa-solid fa-upload"></i>Save</button>
            <button type="button" onclick="window.location.href = 'expense_management.php'" class='standard_button cancel_button'><i class="fa-solid fa-xmark"></i>Cancel</button>
        </div>
    </form>
</div>
</div>
</body>
</html>

<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $category = $_POST["category"];
        $amount = $_POST["amount"];
        $description = $_POST["description"];
        $datecreated = date("Y-m-d");
        $query = mysqli_prepare($conn, "INSERT INTO expense_management (category, description, amount, datecreated) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($query, "ssis", $category, $description, $amount, $datecreated);
        mysqli_stmt_execute($query);
        $rowsAffected = mysqli_stmt_affected_rows($query);
        if ($rowsAffected > 0) {
            echo'
            <script>
            alert("New Expense Created Successfully");
            </script>';
            header('Location: expense_management.php');
        } 
        else {
            echo'
            <script>
            alert("An Error Occurred. No New Expense Created");
            </script>';
        }
        mysqli_close($conn);
    }
?>