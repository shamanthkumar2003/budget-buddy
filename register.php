<?php
require('config.php');
if (isset($_POST['firstname'])) {
    if ($_POST['password'] == $_POST['confirm_password']) {
        $firstname = stripslashes($_POST['firstname']);
        $firstname = mysqli_real_escape_string($conn, $firstname);
        $lastname = stripslashes($_POST['lastname']);
        $lastname = mysqli_real_escape_string($conn, $lastname);
        $email = stripslashes($_POST['email']);
        $email = mysqli_real_escape_string($conn, $email);
        $password = stripslashes($_POST['password']);
        $password = mysqli_real_escape_string($conn, $password);

        // Hash the password
        $hashed_password = md5($password);

        // Set username as email
        $username = $email;

        $query = "INSERT INTO `login_info` (username, firstname, lastname, password, email) VALUES ('$username', '$firstname', '$lastname', '$hashed_password', '$email')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            header("Location: index.php");
            exit();
        } else {
            echo "Registration failed. Please try again.";
        }
    } else {
        echo "ERROR: Please Check Your Password & Confirmation password";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Register</title>
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
  <style media="screen">
    *,
    *:before,
    *:after {
      padding: 0;
      margin: 0;
      box-sizing: border-box;
    }

    body {
      background-color: #080710;
      color: #ffffff;
      font-family: 'Poppins', sans-serif;
    }

    .background {
      width: 430px;
      height: 520px;
      position: absolute;
      transform: translate(-50%, -50%);
      left: 50%;
      top: 50%;
    }

    .background .shape {
      height: 200px;
      width: 200px;
      position: absolute;
      border-radius: 50%;
    }

    .shape:first-child {
      background: linear-gradient(
        #1845ad,
        #23a2f6
      );
      left: -80px;
      top: -193px;
    }

    .shape:last-child {
      background: linear-gradient(
        to right,
        #ff512f,
        #f09819
      );
      right: -80px;
      bottom: -190px;
    }

    form {
      height: 780px;
      width: 400px;
      background-color: rgba(255, 255, 255, 0.13);
      position: absolute;
      transform: translate(-50%, -50%);
      top: 50%;
      left: 50%;
      border-radius: 10px;
      backdrop-filter: blur(10px);
      border: 2px solid rgba(255, 255, 255, 0.1);
      box-shadow: 0 0 40px rgba(8, 7, 16, 0.6);
      padding: 50px 35px;
    }

    form * {
      font-family: 'Poppins', sans-serif;
      color: #ffffff;
      letter-spacing: 0.5px;
      outline: none;
      border: none;
    }

    form h3 {
      font-size: 32px;
      font-weight: 500;
      line-height: 42px;
      text-align: center;
    }

    label {
      display: block;
      margin-top: 30px;
      font-size: 16px;
      font-weight: 500;
    }

    input {
      display: block;
      height: 50px;
      width: 100%;
      background-color: rgba(255, 255, 255, 0.07);
      border-radius: 3px;
      padding: 0 10px;
      margin-top: 8px;
      font-size: 14px;
      font-weight: 300;
    }

    ::placeholder {
      color: #e5e5e5;
    }

    button {
      margin-top: 50px;
      width: 100%;
      background-color: #ffffff;
      color: #080710;
      padding: 15px 0;
      font-size: 18px;
      font-weight: 600;
      border-radius: 5px;
      cursor: pointer;
    }

    .social {
      margin-top: 30px;
      display: flex;
      justify-content: center;
    }

    .social div {
      background: red;
      width: 150px;
      border-radius: 3px;
      padding: 5px 10px 10px 5px;
      background-color: rgba(255, 255, 255, 0.27);
      color: #eaf0fb;
      text-align: center;
    }

    .social div:hover {
      background-color: rgba(255, 255, 255, 0.47);
    }

    .social .fb {
      margin-left: 25px;
    }

    .social i {
      margin-right: 4px;
    }
  </style>
</head>
<body>
  <div class="background">
    <div class="shape"></div>
    <div class="shape"></div>
  </div>
  <form action="" method="POST" autocomplete="off">
    <h3>Register</h3>

    <label for="firstname">First Name</label>
    <input type="text" placeholder="First Name" name="firstname" required>

    <label for="lastname">Last Name</label>
    <input type="text" placeholder="Last Name" name="lastname" required>

    <label for="email">Email</label>
    <input type="email" placeholder="Email" name="email" required>

    <label for="password">Password</label>
    <input type="password" placeholder="Password" name="password" required>

    <label for="confirm_password">Confirm Password</label>
    <input type="password" placeholder="Confirm Password" name="confirm_password" required>

    <button type="submit">Register</button>
  </form>
</body>
</html>
