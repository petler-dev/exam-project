<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 20px;
            transition: background-color 0.3s, color 0.3s;
        }
        .dark-mode {
            background-color: #333;
            color: white;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1 class="text-center">Welcome to the Dashboard, <?php echo htmlspecialchars($_SESSION['user']); ?>!</h1>
        
        <div class="text-center mt-4">
            <h3>Current Time</h3>
            <p id="time" style="font-size: 24px;"></p>
        </div>

        <div class="text-center mt-4">
            <h3>Switch Theme</h3>
            <button class="btn btn-secondary" id="themeSwitcher">Toggle Dark Mode</button>
        </div>

        <div class="text-center mt-4">
            <form method="POST" action="logout.php">
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>
    </div>

    <script>
        function updateTime() {
            const timeElement = document.getElementById('time');
            const now = new Date();
            const formattedTime = now.toLocaleTimeString();
            timeElement.textContent = formattedTime;
        }
        setInterval(updateTime, 1000);

        const themeSwitcher = document.getElementById('themeSwitcher');
        themeSwitcher.addEventListener('click', function() {
            document.body.classList.toggle('dark-mode');
            if (document.body.classList.contains('dark-mode')) {
                themeSwitcher.textContent = 'Switch to Light Mode';
            } else {
                themeSwitcher.textContent = 'Switch to Dark Mode';
            }
        });
    </script>

</body>
</html>
