<?php 

require "../classes/Database.php";
require "../classes/Machine.php";

$connection = Database::databaseConnection();

$machines = Machine::getAllMachines($connection, "machine_id, machine_name, machine_type, machine_status, machine_image");

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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.checkbox').change(function() {
                if ($(window).width() < 400) {
                    if ($(this).is(':checked')) {
                        $('.button-new-machine').css('display', 'block');
                    } else {
                        $('.button-new-machine').css('display', 'none');
                    }
                }
            });
        });
    </script>
    <title>Machines</title>
</head>
<body>
    <?php require "../assets/manager-header.php"; ?>

    <div class="background"></div>
    
    <h1>MACHINES</h1>
 
    <?php if(empty($machines)): ?>
        <p>There are no machines</p>
        <a href="add-machine.php">ADD MACHINE</a>
    <?php else: ?>
        <div class="all-machines-content">

            <div class="buttons">
                <div class="button-new-machine">
                    <a href="add-machine.php">+</a>
                </div>

                <div class="filter">
                    <input checked="" class="checkbox" type="checkbox"> 
                    <div class="mainbox">
                        <div class="iconFilter">
                            <svg viewBox="0 0 512 512" height="1em" xmlns="http://www.w3.org/2000/svg" class="search_icon"><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"></path></svg>
                        </div>
                    <input class="search_input" placeholder="Search Machine" type="text">
                    </div>
                </div>
            </div>

            <div class="all-machines">
                <?php foreach($machines as $one_machine): ?>
                    <div class="one-machine">
                        <?php if ($one_machine["machine_image"]): ?>
                            <img src="../uploads/machines/<?= htmlspecialchars($one_machine["machine_image"])?>" >
                        <?php else: ?>
                            <img src="../uploads/default-photos/machine.jpg" >
                        <?php endif; ?>

                        <section class="first-info-row">
                            <h2><?= htmlspecialchars($one_machine["machine_name"]) ?></h2>
                            <section class="one-machine-buttons">
                                <a href="edit-machine.php?id=<?= $one_machine["machine_id"] ?>" class="edit-btn">
                                    <svg height="1em" viewBox="0 0 512 512">
                                        <path
                                        d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"
                                        ></path>
                                    </svg>
                                </a>

                                <a href="delete-machine.php?id=<?= $one_machine["machine_id"] ?>" class="delete-btn">
                                    <svg
                                        class="btn-top"
                                        viewBox="0 0 39 7"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <line y1="5" x2="39" y2="5" stroke="white" stroke-width="4"></line>
                                        <line
                                        x1="12"
                                        y1="1.5"
                                        x2="26.0357"
                                        y2="1.5"
                                        stroke="white"
                                        stroke-width="3"
                                        ></line>
                                    </svg>
                                    <svg
                                        class="btn-bottom"
                                        viewBox="0 0 33 39"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <mask id="path-1-inside-1_8_19" fill="white">
                                        <path
                                            d="M0 0H33V35C33 37.2091 31.2091 39 29 39H4C1.79086 39 0 37.2091 0 35V0Z"
                                        ></path>
                                        </mask>
                                        <path
                                        d="M0 0H33H0ZM37 35C37 39.4183 33.4183 43 29 43H4C-0.418278 43 -4 39.4183 -4 35H4H29H37ZM4 43C-0.418278 43 -4 39.4183 -4 35V0H4V35V43ZM37 0V35C37 39.4183 33.4183 43 29 43V35V0H37Z"
                                        fill="white"
                                        mask="url(#path-1-inside-1_8_19)"
                                        ></path>
                                        <path d="M12 6L12 29" stroke="white" stroke-width="4"></path>
                                        <path d="M21 6V29" stroke="white" stroke-width="4"></path>
                                    </svg>
                                </a>
                            </section>
                        </section>
                        
                        <section class="second-info-row">
                            <p><?= htmlspecialchars($one_machine["machine_type"]) ?> ,</p>
                            <p><?= htmlspecialchars($one_machine["machine_status"]) ?></p>
                        </section>
                        
                    </div>        
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <script src="../js/machine-filter.js"></script>
</body>
</html>


