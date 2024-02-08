<?php 

require "../classes/Database.php";
require "../classes/Machine.php";

$connection = Database::databaseConnection();

$machines = Machine::getAllMachines($connection, "machine_id, machine_name, machine_type, machine_status");

require "../classes/Auth.php";

session_start();

if (!Auth::isLoggedIn("manager") ) {
    die("Unauthorized access");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/machines.css">
    <title>Machines</title>
</head>
<body>
    <?php require "../assets/manager-header.php"; ?>
    
    <section class="machines">
        <div class="heading-machine">
            <h1>MACHINES</h1>
        </div>
 
        <?php if(empty($machines)): ?>
            <p>There are no machines</p>
            <a href="add-machine.php">ADD MACHINE</a>
        <?php else: ?>
            
            <div class="all-machines-content">
                <div class="button-add-machine">
                    <a href="add-machine.php">ADD MACHINE</a>
                </div> 

                <div class="filter">
                    <input type="text" class="filter-input" placeholder="Find Machine">
                </div>

                <div class="all-machines">
                    <?php foreach($machines as $one_machine): ?>
                        <div class="one-machine">
                            <img src="../img/lathe.jpg" alt="">
                            <h2><?= htmlspecialchars($one_machine["machine_name"]) ?></h2>
                            <p><?= htmlspecialchars($one_machine["machine_type"]) ?></p>
                            <p><?= htmlspecialchars($one_machine["machine_status"]) ?></p>
                            <a href="edit-machine.php?id=<?= $one_machine["machine_id"] ?>">EDIT</a>
                            <a href="delete-machine.php?id=<?= $one_machine["machine_id"] ?>">DELETE</a>
                        </div>        
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </section>

    <script src="../js/filter.js"></script>
</body>
</html>