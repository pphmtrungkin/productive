<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./index.css">
    <link rel="icon" type="image/x-icon" href="./src/media/icon.jpg">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>Let's Productive</title>
</head>
<body>
    <header>
        <ul class="nav-list">
            <li class="nav-item">
                <a href="" class="nav-item_link">
                    <img src="./src/media/icon-white2.png" alt="check icon" class="logo-icon">
                    <h3>Productive</h3>
                </a>
            </li>
            <li class="nav-item">
                <button type="button" class="option-button">
                    <a href="./public/login.php" class="nav-item_link">
                        <img src="./src/media/user-white.png" alt="user-icon" class="option-icon">
                        <p class="option-text">
                            <?php 
                                if(isset($_SESSION["username"])){
                                    echo $_SESSION["username"];
                                } else {
                                    echo "Login";
                                }
                            ?>
                        </p>
                    </a>
                </button>
                <ul class="dropdown">
                    <li>
                        <button type="button" class="option-button">
                            <a href="./public/logout.php" class="nav-item_link">
                                <p class="option-text">Log out</p>
                            </a>
                        </button>
                    </li>
                </ul>
            </li>
        </ul>
    </header>
    <main>
        <div id="pomodoro">
            <div class="pomodoro-mode">
                <button type="button" id="pomodoro-session" class="mode-btn active">Pomodoro</button>
                <button type="button" id="short-break" class="mode-btn">Short break</button>
                <button type="button" id="long-break" class="mode-btn">Long break</button>
            </div>
            <div id="pomodoro-timer"></div>
            <div class="pomodoro-control">
                <button type="button" class="control-btn" id="pomodoro-start">Start</button>
                <button type="button" class="control-btn" id="pomodoro-pause">Pause</button>
                <button type="button" class="control-btn" id="pomodoro-restart">Restart</button>
            </div>
        </div>
        <h2>Let's productive !!</h2>
            <form id="todo-form">
                <input type="text" placeholder="Type in your goal for today: " required id="todo-input">
                <input type="submit" id="todo-submit">
            </form>
        <h2 id="todo-title">To do list</h2>
        <ul class="todo-list"></ul>
    </main>
    <script defer src="./index.js"></script>
</body>
</html>