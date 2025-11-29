<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Fannet</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <a href="index.php" class="logo">Fannet</a>
        <nav>
            <a href="index.php">Home</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <div class="container">
        <section class="hero">
            <h1>Welcome back, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
            <p>Ready to jump back into the action?</p>
        </section>

        <section class="games">
            <h2>Your Library</h2>
            <div class="game-grid">
                <div class="game-card">
                    <img src="cyber_odyssey_game_cover.jpg" alt="Cyber Odyssey">
                    <div class="game-info">
                        <h3>Cyber Odyssey</h3>
                        <a href="#" class="btn" style="width: 100%; text-align: center; margin-top: 1rem;">Play Now</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>
</html>
