<?php 
    session_start();
    if(($_SERVER["REQUEST_METHOD"]=="POST")){
        $email = $_POST["email"];
        $username = $_POST["username"];
        $passwordLogin = $_POST["pass"];
        
        require "database.php";
        $sql = "SELECT * FROM users WHERE email='$email'";

        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result)===1){
            $row = mysqli_fetch_assoc($result);
            if(password_verify($passwordLogin, $row["pass"])){
                $_SESSION["username"]=$row["username"];
                header("Location: ../index.php");
                exit();
            } else {
                $errorMessage="Incorrect password";
            }
        } else {
            $errorMessage="Account not found.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../index.css">
    <link rel="stylesheet" href="./login.css">
    <link rel="icon" type="image/x-icon" href="../src/media/icon.jpg">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>Login - Let's Productive</title>
</head>
<body>
    <main>
        <div class="link-section">
            <a href="../index.php">
                <img src="../src/media/icon-white2.png" alt="check icon" class="link-icon">
                <h3 id="link-title">Productive</h3>
            </a>
        </div>
        <h2 id="login-title">Login</h2>
        <div class="login-section">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <h3>Email</h3>
                <input type="email" name="email" required>
                <h3>Your name</h3>
                <input type="text" name="username" required>
                <h3>Password</h3>
                <input type="password" name="pass" required>
                <input type="submit" name="submit" value="Log in with email">
                <p id="error-message">
                    <?php if(isset($errorMessage)){echo $errorMessage;} ?>
                </p>
            </form>
        </div>
        <div class="register-section">
            <h3>Do not have an account?</h3>
            <a href="./register.php" class="register-link">Create account</a>
        </div>
    </main>
    <script src="./login.js"></script>
</body>
</html>