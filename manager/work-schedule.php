<?php

require "../classes/Database.php";
require "../classes/Employee.php";
require "../classes/WorkPlan.php";
require "../classes/Auth.php";

session_start();

if (!Auth::isLoggedIn("manager") ) {
    die("Unauthorized access");
}

$connection = Database::databaseConnection();

// Automatic deletion of old work plans
WorkPlan::deleteWorkPlan($connection);

$employees = Employee::getAllEmployees($connection, "employee", "employee_id, name, surname, position, employee_image");

$filter_value = $_GET['radio'] ?? "all"; 

$filtered_employees = [];
foreach ($employees as $employee) {
    if ($filter_value === 'all' || $employee['position'] === $filter_value) {
        $filtered_employees[] = $employee;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/work-schedule.css">
    <title>Work Schedule</title>
</head>
<body>
    <?php require "../assets/manager-header.php"; ?>

    <?php require "../assets/blue-background.php"; ?>
    
    <main class="work-schedule">

        <h1>WORK SCHEDULE</h1>

        <?php if(empty($employees)): ?>
            <p>There are no employees</p>
        <?php else: ?>
            <div class="all-employees-content">
                <form class="radio-inputs">
                    <label class="radio">
                        <input type="radio" <?= $filter_value === 'all' ? 'checked' : '' ?> onclick="updateUrlParam('all')">
                        <span class="name">All Employees</span>
                    </label>
                    <label class="radio">
                        <input type="radio" <?= $filter_value === 'turner' ? 'checked' : '' ?> onclick="updateUrlParam('turner')">
                        <span class="name">Turners</span>
                    </label>
                        
                    <label class="radio">
                        <input type="radio" <?= $filter_value === 'miller' ? 'checked' : '' ?> onclick="updateUrlParam('miller')">
                        <span class="name">Millers</span>
                    </label>
                </form>
                                   
                <?php require "../assets/filter.php"; ?>

                <div class="all-employees">
                    <?php foreach($filtered_employees as $one_employee): ?>
                        <?php $id = $one_employee["employee_id"] ?>
                                    <?php if(WorkPlan::checkExistWorkPlan($connection, $id)): ?>
                                        <div class="one-employee active">
                                    <?php else: ?>
                                        <div class="one-employee non-active">
                                    <?php endif; ?>
                                            <a href="work-plan.php?id=<?= $one_employee["employee_id"] ?>&position=<?= $one_employee["position"] ?>"><img src="../uploads/employee/<?= htmlspecialchars($one_employee["employee_image"])?>" ></a>
                                            <h2><?= htmlspecialchars($one_employee["name"])." ".htmlspecialchars($one_employee["surname"])?></h2>
                                            <p><?= htmlspecialchars($one_employee["position"])?></p>
                                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <script src="../js/employee-filter.js"></script>

        <script>
            function updateUrlParam(value) {
                var url = new URL(window.location.href);
                url.searchParams.set('radio', value);
                window.history.replaceState({}, '', url);
                location.reload(); 
            }
        </script>
    </main>

</body>
</html>