<?php
    require('config.php'); 
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $query = mysqli_prepare($conn, "DELETE FROM category_list WHERE id=?");
        mysqli_stmt_bind_param($query, "s", $id);
        mysqli_stmt_execute($query);
        mysqli_close($conn);
        exit;
    }
?>