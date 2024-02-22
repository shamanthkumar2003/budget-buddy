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
        <h2 style='margin-right: auto;'>Create New Category</h2>
    </div>
    <hr>
    <form method="post" onsubmit="return validateNewCategoryForm()" class='standard_form'>
        <label for="category">Category</label><br>
        <textarea id="category" name="category"></textarea><br><br>

        <label for="description">Description</label><br>
        <textarea id="description" name="description"></textarea><br><br>

        <label for="status">Status</label><br>
        <select id="status" name="status">
            <option value="1">Active</option>
            <option value="0">Inactive</option>
        </select><br><br>
        <div class='save_and_cancel'>
            <button type="submit" class="standard_button save_button"><i class="fa-solid fa-upload"></i>Save</button>
            <button type="button" onclick="window.location.href = 'category_list.php'" class='standard_button cancel_button'><i class="fa-solid fa-xmark"></i>Cancel</button>
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
        $datecreated = date("Y-m-d");
        $query = mysqli_prepare($conn, "INSERT INTO category_list (category, description, status, datecreated) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($query, "ssss", $category, $description, $status, $datecreated);
        mysqli_stmt_execute($query);
        $rowsAffected = mysqli_stmt_affected_rows($query);
        if ($rowsAffected > 0) {
            echo'
            <script>
            alert("New Category Created Successfully");
            </script>';
            header('Location: category_list.php');
        } 
        else {
            echo'
            <script>
            alert("An Error Occurred. No New Category Created");
            </script>';
        }
        mysqli_close($conn);
    }
?>