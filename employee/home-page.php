<?php 

require "../classes/Database.php";
require "../classes/Machine.php";
require "../classes/WorkPlan.php";
require "../classes/Auth.php";
require "../classes/Employee.php";

session_start();

if (!Auth::isLoggedIn("employee") ) {
    die("Unauthorized access");
}

$formData = null;
$id = $_GET["id"];

$connection = Database::databaseConnection(); 
$employee = Employee::getEmployee($connection, $id, "name");
$work_plan = WorkPlan::getWorkPlan($connection, $id);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/employee-home-page.css">
    <script src="https://kit.fontawesome.com/bd1040f7a7.js" crossorigin="anonymous"></script>
    <title>Home Page</title>
</head>
<body>
    <?php require "../assets/employee-header.php"; ?>
    
    <?php require "../assets/blue-background.php"; ?>

    <main>
        <?php if (!empty($work_plan)): ?>
            <div class="work-info">
                <h1>WORK SCHEDULE</h1>

                <div class="box box1">
                    <div class="icon">
                        <i class="fa-solid fa-gear"></i>
                    </div>
                    <div class="box-text">
                        <p><?= strtoupper($work_plan[0]["work_type"]) ?></p>
                    </div>
                </div>
                
                <div class="box box2">
                    <div class="icon">
                        <img src="../img/machine1.png" alt="">
                    </div>

                    <div class="box-text">
                        <p> <?= $work_plan[0]["machines"] ?> </p>
                    </div>
                </div>
                    
                <div class="box box3">
                    <div class="icon">
                        <i class="fa-solid fa-quote-right"></i>
                    </div>
                    <div class="box-text">
                        <p><?= $work_plan[0]["note"] ?></p>
                    </div>
                </div>
            </div>

            <?php else: ?>
                <div class="no-work">
                    <h1 class="no-work-heading"><?= "Welcome," . " " . $employee["name"];?></h1>
                    <p>There is no work schedule for you yet.</p>
                </div>
        <?php endif; ?>
    </main>   
</body>
</html>