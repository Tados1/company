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

$id = $_GET["id"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $first_name = $_POST["first_name"];
    $second_name = $_POST["second_name"];
    $email = $_POST["email"];
    $message = $_POST["message"];
  
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;

        $mail->CharSet = "UTF-8";
        $mail->Encoding = "base64";
        
        $mail->Username = "tadeas.strba@gmail.com";
        //password generation via myaccount.google.com/apppasswords
        $mail->Password = "wetkcpdgebctryxv";
        $mail->SMTPSecure = "ssl";
        $mail->Port = 465;
            
        $mail->setFrom("tadeas.strba@gmail.com");
        //another address where we can send the same message
        $mail->addAddress("fansnasvk@gmail.com");
        $mail->Subject = "Form sent from the company website by an employee with id $id";
        $mail->Body = "Name: {$first_name} {$second_name}\nEmail: {$email}\nMessage: {$message}";        
    
        $mail->send();     

    } catch (Exception $e) {
        echo "The message was not sent: ", $mail->ErrorInfo;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/contact.css">
    <title>Contact</title>
</head>
<body>
    <?php require "../assets/employee-header.php"; ?>

    <main class="contact">
    
        <section class="form">
            <form action="contact.php?id=<?= $id ?>" method="POST">

                <div class="inputbox">
                    <input type="text" name="first_name" 
                        required>
                        <span>Name</span>
                        <i></i>
                </div>

                <div class="inputbox">
                    <input type="text" 
                        name="second_name" 
                        required>
                        <span>Surname</span>
                        <i></i>
                </div>

                <div class="inputbox">
                    <input type="email" 
                        name="email" 
                        required>
                        <span>Email</span>
                        <i></i>
                </div>

                <div class="inputbox textarea">
                    <textarea name="message" 
                        required rows="4"></textarea>
                        <span>Your message...</span>
                        <i></i>
                </div>

                <button>
                    <div class="svg-wrapper-1">
                    <div class="svg-wrapper">
                        <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        width="24"
                        height="24"
                        >
                        <path fill="none" d="M0 0h24v24H0z"></path>
                        <path
                            fill="currentColor"
                            d="M1.946 9.315c-.522-.174-.527-.455.01-.634l19.087-6.362c.529-.176.832.12.684.638l-5.454 19.086c-.15.529-.455.547-.679.045L12 14l6-8-8 6-8.054-2.685z"
                        ></path>
                        </svg>
                    </div>
                    </div>
                    <span>Send</span>
                </button>

            </form>
        </section>
    </main>
</body>
</html>