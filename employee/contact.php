<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/PHPMailer/src/Exception.php';
require '../vendor/PHPMailer/src/PHPMailer.php';
require '../vendor/PHPMailer/src/SMTP.php';
require "../classes/Auth.php";

session_start();

if (!Auth::isLoggedIn("employee") ) {
    die("Unauthorized access");
}

$first_name = "";
$second_name = "";
$email = "";
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $first_name = $_POST["first_name"];
    $second_name = $_POST["second_name"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    $errors = [];

    if ($first_name === "") {
        $errors[] = "Prosim, vlozte do formularu vase meno";
    }

    if ($second_name === "") {
        $errors[] = "Prosim, vlozte do formularu vase priezvisko";
    }

    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $errors[] = "Prosim, vlozte do formularu vas email";
    }

    if ($message === "") {
        $errors[] = "Prosim, vlozte do formularu vasu spravu";
    }
    
    if (empty($errors)) {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;

            $mail->CharSet = "UTF-8";
            $mail->Encoding = "base64";
            
            $mail->Username = "tadeas.strba@gmail.com";
            //poskytnutie mojho hesla inej aplikacii cez myaccount.google.com/apppasswords
            $mail->Password = "wetkcpdgebctryxv";
            $mail->SMTPSecure = "ssl";
            $mail->Port = 465;
              
            $mail->setFrom("tadeas.strba@gmail.com");
            //dalsia adresa, kde pride email
            $mail->addAddress("tadeas.strba@gmail.com");
            $mail->Subject = "Vyplneny formular na strankach";
            $mail->Body = "Name: {$first_name} {$second_name}\nEmail: {$email}\nMessage: {$message}";        
        
            $mail->send();     

            echo "Sprava odoslana";

        } catch (Exception $e) {
            echo "The message was not sent: ", $mail->ErrorInfo;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/contact.css">
    <script src="https://kit.fontawesome.com/bd1040f7a7.js" crossorigin="anonymous"></script>
    <title>Contact</title>
</head>
<body>
    <?php require "../assets/employee-header.php"; ?>

    <main class="contact">
        <?php if (!empty($errors)): ?>
            <section class="errors">
                <ul>
                    <?php foreach($errors as $one_error): ?>
                        <li> <?= $one_error; ?> </li>
                    <?php endforeach; ?>
                </ul>
            </section>
        <?php endif; ?>

        <section class="form">
            <form action="contact.php" method="POST">

                <input type="text" 
                    name="first_name" 
                    placeholder="Name" 
                    value="<?= $first_name; ?>" 
                    required>

                <input type="text" 
                    name="second_name" 
                    placeholder="Surname" 
                    value="<?= $second_name; ?>" 
                    required>

                <input type="email" 
                    name="email" 
                    placeholder="Email" 
                    value="<?= $email; ?>" 
                    required>

                <textarea name="message" 
                    placeholder="Your message..." 
                    required><?= $message; ?></textarea>
                
                <button><i class="fa-solid fa-paper-plane"></i></button>
            </form>
        </section>
    </main>
</body>
</html>