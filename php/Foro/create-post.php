<?php require "includes/header.php"; ?>
          <!-- Main content -->
          <div style="margin-top: 57px;" class="col-lg-9 mb-3">
   <?php  
   if(isset($_POST['submit'])){

     if(empty($_POST['title']) || empty($_POST['post_author']) || empty($_POST['category'])){
         echo "<script>alert('Porfavor rellena los espacios')</script>";
   } else {
       echo "<script>alert('Post creado')</script>";
       $title = $_POST['title'];
       $post_author = $_POST['post_author'];
       $category = $_POST['category'];
       $post_date = date('d-m-y');
       $post_comment_count = 4;
       $post_status = 'publicado';
       $post_content = $_POST['Body'];

       $query = "INSERT INTO posts(category, title, post_author, post_date, post_content, post_comment_count, post_status) ";
       $query .= "VALUES({$category}, '{$title}', '{$post_author}'')";
       //,now(), '{$post_content}', {$post_comment_count}, '{$post_status}
        
       $create_post_query = mysqli_query($connection, $query);

       if(!$create_post_query){
           die('QUERY FAILED' . mysqli_error($connection));
       }
       header("Location: index.php");
   }
}
   
   ?>


            <form method ="POST" action ="create-post.php">

                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Titulo </label>
                  <input type="email" name="title" class="form-control" placeholder="write title" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                      <label for="exampleFormControlTextarea1">Cuerpo</label>
                      <textarea name ="Body" class="form-control" placeholder="Hola mundo" ows="3"></textarea>
                </div>

                <div class="mb-3">
                  <label for="exampleInputPassword1" class="form-label">Autor</label>
                  <input type="text" name="post_author" placeholder="write authorname" class="form-control" id="exampleInputPassword1">
                </div>

                <select name="category" class="form-select mb-5 mt-5" aria-label="Default select example">
                    <label class="form-label">Escoge categoria</label>

                    <option selected>Choose Category</option>
                    <option value="1">diseño</option>
                    <option value="2">Marketing</option>
                    <option value="3">programacion</option>
                </select>

                <button name="submit" type="submit" class="btn btn-primary w-100">enviar</button>

              </form>
          
          </div>
<?php require "includes/footer.php"; ?>