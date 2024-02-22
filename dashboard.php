<?php
session_start(); 
require('config.php');
require('queries.php');
$query_budget = mysqli_prepare($conn, $sql_budget);
mysqli_stmt_execute($query_budget);
$result_budget = mysqli_stmt_get_result($query_budget);

$query_expense = mysqli_prepare($conn, $sql_expense);
mysqli_stmt_execute($query_expense);
$result_expense = mysqli_stmt_get_result($query_expense);

$query_remaining = mysqli_prepare($conn, $sql_remaining_budget);
mysqli_stmt_execute($query_remaining);
$result_remaining = mysqli_stmt_get_result($query_remaining);

$budget_current=0;$expense_current=0;

$query_current_budget = mysqli_prepare($conn, "SELECT SUM(amount) FROM budget_management");
mysqli_stmt_execute($query_current_budget);
mysqli_stmt_store_result($query_current_budget);
mysqli_stmt_bind_result($query_current_budget,$budget_current);
mysqli_stmt_fetch($query_current_budget);

$query_current_expense = mysqli_prepare($conn, "SELECT SUM(amount) FROM expense_management");
mysqli_stmt_execute($query_current_expense);
mysqli_stmt_store_result($query_current_expense);
mysqli_stmt_bind_result($query_current_expense,$expense_current);
mysqli_stmt_fetch($query_current_expense);

$remaining_current=$budget_current-$expense_current;
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
    <h1 class='dashboard_title'>Budget Buddy - Budget and Expense Tracker System</h1>
    <hr>
    <div class="card_collection_main">
        <div class="card_with_img">
            <img class = card_img src="images/image1.jpg" alt="...">
            <div class="card_with_img_container">
                <h4>Current Overall Budget</h4>
                <p><b><?php echo $budget_current ?></b></p>
            </div>
        </div>
        <div class="card_with_img">
            <img class = card_img src="images/image2.jpg" alt="...">
            <div class="card_with_img_container">
                <h4>Current Overall Expense</h4>
                <p><b><?php echo $expense_current ?></b></p>
            </div>
        </div>
        <div class="card_with_img">
            <img class = card_img src="images/image3.jpg" alt="...">
            <div class="card_with_img_container">
                <h4>Current Remaining Budget</h4>
                <p><b><?php echo $remaining_current ?></b></p>
            </div>
        </div>
    </div>
    <hr>
    <h3>Current Budget in each Category</h3>
    <div class="card_collection_others">
    <?php 
    if (mysqli_num_rows($result_budget) > 0) {
    while ($row = mysqli_fetch_assoc($result_budget)) {
    echo'
        <div class="card_no_img">
            <i class="fa-solid fa-circle-info"><span class ="tooltip"><pre>'.$row['categoryDescription'].'</pre></span></i>
            <div class="card_no_img_container">
                <h4>'.$row['category'].'</h4>
                <p><b>'.$row['totalAmountBudget'].'</b></p>
            </div>
        </div> 
    '; } } ?>
    </div>
    <hr>
    <h3>Current Expense in each Category</h3>
    <div class='card_collection_others'>
    <?php 
    if (mysqli_num_rows($result_expense) > 0) {
    while ($row = mysqli_fetch_assoc($result_expense)) {
    echo'
        <div class="card_no_img">
            <i class="fa-solid fa-circle-info"><span class ="tooltip"><pre>'.$row['categoryDescription'].'</pre></span></i>
            <div class="card_no_img_container">
                <h4>'.$row['category'].'</h4>
                <p><b>'.$row['totalAmountExpense'].'</b></p>
            </div>
        </div> 
    '; } } ?>
    </div>
    <hr>
    <h3>Remaining Budget in each Category</h3>
    <div class='card_collection_others'>
    <?php 
    if (mysqli_num_rows($result_remaining) > 0) {
    while ($row = mysqli_fetch_assoc($result_remaining)) {
    echo'
        <div class="card_no_img">
            <i></i>
            <div class="card_no_img_container">
                <h4>'.$row['category'].'</h4>
                <p><b>'.$row['remainingBudget'].'</b></p>
            </div>
        </div> 
    '; } } ?>
    </div>
    <hr>
</div>
</body>
</html>