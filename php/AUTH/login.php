<?php 
require "includes/header.php";

// chequeo
if(isset($_POST['submit'])) {
  $email = $_POST['email'];
  $username = $_POST['username'];
  $password = $_POST['password'];

  try {
    $connection = new PDO("mysql:host=localhost;dbname=auth", "root", "");
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT * FROM users WHERE (email = :email OR username = :username) AND password = :password";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    if($stmt->rowCount() > 0) {
      session_start();
      $_SESSION['user'] = $username;
      echo "<div class='alert alert-success'>Sesión iniciada correctamente!</div>";
    } else {
      echo "<div class='alert alert-danger'>Usuario o contraseña incorrectos</div>";
    }
    

  } catch(PDOException $e) {
    echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
  }
}
?>

<main class="form-signin w-50 m-auto">
  <form method="POST" action="login.php">
  <h1 class="h3 mt-5 fw-normal text-center">Ingresar</h1>

  <div class="form-floating">
    <input name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
    <label for="floatingInput">Email</label>
  </div>
  <div class="form-floating">
    <input name="username" type="text" class="form-control" id="floatingInput" placeholder="user.name">
    <label for="floatingInput">Usuario</label>
  </div>
  <div class="form-floating">
    <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
    <label for="floatingPassword">Contraseña</label>
  </div>

  <button name="submit" class="w-100 btn btn-lg btn-primary" type="submit">Iniciar sesión</button>
  <h6 class="mt-3">No tienes una cuenta? <a href="register.php">Crea una</a></h6>
  </form>
</main>
<?php require "includes/footer.php"; ?>
