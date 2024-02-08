<?php 

    $error_text = $_GET["error_text"];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Error Page</title>
</head>
<body>

    <main>
        <section class="error">
            <p><?= $error_text ?></p>
        </section>

        <section class="link">
            <a href="../manager/employees.php">Back to main page of administration</a>
        </section>
    </main>

</body>
</html>