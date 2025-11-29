<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fannet - Professional Gaming</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <a href="index.php" class="logo">Fannet</a>
        <nav>
            <a href="index.php">Home</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="dashboard.php">Dashboard</a>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            <?php endif; ?>
        </nav>
    </header>

    <div class="container">
        <section class="hero">
            <h1>Welcome to Fannet</h1>
            <p>Experience the next generation of gaming.</p>
            <?php if (!isset($_SESSION['user_id'])): ?>
                <a href="register.php" class="btn">Join Now</a>
            <?php endif; ?>
        </section>

        <section class="games">
            <h2>Our Top Games</h2>
            <div class="game-grid">
                <div class="game-card">
                    <img src="cyber_odyssey_game_cover.jpg" alt="Cyber Odyssey">
                    <div class="game-info">
                        <h3>Cyber Odyssey</h3>
                        <p>Explore a futuristic world filled with mystery and action.</p>
                    </div>
                </div>
                <div class="game-card">
                    <img src="shadow_legends_game_cover.jpg" alt="Iron Warfare">
                    <div class="game-info">
                        <h3>Iron Warfare</h3>
                        <p>Command powerful tanks in this dark, gritty war simulation.</p>
                    </div>
                </div>
                <div class="game-card">
                    <img src="velocity_racing_game_cover.jpg" alt="Velocity Racing">
                    <div class="game-info">
                        <h3>Velocity Racing</h3>
                        <p>High-speed racing with realistic physics.</p>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <footer>
        <p>&copy; 2023 Fannet Gaming. All rights reserved.</p>
    </footer>
</body>
</html>
