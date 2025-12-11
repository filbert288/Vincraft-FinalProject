<!-- PHP -->
<?php
include 'db_connect.php';
session_start();

$where = [];
$params = [];
$types = "";

if (!empty($_GET['search'])) {
    $where[] = "PostTitle LIKE ?";
    $params[] = "%" . $_GET['search'] . "%";
    $types .= "s";
}

if (!empty($_GET['category'])) {
    $where[] = "post.CategoryID = ?";
    $params[] = $_GET['category'];
    $types .= "s";
}

$sql = "SELECT post.*, category.CategoryName 
        FROM post 
        JOIN category ON post.CategoryID = category.CategoryID";

if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
while($post = $result->fetch_assoc()):
?>

<div class="posts">
        <img src="<?php echo $post['Image']; ?>" alt="">
        <h3><?php echo $post['PostTitle']; ?></h3>
        <div class="creator">By <?php echo $post['Creator']; ?> • <?php echo $post['Date']; ?></div>
        <p class="category"><?php echo $post['Category']; ?></p>
        <a href="view_post.php?id=<?php echo $post['PostID']; ?>">View</a>
    </div>
<?php endwhile; ?>

<!-- HTML -->
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
        
        <a href="home_guest.php">Home</a>
        <a href="browse_guest.php">Browse Posts</a>
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
                <a href="login.php">Login to View</a>
            </div>

            <div class="posts">
                <img src="assets/Card 2.jpg" alt="">
                <h3>Cutest Pink Banner Ever?! Yes Please</h3>
                <div id="creator">By Vivin * Jul 5, 2025</div>
                <p>Category: Tutorial</p>
                <a href="login.php">Login to View</a>
            </div>

            <div class="posts">
                <img src="assets/Card 3.jpg" alt="">
                <h3>Next-Level Decor with This Minecraft Mod!</h3>
                <div id="creator">By DaVinci * Jul 5, 2025</div>
                <p>Category: Mods</p>
                <a href="login.php">Login to View</a>
            </div>

            <div class="posts">
                <img src="assets/Card 6.jpg" alt="">
                <h3>Cozy Vibes Only - No More Boring Mansions!</h3>
                <div id="creator">By Vincent * Jul 5, 2025</div>
                <p>Category: Builds</p>
                <a href="login.php">Login to View</a>
            </div>

            <div class="posts">
                <img src="assets/Card 4.jpg" alt="">
                <h3>Check Out My Sword-Shaped Nether Portal!</h3>
                <div id="creator">By Vincent * Jul 5, 2025</div>
                <p>Category: Builds</p>
                <a href="login.php">Login to View</a>
            </div>

            <div class="posts">
                <img src="assets/Card 5.png" alt="">
                <h3>Redstone Elevator</h3>
                <div id="creator">By Kelvin * Jul 5, 2025</div>
                <p>Category: Redstone</p>
                <a href="login.php">Login to View</a>
            </div>

        </div>

    
    <footer>
        © 2025 VinCraft Community. All rights reserved</div>
    </footer>

</body>
</html>
