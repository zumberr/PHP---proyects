<?php require "includes/header.php"; ?>
<?php require "config.php"; ?>



<main class="form-signin w-50 m-auto">
  <form method="POST" action="register.php">
   
    <h1 class="h3 mt-5 fw-normal text-center">Crear post</h1>

    <div class="form-floating">
      <input name="email" type="text" class="form-control" id="floatingInput" placeholder="titulo">
      <label for="floatingInput">titulo</label>
    </div>

    <div class="form-floating">
      <input name="username" type="hidden" class="form-control" id="floatingInput" placeholder="username">
    </div>

    <div class="form-floating">
     <textarea rows = "9" name ="body" placeholder ="nody" class = "form-control"></textarea>
      <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
      <label for="floatingPassword">Password</label>
    </div>

    <button name="submit" class="w-50 btn btn-lg btn-primary mt -5" type="submit">crear post</button>

  </form>
</main>


<?php require "includes/footer.php"; ?>
<?php
if(isset($_POST['submit'])) {
    $title = $_POST['email'];  // Usando 'email' como titulo
    $body = $_POST['body'];
    $rating = isset($_POST['rating']) ? $_POST['rating'] : 0;

    try {
        $connection = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "CREATE TABLE IF NOT EXISTS ratings (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            body TEXT,
            rating INT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $connection->exec($sql);

        $stmt = $connection->prepare("INSERT INTO ratings (title, body, rating) VALUES (:title, :body, :rating)");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':body', $body);
        $stmt->bindParam(':rating', $rating);
        $stmt->execute();

        echo "<div class='alert alert-success'>Valoración creada exitosamente</div>";
    } catch(PDOException $e) {
        echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
    $connection = null;
}
?>