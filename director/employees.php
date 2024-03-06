<?php 

require "../classes/Database.php";
require "../classes/Director.php";
require "../classes/Auth.php";

session_start();

if (!Auth::isLoggedIn("director") ) {
    die("Unauthorized access");
}

$connection = Database::databaseConnection();

$employees = Director::getAllEmployees($connection, "employee_id, name, surname, image_name");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/employees.css">
    <script src="https://kit.fontawesome.com/bd1040f7a7.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.checkbox').change(function() {
                if ($(window).width() < 400) {
                    if ($(this).is(':checked')) {
                        $('.button-new-employee').css('display', 'block');
                    } else {
                        $('.button-new-employee').css('display', 'none');
                    }
                }
            });
        });
    </script>
    <title>Employees</title>
</head>
<body>
    <?php require "../assets/director-header.php"; ?>

    <?php if(empty($employees)): ?>
        <p>There are no employees</p>
        <a href="add-employee.php">ADD EMPLOYEE</a>
    <?php else: ?>
        <div class="all-employees-content"> 

        <div class="buttons">
                <div class="button-new-employee">
                    <a href="add-employee.php">+</a>
                </div>

                <div class="filter">
                    <input checked="" class="checkbox" type="checkbox"> 
                    <div class="mainbox">
                        <div class="iconFilter">
                            <svg viewBox="0 0 512 512" height="1em" xmlns="http://www.w3.org/2000/svg" class="search_icon"><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"></path></svg>
                        </div>
                    <input class="search_input" placeholder="Search Employee" type="text">
                    </div>
                </div>
            </div>

            <div class="all-employees">
                <?php foreach($employees as $one_employee): ?>
                    <div class="one-employee">
                        <?php if ($one_employee["image_name"]): ?>
                            <img src="../uploads/employees/<?= htmlspecialchars($one_employee["image_name"])?>" >
                        <?php else: ?>
                            <img src="../uploads/default-photos/employee.jpg" >
                        <?php endif; ?>
                        <h2><?= htmlspecialchars($one_employee["name"])." ".htmlspecialchars($one_employee["surname"])?></h2>
                        <a href="one-employee.php?id=<?= $one_employee["employee_id"] ?>"><i class="fa-solid fa-circle-info"></i></a>
                    </div>            
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <script src="../js/employee-filter.js"></script>
</body>
</html>