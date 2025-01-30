
<?php

  require "conn.php";
  

  $data = $conn->query("SELECT * FROM tasks");
if(isset($_POST['submit'])) {
	
		$task = $_POST['mytask'];

	    $insert = $conn->prepare("INSERT INTO tasks (name) VALUES (:name)");

	    $insert->execute([':name' => $task]);
	
		header("location: index.php");
	
}

?>


<!DOCTYPE html>
<html>
	<head>
		<title>todos</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="" crossorigin="">
		<link rel="stylesheet" href="style.css">

	</head>
	<body>
        <div class="container">
		<form method="POST" action="insert.php" class="form-inline">
		 
		  <div class="form-group mx-sm-3 mb-2">
		    <label for="inputPassword2" class="sr-only">Crear</label>
		    <input name="mytask" type="text" class="form-control" id="inputPassword2" placeholder="enter task">
		  </div>
		       <button name="submit" type="submit" class="btn btn-primary mb-2">Crear</button>

		</form>

		<table class="table">
		  <thead>
		    <tr>
		      <th>#</th>
		      <th>Nombre de la tarea</th>
		      <th>Accion</th>
		    </tr>
		  </thead>
		  <tbody>
		  	 <?php while($rows = $data->fetch(PDO::FETCH_OBJ)): ?>   
		    <tr>
		   
		     <td><?php echo $rows->id; ?></td>
		     <td><?php echo $rows->name; ?></td>
		     <td><a href="delete.php?del_id=<?php echo $rows->id; ?>" class="btn btn-danger">eliminar</a></td>

		    </tr>
		<?php endwhile; ?>


		  </tbody>
		</table>
	</div>



		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
       <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="" crossorigin="anonymous"></script>

	</body>
</html>