<?php 

$id = $_GET["id"];
$position = $_GET["position"];
$note = null;

require "../classes/Database.php";
require "../classes/Machine.php";
require "../classes/Auth.php";

session_start();

if (!Auth::isLoggedIn("employee") ) {
die("Unauthorized access");
}

$connection = Database::databaseConnection();


$machines = Machine::getExactTypeMachines($connection, $position, "machine_id, machine_name");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectedWorkType = $_POST["work-type"];
    $note = $_POST["note"];
    $selectedMachines = isset($_POST["selectedMachines"]) ? $_POST["selectedMachines"] : [];

    if (!empty($selectedMachines)) {
        echo "Selected machines: " . implode(", ", $selectedMachines);
    } else {
        echo "No machines selected";
    }

    echo "<br>";
    echo $selectedWorkType;
    echo "<br>";
    echo $note;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/home-page.css">
    <title>Home Page</title>
</head>
<body>
    <div class="home-page">
        <?php require "../assets/employee-header.php"; ?>

        <div class="heading-home-page">
            <h1>HOME PAGE</h1>  
        </div>   
    </div>
</body>
</html>