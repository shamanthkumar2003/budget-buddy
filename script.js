function formatNumber(input) {
    var value = input.value.replace(/,/g, '').replace(/\D/g, '');
    var formattedValue = value.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    input.value = formattedValue;
}

function clearFormatNumber(input) {
    let clearNumber = input.value.trim().replace(/,/g, '');
    input.value = parseInt(clearNumber);
}

function validateNewBudgetOrExpenseForm(input) {
    clearFormatNumber(input);
    let amount = input.value.trim();
    if ( amount === "" ) {
        alert("Please Fill Out Amount Field");
        return false;
    }
    return true;
}

function handleBudgetListAction(select, id) {
    let selectedOption = select.options[select.selectedIndex].value;
    if (selectedOption === 'edit') {
        window.location.href = 'update_budget.php?id=' + encodeURIComponent(id);
    }
    if(selectedOption === 'delete') {
        if (confirm("Are You Sure You Want To Delete This Row?")) {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "delete_budget.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        alert("Row Deleted Successfully!");
                        window.location.href = 'budget_management.php';
                    } else {
                        alert("Error In Deleting Row!");
                    }
                }
            };
            xhr.send("id=" + id);
        }
    }
}

function handleExpenseListAction(select, id) {
    let selectedOption = select.options[select.selectedIndex].value;
    if (selectedOption === 'edit') {
        window.location.href = 'update_expense.php?id=' + encodeURIComponent(id);
    }
    if(selectedOption === 'delete') {
        if (confirm("Are You Sure You Want To Delete This Row?")) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "delete_expense.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        alert("Row Deleted Successfully!");
                        window.location.href = 'expense_management.php';
                    } else {
                        alert("Error In Deleting Row!");
                    }
                }
            };
            xhr.send("id=" + id);
        }
    }
}

function validateNewCategoryForm() {
    let category = document.getElementById("category").value.trim();
    if ( category === "" ) {
        alert("Please Fill Out Category Field");
        return false;
    }
    return true;
}

function disableActionOption(){
    let actionOptions = document.getElementsByClassName("actionOption");
    Array.from(actionOptions).forEach(function(actionOption) {
        actionOption.disabled = true;
    });
}

function searchCategory() {
    let input = document.querySelector('.search_box');
    let filter = input.value.toUpperCase();
    let rows = document.querySelectorAll('.standard_table tr');
    for (let i = 1; i < rows.length; i++) {
        let row = rows[i];
        let cells = row.getElementsByTagName('td');
        let shouldDisplay = false;
        for (let j = 0; j < cells.length; j++) {
            let cell = cells[j];
            let text = cell.textContent || cell.innerText;
            if (text.toUpperCase().indexOf(filter) > -1) {
                shouldDisplay = true;
                break;
            }
        }
        row.style.display = shouldDisplay ? '' : 'none';
    }
}

function printTable(elementId) {
    let printContent = document.getElementById(elementId).innerHTML;
    let newWindow = window.open('', '_blank', 'width=1000px,height=600px');
    newWindow.document.write('<html><head><title>'+ document.title  +'</title></head><body>');
    newWindow.document.write("<link rel='stylesheet' type='text/css' href='styles.css'>");
    newWindow.document.write(printContent);
    newWindow.document.write('</body></html>');
    newWindow.document.close();
    newWindow.print();
}

function logout() {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'logout.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            window.location.href = 'index.php';
        } else {
            alert("Logout Failed!")
        }
    };
    xhr.send();
}