<?php session_start();
require('config.php');
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $query = mysqli_prepare($conn, "SELECT * FROM category_list WHERE id = ? ");
    mysqli_stmt_bind_param($query, "s", $id);
    mysqli_stmt_execute($query);
    $result = mysqli_stmt_get_result($query);
    $rows = mysqli_num_rows($result);
    if ($rows > 0) {
        $row = mysqli_fetch_assoc($result);
        $category_old=$row["category"];
        $description_old=$row["description"];
        $status_old=$row["status"];
    }
}
else {
    echo'
    <script>
    alert("An Error Occurred");
    </script>';
    header('Location: category_list.php');
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
    <form method="post" class='standard_form'>
        <label for="category">Category</label><br>
        <textarea id="category" name="category"><?php echo $category_old; ?></textarea><br><br>

        <label for="description">Description</label><br>
        <textarea id="description" name="description"><?php echo $description_old; ?></textarea><br><br>

        <label for="status">Status</label><br>
        <select id="status" name="status">
            <option value="1" <?php if ($status_old == "1") echo "selected"; ?>>Active</option>
            <option value="0" <?php if ($status_old == "0") echo "selected"; ?>>Inactive</option>
        </select><br><br>

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
        $status = $_POST["status"];
        $query = mysqli_prepare($conn, "UPDATE category_list SET category = ?, description = ? , status = ? WHERE id = ?;");
        mysqli_stmt_bind_param($query, "sssi", $category, $description, $status, $id);
        mysqli_stmt_execute($query);
        echo'
        <script>
        alert("Category Updated Successfully");
        </script>';
        header('Location: category_list.php');
        mysqli_close($conn);
    }
?>