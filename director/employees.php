<?php 

require "../classes/Database.php";
require "../classes/Director.php";
require "../classes/Auth.php";

session_start();

if (!Auth::isLoggedIn("director") ) {
    die("Unauthorized access");
}

$connection = Database::databaseConnection();

$employees = Director::getAllEmployees($connection, "employee_id, name, surname");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/employees.css">
    <title>Employees</title>
</head>
<body>
    <?php require "../assets/director-header.php"; ?>
    
    <div class="heading-employees">
        <h1>EMPLOYEES</h1>
    </div>

    <?php if(empty($employees)): ?>
        <p>There are no employees</p>
        <a href="add-employee.php">ADD EMPLOYEE</a>
    <?php else: ?>
        <div class="all-employees-content"> 

            <div class="button-new-employee">
                <a href="add-employee.php">ADD EMPLOYEE</a>
            </div>  

            <div class="filter">
                <input type="text" class="filter-input" placeholder="Find Machine">
            </div>

            <div class="all-employees">
                <?php foreach($employees as $one_employee): ?>
                    <div class="one-employee">
                        <img src="../img/employee.jpg" alt="">
                        <h2><?= htmlspecialchars($one_employee["name"])." ".htmlspecialchars($one_employee["surname"])?></h2>
                        <a href="one-employee.php?id=<?= $one_employee["employee_id"] ?>">More information</a>
                    </div>            
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

</body>
</html>