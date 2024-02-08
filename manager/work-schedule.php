<?php

require "../classes/Database.php";
require "../classes/Manager.php";
require "../classes/Auth.php";

session_start();

if (!Auth::isLoggedIn("manager") ) {
    die("Unauthorized access");
}

$connection = Database::databaseConnection();

$employees = Manager::getAllEmployees($connection, "employee_id, name, surname, position");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/work-schedule.css">
    <title>Document</title>
</head>
<body>
    <?php require "../assets/manager-header.php"; ?>

    <div class="background-work-schedule">

    </div>
    
    <main class="work-schedule">
        <div class="heading-work-schedule">
            <h1>Work Schedule</h1>
        </div>

        <?php if(empty($employees)): ?>
            <p>There are no employees</p>
        <?php else: ?>
            <div class="all-employees">
                <?php foreach($employees as $one_employee): ?>
                    <div class="one-employee">
                        <a href="work-plan.php?id=<?= $one_employee["employee_id"] ?>&position=<?= $one_employee["position"] ?>"><img src="../img/employee.jpg" alt=""></a>
                        <h2><?= htmlspecialchars($one_employee["name"])." ".htmlspecialchars($one_employee["surname"])?></h2>
                        <p><?= htmlspecialchars($one_employee["position"])?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
    
</body>
</html>