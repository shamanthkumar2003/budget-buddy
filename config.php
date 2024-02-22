<?php
  $host = 'localhost';
  $username = 'root';
  $password = '';
  $database = 'baetdb';
  $conn = mysqli_connect($host,$username,$password,$database);
  if (!$conn) {
    $error_code = mysqli_connect_errno();
    $error_message = mysqli_connect_error();
    echo "<script>alert('Failed to connect to MySQL | Error Code: $error_code | Error Message: $error_message')</script>";
    }
?>