<?php 
    session_start();
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $email = $_POST["email"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $cpassword = $_POST["cpassword"];
        
        require "database.php";
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result)>0){
            $errorMessage = "This email is already made.";
        } else {
            if(strlen($password)<8){
                $errorMessage = "Password must be at least 8 characters";
            }
            else if(!preg_match("/[a-z]/i", $password)){
                $errorMessage = "Password must contain at least 1 letter";
            }
            else if(!preg_match("/[0-9]/", $password)){
                $errorMessage = "Password must contain at least 1 number";
            } else {
                if($password!==$cpassword){
                    $errorMessage="Passwords do not match";
                } else {
                    $password_hashed = password_hash($password, PASSWORD_DEFAULT);
                    
                    $sql = "INSERT INTO users (username, email, pass) VALUES (?, ?, ?)";
    
                    $stmt = mysqli_stmt_init($conn);

                    $preparestmt = mysqli_stmt_prepare($stmt, $sql);
    
                    if($preparestmt){
                        mysqli_stmt_bind_param($stmt,"sss",$username, $email, $password_hashed);
                        mysqli_stmt_execute($stmt);
                        $successMessage = "User registered";
                    } else {
                        $errorMessage = "Something went wrong.";
                    }
                    mysqli_stmt_close($stmt);
                }
            }
        }
        mysqli_close($conn);
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
    <title>Register - Let's Productive</title>
</head>
<body>
    <main>
        <div class="link-section">
            <a href="../index.php">
                <img src="../src/media/icon-white2.png" alt="check icon" class="link-icon">
                <h3 id="link-title">Productive</h3>
            </a>
        </div>
        <h2 id="login-title">Create account</h2>
        <div class="login-section">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" id="login-form">
                <h3>Email</h3>
                <input placeholder="example@mail.com" type="email" name="email" required>
                <h3>Your name</h3>
                <input type="text" name="username" required>
                <h3>Password</h3>
                <input type="password" name="password" required>
                <h3>Confirm Password</h3>
                <input type="password" name="cpassword" required>
                <input type="submit" name="submit" value="Sign up with email">
                <p id="error-message">
                    <?php if(isset($errorMessage)){echo $errorMessage;} ?>
                </p>
            </form>
        </div>
        <div id="success-section">
            <h2 id="success-message">
                <?php if(isset($successMessage)) {echo $successMessage;} ?>
            </h2>
            <button type="button">
                <a href="login.php" class="register-link">Back to login page</a>
            </button>
        </div>
        <div class="register-section">
            <h3>Already have an account?</h3>
            <a href="./login.php" class="register-link">Login</a>
        </div>
    </main>
    <script src="./login.js"></script>
</body>
</html>