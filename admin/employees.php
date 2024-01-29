<?php 

    require "../classes/Database.php";
    require "../classes/Employee.php";

    $connection = Database::databaseConnection();

    $employees = Employee::getAllEmployees($connection, "employee_id, name, surname");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employees</title>
</head>
<body>
    <h1>Employees</h1>
    <a href="../index.php">Main Page</a>

    <?php if(empty($employees)): ?>
        <p>There are no employees</p>
    <?php else: ?>
        <div class="all-employees">
            <?php foreach($employees as $one_employee): ?>
                <h2><?= htmlspecialchars($one_employee["name"])." ".htmlspecialchars($one_employee["surname"])?></h2>
                <a href="one-employee.php?id=<?= $one_employee["employee_id"] ?>">More information</a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</body>
</html>