<?php require "includes/header.php"; ?>

<?php require "includes/footer.php"; ?>
<?php
require "config.php";

try {
    $connection = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $connection->prepare("SELECT title, body, rating, created_at FROM ratings ORDER BY created_at DESC");
    $stmt->execute();

    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($posts as $post) {
        echo "<div class='post'>";
        echo "<h2>" . htmlspecialchars($post['title']) . "</h2>";
        echo "<p>" . nl2br(htmlspecialchars($post['body'])) . "</p>";
        echo "<p>Rating: " . htmlspecialchars($post['rating']) . "</p>";
        echo "<p>Posted on: " . htmlspecialchars($post['created_at']) . "</p>";
        echo "</div>";
    }

} catch(PDOException $e) {
    echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
}
?>