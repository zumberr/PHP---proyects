///el usuario es un "username VARCHAR(255) UNIQUE NOT NULL,"

<?php require "includes/header.php"; ?>



<main class="form-signin w-50 m-auto">
  <form method="POST" action="register.php">
   
    <h1 class="h3 mt-5 fw-normal text-center">Bienvenido porfavor haz tu registro</h1>

    <div class="form-floating">
      <input name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
      <label for="floatingInput">Email</label>
    </div>

    <div class="form-floating">
      <input name="username" type="text" class="form-control" id="floatingInput" placeholder="username">
      <label for="floatingInput">usuario</label>
    </div>

    <div class="form-floating">
      <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
      <label for="floatingPassword">Contraseña</label>
    </div>

    <button name="submit" class="w-100 btn btn-lg btn-primary" type="submit">register</button>
    <h6 class="mt-3">Ya tienes una cuenta?  <a href="login.php">Inicia Sesion!</a></h6>

  </form>
</main>
<?php require "includes/footer.php"; ?>
<?php
if(isset($_POST['submit'])) {
  $email = $_POST['email'];
  $username = $_POST['username'];
  $password = $_POST['password'];

  try {
    $connection = new PDO("mysql:host=localhost;dbname=auth", "root", "");
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create usuario si no existe
    $sql = "CREATE TABLE IF NOT EXISTS users (
      id INT PRIMARY KEY AUTO_INCREMENT,
      email VARCHAR(255) UNIQUE NOT NULL,
      password VARCHAR(255) NOT NULL
    )";
    $connection->exec($sql);

    // Insertar un nuevo usuario
    $sql = "INSERT INTO users (email, username, password) VALUES (:email, :username, :password)";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    echo "<div class='alert alert-success'>Usuario registrado correctamente!</div>";
  } catch(PDOException $e) {
    if($e->getCode() == 23000) {
      echo "<div class='alert alert-danger'>El email o username ya existe</div>";
    } else {
      echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
  }
}
?>