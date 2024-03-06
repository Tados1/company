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
    Url::redirectUrl("/company/manager/work-schedule.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/work-plan.css">
    <script src="https://kit.fontawesome.com/bd1040f7a7.js" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
    <?php require "../assets/manager-header.php"; ?>

    <main class="work-plan">

        <form method="post">
            <div class="work-questions">
                <div class="type-of-work">
                    <p>Type of work:</p>

                    <div class="radio-label">
                        <input type="radio" id="production" name="work-type" value="production" required>
                        <label for="production">Production</label>
                    </div>

                    <div class="radio-label">
                        <input type="radio" id="setting-up" name="work-type" value="setting-up" required>
                        <label for="setting-up">Setting up</label>
                    </div>

                    <div class="radio-label">
                        <input type="radio" id="programming" name="work-type" value="programming" required>
                        <label for="programming">Programming</label>
                    </div>
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
                        <p>Select machines:</p>   
                        <div class="machines">
                            <?php foreach($machines as $one_machine): ?>
                                <div class="one-machine">
                                    <label class="switch">
                                        <input type="checkbox" 
                                            id="<?= htmlspecialchars($one_machine["machine_id"]) ?>" 
                                            name="selectedMachines[]" 
                                            value="<?= htmlspecialchars($one_machine["machine_name"]) ?>"
                                        >
                                        <span class="slider">
                                            <svg class="slider-icon" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="presentation"><path fill="none" d="m4 16.5 8 8 16-16"></path></svg> 
                                        </span>
                                        <p><?= htmlspecialchars($one_machine["machine_name"]) ?></p>
                                    </label>
                                    
                                </div>
                            <?php endforeach; ?>
                        </div>   
                    <?php endif; ?>
                </div>
            </div>
               
            <button><i class="fa-solid fa-paper-plane"></i></button>
        </form>
    </main>

   
</body>
</html>