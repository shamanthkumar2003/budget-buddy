<?php session_start();
require('config.php');
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $query = mysqli_prepare($conn, "SELECT * FROM budget_management WHERE id = ? ");
    mysqli_stmt_bind_param($query, "s", $id);
    mysqli_stmt_execute($query);
    $result = mysqli_stmt_get_result($query);
    $rows = mysqli_num_rows($result);
    if ($rows > 0) {
        $row = mysqli_fetch_assoc($result);
        $category_old=$row["category"];
        $description_old=$row["description"];
        $amount_old=$row["amount"];
    }
}
else {
    echo'
    <script>
    alert("An Error Occurred");
    </script>';
    header('Location: budget_management.php');
}
$query = mysqli_prepare($conn, "SELECT DISTINCT category FROM category_list;");
mysqli_stmt_execute($query);
$result = mysqli_stmt_get_result($query);
$rows = mysqli_num_rows($result);
$categories = array();
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
    header('Location: budget_management.php');
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
        <h2 style='margin-right: auto;'>Update Category</h2>
    </div>
    <hr>
    <form method="post" onsubmit='validateNewBudgetOrExpenseForm(document.getElementById("amount"))' class='standard_form'>
        <label for="category">Category</label><br>
        <select id="category" name="category">
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category; ?>" <?php if ($category_old == $category) echo "selected"; ?> ><?php echo $category; ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="amount">Amount</label><br>
        <textarea id="amount" name="amount" oninput="formatNumber(this)"><?php echo $amount_old; ?></textarea><br><br> 

        <label for="description">Description</label><br>
        <textarea id="description" name="description"><?php echo $description_old; ?></textarea><br><br>
        
        <div class='save_and_cancel'>
            <button type="submit" class="standard_button save_button"><i class="fa-solid fa-upload"></i>Save</button>
            <button type="button" onclick="window.location.href = 'budget_management.php'" class='standard_button cancel_button'><i class="fa-solid fa-xmark"></i>Cancel</button>
        </div>
    </form>
</div>
</div>
</body>
</html>

<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $category = $_POST["category"];
        $description = $_POST["description"];
        $amount = $_POST["amount"];
        $query = mysqli_prepare($conn, "UPDATE budget_management SET category = ?, description = ? , amount = ? WHERE id = ?;");
        mysqli_stmt_bind_param($query, "sssi", $category, $description, $amount, $id);
        mysqli_stmt_execute($query);
        echo'
        <script>
        alert("Budget Updated Successfully");
        </script>';
        header('Location: budget_management.php');
        mysqli_close($conn);
    }
?>

