<?php
$sql_budget = 
"SELECT 
c.category AS category, 
SUM(b.amount) AS totalAmountBudget, 
c.description AS categoryDescription 
FROM 
budget_management b 
JOIN 
category_list c ON b.category = c.category
GROUP BY b.category;";


$sql_expense =
"SELECT 
c.category AS category, 
SUM(b.amount) AS totalAmountExpense, 
c.description AS categoryDescription 
FROM 
expense_management b 
JOIN 
category_list c ON b.category = c.category 
GROUP BY b.category;";


$sql_remaining_budget = 
"SELECT 
budget.category AS category,
(budget.totalAmountBudget - expense.totalAmountExpense) AS remainingBudget
FROM (
SELECT 
    b.category, 
    SUM(b.amount) AS totalAmountBudget
FROM 
    budget_management b 
JOIN 
    category_list c ON b.category = c.category 
GROUP BY 
    b.category
) AS budget
JOIN (
SELECT 
    b.category, 
    SUM(b.amount) AS totalAmountExpense
FROM 
    expense_management b 
JOIN 
    category_list c ON b.category = c.category 
GROUP BY 
    b.category
) AS expense ON budget.category = expense.category;";
?>