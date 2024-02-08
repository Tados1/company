<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/sign-in.css">
    <title>Sign In</title>
</head>
<body>
    <main class="sign-in-content">
        <section class="sign-in-form">
            <h1>Sign in</h1>
            <form action="log-in.php" method="POST">

                <div class="login-name">
                    <p>Login Name</p>
                    <input class="login_name" type="text" name="login_name">
                </div>
                
                <div class="password">
                    <p>Password</p>
                    <input class="login_password" type="password" name="login_password">
                </div>

                <input class="btn" type="submit" value="Sign in">

            </form>
        </section>
    </main>
</body>
</html>