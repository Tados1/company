<?php 

require "../classes/Database.php";
require "../classes/Machine.php";
require "../classes/Auth.php";
require "../classes/Manager.php";

session_start();

if (!Auth::isLoggedIn("employee") ) {
    die("Unauthorized access");
}

$formData = null;
$id = $_GET["id"];

$connection = Database::databaseConnection(); 
$employee = Manager::getEmployee($connection, $id, "name");

if (isset($_COOKIE["employee_$id"]) && !empty($_COOKIE["employee_$id"])) {
    $formData = unserialize($_COOKIE["employee_$id"]);
    $workExist = true;
} else {

}

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
    <div class="background"></div>

    <main>
        <?php if (!empty($formData)): ?>
            <div class="work-info">
                <h1>WORK SCHEDULE</h1>

                <div class="box box1">
                    <div class="icon">
                        <i class="fa-solid fa-gear"></i>
                    </div>
                    <div class="box-text">
                        <h2><?= strtoupper($formData["work-type"]) ?></h2>
                    </div>
                </div>
                
                <div class="box box2">
                    <div class="icon">
                        <img src="../img/machine1.png" alt="">
                    </div>

                    <?php if(!empty($formData["selectedMachines"])): ?>
                        <div class="box-text">
                            <?php foreach($formData["selectedMachines"] as $machine): ?>
                                <p> <?= $machine ?> </p>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
                    
                <div class="box box3">
                    <div class="icon">
                        <i class="fa-solid fa-quote-right"></i>
                    </div>
                    <div class="box-text">
                        <p><?= $formData["note"] ?></p>
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