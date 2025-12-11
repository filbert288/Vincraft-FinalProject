<?php

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
        
        <a href="home_admin.php">Home</a>
        <a href="browse_admin.php">Browse Posts</a>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
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
                <div id="manage"><a href="">Manage Post</a></div>
            </div>

            <div class="posts">
                <img src="assets/Card 2.jpg" alt="">
                <h3>Cutest Pink Banner Ever?! Yes Please</h3>
                <div id="creator">By Vivin * Jul 5, 2025</div>
                <p>Category: Tutorial</p>
                <div id="manage"><a href="">Manage Post</a></div>
            </div>

            <div class="posts">
                <img src="assets/Card 3.jpg" alt="">
                <h3>Next-Level Decor with This Minecraft Mod!</h3>
                <div id="creator">By DaVinci * Jul 5, 2025</div>
                <p>Category: Mods</p>
                <div id="manage"><a href="">Manage Post</a></div>
            </div>

            <div class="posts">
                <img src="assets/Card 6.jpg" alt="">
                <h3>Cozy Vibes Only - No More Boring Mansions!</h3>
                <div id="creator">By Vincent * Jul 5, 2025</div>
                <p>Category: Builds</p>
                <div id="manage"><a href="">Manage Post</a></div>
            </div>

            <div class="posts">
                <img src="assets/Card 4.jpg" alt="">
                <h3>Check Out My Sword-Shaped Nether Portal!</h3>
                <div id="creator">By Vincent * Jul 5, 2025</div>
                <p>Category: Builds</p>
                <div id="manage"><a href="">Manage Post</a></div>
            </div>

            <div class="posts">
                <img src="assets/Card 5.png" alt="">
                <br>
                <br>
                <br>
                <h3>Redstone Elevator</h3>
                <div id="creator">By Kelvin * Jul 5, 2025</div>
                <p>Category: Redstone</p>
                <div id="manage"><a href="">Manage Post</a></div>
            </div>

        </div>

    
    <footer>
        © 2025 VinCraft Community. All rights reserved</div>
    </footer>

</body>
</html>
