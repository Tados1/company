<?php 

require "../classes/Database.php";
require "../classes/Employee.php";
require "../classes/Auth.php";

session_start();

if (!Auth::isLoggedIn("manager") ) {
    die("Unauthorized access");
}

$connection = Database::databaseConnection();

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
    <?php require "../assets/manager-header.php"; ?>

    <?php require "../assets/blue-background.php"; ?>
    
    <h1>Employees</h1>
    
    <?php if(empty($employees)): ?>
        <div class="empty-page">
            <p>There are no employees</p>
            <a href="add-employee.php">ADD EMPLOYEE</a>
        </div>
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


            <div class="buttons">
                <div class="button-new-employee">
                    <a href="add-employee.php">+</a>
                </div>

                <?php require "../assets/filter.php"; ?>
            </div>
            
            <div class="all-employees">
                <?php foreach($filtered_employees as $one_employee): ?>
                    <div class="one-employee">
                        <img src="../uploads/employee/<?= htmlspecialchars($one_employee["employee_image"])?>" >
                        <h2><?= htmlspecialchars($one_employee["name"])." ".htmlspecialchars($one_employee["surname"])?></h2>
                        <a href="one-employee.php?id=<?= $one_employee["employee_id"] ?>"><i class="fa-solid fa-circle-info"></i></a>
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
</body>
</html>