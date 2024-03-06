<?php

require "../classes/Database.php";
require "../classes/Manager.php";
require "../classes/Auth.php";

session_start();

if (!Auth::isLoggedIn("director") ) {
    die("Unauthorized access");
}

$connection = Database::databaseConnection();

if ( isset($_GET["id"]) and is_numeric($_GET["id"])) { 
    $employees = Manager::getEmployee($connection, $_GET["id"]);
} else {
    $employees = null;
}
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/one-employee.css">
    <title>One Employee</title>
</head>
<body>
    <?php require "../assets/director-header.php"; ?>

    <main>
        <div class="background"></div>

        <section class="one-employee">
            <?php if($employees === null): ?>
                <p>There is no employee</p>
            <?php else: ?>
                <div class="one-employee-box">

                    <div class="employee-photo">
                        <?php if($employees["image_name"]): ?>
                            <img src=<?= "../uploads/employees/" . $employees["image_name"] ?> alt="">
                        <?php else: ?>
                            <img src="../uploads/default-photos/employee.jpg" >
                        <?php endif; ?>
                    </div>    

                    <div class="about-one-employee">
                        <div class="employee-name">
                            <h2><?= htmlspecialchars($employees['name']) . " ".htmlspecialchars($employees['surname'])?></h2>
                        </div>

                        <p>Position: <?= htmlspecialchars($employees['position'])?></p>
                        <p>Role: <?= htmlspecialchars($employees['role'])?></p>
                        <p>Login Name: <?= htmlspecialchars($employees['login_name'])?></p>
                    
                        <div class="employee-buttons">
                            <a href="edit-employee.php?id=<?= $employees["employee_id"] ?>" class="edit">Edit</a>
                            <a href="delete-employee.php?id=<?= $employees["employee_id"] ?>" class="delete">Delete</a>
                        </div>
                    </div>
                </div>
            <?php endif ?>
        </section>
    </main>

</body>
</html>