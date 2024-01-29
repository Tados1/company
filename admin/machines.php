<?php 

    require "../classes/Database.php";
    require "../classes/Machine.php";

    $connection = Database::databaseConnection();

    $machines = Machine::getAllMachines($connection, "machine_id, machine_name, machine_type");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Machines</title>
</head>
<body>
    <h1>Machines</h1>
        <a href="../index.php">Main Page</a>

        <?php if(empty($machines)): ?>
            <p>There are no machines</p>
        <?php else: ?>
            <div class="all-machines">
                <?php foreach($machines as $one_machine): ?>
                    <h2><?= htmlspecialchars($one_machine["machine_name"]) ?></h2>
                    <p><?= htmlspecialchars($one_machine["machine_type"]) ?></p>
                    <a href="one-employee.php?id=<?= $one_machine["machine_id"] ?>">More information</a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    <a href="../index.php">Main Page</a>
</body>
</html>