<?php

require "../classes/Database.php";
require "../classes/Manager.php";
require "../classes/Auth.php";

session_start();

if (!Auth::isLoggedIn("manager") ) {
    die("Unauthorized access");
}

$connection = Database::databaseConnection();

$employees = Manager::getAllEmployees($connection, "employee_id, name, surname, position, role, image_name");

// if($id = $_GET["id"]) {
//     setcookie("employee_$id", true, time() + (24 * 3600), "/");
// }

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

    <div class="background-work-schedule"></div>
    
    <main class="work-schedule">
        <div class="heading-work-schedule">
            <h1>Work Schedule</h1>
        </div>

        <?php if(empty($employees)): ?>
            <p>There are no employees</p>
        <?php else: ?>
            <div class="all-employees-content">

            <form class="radio-inputs">
                <label class="radio">
                    <input type="radio" name="radio" value="all" checked="">
                    <span class="name">All Employees</span>
                </label>
                <label class="radio">
                    <input type="radio" name="radio" value="turner">
                    <span class="name">Turners</span>
                </label>
                    
                <label class="radio">
                    <input type="radio" name="radio" value="miller">
                    <span class="name">Millers</span>
                </label>
            </form>
            
                
            <div class="filter">
                <input checked="" class="checkbox" type="checkbox"> 
                <div class="mainbox">
                    <div class="iconFilter">
                        <svg viewBox="0 0 512 512" height="1em" xmlns="http://www.w3.org/2000/svg" class="search_icon"><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"></path></svg>
                    </div>
                <input class="search_input" placeholder="Search Employee" type="text">
                </div>
            </div>

                <div class="all-employees">
                    <?php foreach($employees as $one_employee): ?>
                        <?php $id = $one_employee["employee_id"] ?>
                        <?php if(isset($_COOKIE["employee_$id"])): ?>
                            <div class="one-employee active">
                        <?php else: ?>
                            <div class="one-employee non-active">
                        <?php endif; ?>
            
                        <?php if ($one_employee["image_name"]): ?>
                            <a href="work-plan.php?id=<?= $one_employee["employee_id"] ?>&position=<?= $one_employee["position"] ?>"><img src="../uploads/employees/<?= htmlspecialchars($one_employee["image_name"])?>" ></a>
                        <?php else: ?>
                            <a href="work-plan.php?id=<?= $one_employee["employee_id"] ?>&position=<?= $one_employee["position"] ?>"><img src="../uploads/default-photos/employee.jpg" ></a>
                        <?php endif; ?>

                            <h2><?= htmlspecialchars($one_employee["name"])." ".htmlspecialchars($one_employee["surname"])?></h2>
                            <p><?= htmlspecialchars($one_employee["position"])?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
               
            </div>
        <?php endif; ?>

        <script src="../js/employee-filter.js"></script>
    </main>

</body>
</html>