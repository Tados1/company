<?php

    require "../classes/Database.php";
    require "../classes/Employee.php";

    $connection = Database::databaseConnection();

    if ( isset($_GET["id"]) and is_numeric($_GET["id"])) { 
        $employees = Employee::getEmployee($connection, $_GET["id"]);
    } else {
        $employees = null;
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>One Employee</title>
</head>
<body>

    <main>
        <section class="one-employee">
            <?php if($employees === null): ?>
                <p>There is no employee</p>
            <?php else: ?>
                <div class="one-employee-box">
                    <h2><?= htmlspecialchars($employees['name']) . " ".htmlspecialchars($employees['surname'])?></h2>
                    <p>Position: <?= htmlspecialchars($employees['position'])?></p>
                    <a href="employees.php">Back to all Employees</a>
                </div>
            <?php endif ?>
        </section>
    </main>

</body>
</html>