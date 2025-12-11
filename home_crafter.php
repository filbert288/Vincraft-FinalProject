<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VinCaft-Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <a class="logo">VinCraft Community</a>
        
        <a href="home_crafter.php">Home</a>
        <a href="browse_crafter.php">Browse Posts</a>
        <a href="">Upload Post</a>
        <a href="">My Post</a>
        <a href="">Logout</a>
        
        <?php if(isset($_SESSION['username'])): ?>
            <a class="welcome"><b>Welcome, <?php echo $_SESSION['username']; ?>!</b></a>
        <?php endif; ?>
    </nav>
    
    <Header>
        <h3>Welcome to VinCraft Community</h3>
        <br>
        Discover amazing content from our community members
    </Header>

    <section>
        <h2>RECENT POST</h2>
        <div class="container">
            <div class="posts">
                <img src="assets/Card 1.jpg" alt="">
                <h3>New Cute Video on My Youtube Channel!</h3>
                <div id="creator">By Vivin * Jul 5, 2025</div>
                <p>News</p>
                <a href="">View Details</a>
            </div>

            <div class="posts">
                <img src="assets/Card 2.jpg" alt="">
                <h3>Cutest Pink Banner Ever?! Yes Please!</h3>
                <div id="creator">By Vivin * Jul 5, 2025</div>
                <p>Tutorial</p>
                <a href="">View Details</a>
            </div>

            <div class="posts">
                <img src="assets/Card 3.jpg" alt="">
                <h3>Next-Level Decor with This Minecraft Mod!</h3>
                <div id="creator">By DaVinci * Jul 5, 2025</div>
                <p>Mods</p>
                <a href="">View Details</a>
            </div>

        </div>

        <div class="browse">
            <a href="browse_crafter.php">Browse All Post</a>
        </div>

    </section>

    
    <footer>
        © 2025 VinCraft Community. All rights reserved</div>
    </footer>

</body>
</html>


