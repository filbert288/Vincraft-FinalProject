<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VinCaft-Browser</title>
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

        <section>
        <h2>BROWSE POST</h2>
        
        <form method="GET" class="filter-form">
            <input type="text" name="search" placeholder="Search title..." 
            value="<?php echo $_GET['search'] ?? ''; ?>">
        
        <select name="category">
            <option value="">All Categories</option>
            <option value="News">News</option>
            <option value="Tutorial">Tutorial</option>
            <option value="Mods">Mods</option>
            <option value="Builds">Builds</option>
        </select>
        
        <button type="submit">Filter</button>
        </form>

        <div class="container">
            <div class="posts">
                <img src="assets/Card 1.jpg" alt="">
                <h3>New Cute Video on My Youtube Channel!</h3>
                <div id="creator">By Vivin * Jul 5, 2025</div>
                <p>Category: News</p>
                <a href="login.php">View Details</a>
            </div>

            <div class="posts">
                <img src="assets/Card 2.jpg" alt="">
                <h3>Cutest Pink Banner Ever?! Yes Please</h3>
                <div id="creator">By Vivin * Jul 5, 2025</div>
                <p>Category: Tutorial</p>
                <a href="login.php">View Details</a>
            </div>

            <div class="posts">
                <img src="assets/Card 3.jpg" alt="">
                <h3>Next-Level Decor with This Minecraft Mod!</h3>
                <div id="creator">By DaVinci * Jul 5, 2025</div>
                <p>Category: Mods</p>
                <a href="login.php">View Details</a>
            </div>

            <div class="posts">
                <img src="assets/Card 6.jpg" alt="">
                <h3>Cozy Vibes Only - No More Boring Mansions!</h3>
                <div id="creator">By Vincent * Jul 5, 2025</div>
                <p>Category: Builds</p>
                <a href="login.php">View Details</a>
            </div>

            <div class="posts">
                <img src="assets/Card 4.jpg" alt="">
                <h3>Check Out My Sword-Shaped Nether Portal!</h3>
                <div id="creator">By Vincent * Jul 5, 2025</div>
                <p>Category: Builds</p>
                <a href="login.php">View Details</a>
            </div>

            <div class="posts">
                <img src="assets/Card 5.png" alt="">
                <h3>Redstone Elevator</h3>
                <div id="creator">By Kelvin * Jul 5, 2025</div>
                <p>Category: Redstone</p>
                <a href="login.php">View Details</a>
            </div>

        </div>

    
    <footer>
        © 2025 VinCraft Community. All rights reserved</div>
    </footer>

</body>
</html>
