<?php 

$id = $_GET["id"];
$position = $_GET["position"];
$note = null;

require "../classes/Database.php";
require "../classes/Machine.php";
require "../classes/Auth.php";
require "../classes/Url.php";

session_start();

if (!Auth::isLoggedIn("manager") ) {
    die("Unauthorized access");
}

$connection = Database::databaseConnection();

$machines = Machine::getExactTypeMachines($connection, $position, "machine_id, machine_name");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    setcookie("employee_$id", serialize($_POST), time() + (24 * 3600), "/");
    Url::redirectUrl("/manager/work-schedule.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/work-plan.css">
    <script src="https://kit.fontawesome.com/bd1040f7a7.js" crossorigin="anonymous"></script>
    <title>Work Plan</title>
</head>
<body>
    <?php require "../assets/manager-header.php"; ?>

    <?php require "../assets/blue-background.php"; ?>

    <main class="work-plan">
        <form method="post">

            <div class="type-of-work">
                <label for="work-type">Type of work:</label>
                <select name="work-type" id="work-type">
                    <option value="production">Production</option>
                    <option value="setting-up">Setting-up</option>
                    <option value="programming">Programming</option>
                </select>
            </div>
                    
            <div class="message-about-work">
                <textarea name="note"
                    placeholder="Leave a note, e.g. technical drawing number..."
                    ><?= htmlspecialchars($note) 
                ?></textarea>
            </div>

            <div class="machines-for-work">
                <?php if(empty($machines)): ?>
                    <p>There are no machines</p>
                <?php else: ?>             
                    <fieldset>
                        <legend>Choose machines:</legend>  
                        <?php foreach($machines as $one_machine): ?>
                            <div class="one-machine">
                                <input type="checkbox" 
                                    id="<?= htmlspecialchars($one_machine["machine_id"]) ?>" 
                                    name="selectedMachines[]" 
                                    value="<?= htmlspecialchars($one_machine["machine_name"]) ?>"
                                >
                                <label for="<?= htmlspecialchars($one_machine["machine_id"]) ?>">
                                    <?= htmlspecialchars($one_machine["machine_name"]) ?>
                                </label>
                            </div>  
                        <?php endforeach; ?>
                    </fieldset>
                <?php endif; ?>
            </div>
               
            <button><i class="fa-solid fa-paper-plane"></i></button>
        </form>
    </main>
   
</body>
</html>