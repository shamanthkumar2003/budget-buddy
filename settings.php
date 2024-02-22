<?php
session_start();
require('config.php');
$username_old = $_SESSION['username'];
$query = mysqli_prepare($conn, "SELECT firstname,lastname FROM login_info WHERE username = ? ");
mysqli_stmt_bind_param($query, "s", $username_old);
mysqli_stmt_execute($query);
$result = mysqli_stmt_get_result($query);
$row = mysqli_fetch_assoc($result);
$firstname_old=$row["firstname"];
$lastname_old=$row["lastname"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budget Buddy</title>
</head>
<body>
<?php include 'navbar.php'?>
<div class='main'>
<div class='sub_main_rounded'>
    <div style='display:flex; '>
        <h2 style='margin-right: auto;'>User Settings</h2>
        <button type="button" onclick="logout()" class='standard_button logout_button' style='margin-left:auto'><i class="fa-solid fa-right-from-bracket"></i>Logout</button>
    </div>
    <hr>
    <form method='post' class='standard_form'>
        <h4>First Name</h4>
        <input type='text' id='firstname' name='firstname' value=<?php echo $firstname_old ?>>
        <h4>Last Name</h4>
        <input type='text' id='lastname' name='lastname' value=<?php echo $lastname_old ?>>
        <h4>Username</h4>
        <input type='text' id='username' name='username' value=<?php echo $username_old ?>>
        <h4>Password</h4>
        <input type='password' id='password' name='password' placeholder='Leave this blank if you dont want to change password'>
        <div class='save_and_cancel' style='margin-top:20px'>
            <button type="submit" class="standard_button save_button"><i class="fa-solid fa-upload"></i>Save</button>
            <button type="reset" class="standard_button print_button"><i class="fa-solid fa-upload"></i>Reset</button>
        </div>
    </form>
</div>
</div>
</body>
</html>

<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        if(!isset($password)){
            $query = mysqli_prepare($conn, "UPDATE login_info SET firstname = ?, lastname = ? , username = ?, password = ? ");
            mysqli_stmt_bind_param($query, "ssss", $firstname, $lastname, $username, $password);
            mysqli_stmt_execute($query);
            echo'
            <script>
            alert("User-Info Updated Successfully");
            window.location.href = "settings.php";
            </script>';
        } else{
            $query = mysqli_prepare($conn, "UPDATE login_info SET firstname = ?, lastname = ? , username = ? ");
            mysqli_stmt_bind_param($query, "sss", $firstname, $lastname, $username);
            mysqli_stmt_execute($query);
            echo'
            <script>
            alert("User-Info Updated Successfully");
            window.location.href = "settings.php";
            </script>';
        }
        mysqli_close($conn);
    }
?>