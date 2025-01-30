<?php 
  
   
    $posts = $conn->query("SELECT * FROM posts ORDER BY created_at DESC");
    $posts->execute();

    $allPosts = $posts->fetchAll(PDO::FETCH_OBJ);

    //number of categories
    $categories = $conn->query("SELECT COUNT(id) AS num_categories FROM categories");
    $categories->execute();

    $num_cats = $categories->fetch(PDO::FETCH_OBJ);


     //number of posts
    $posts = $conn->query("SELECT COUNT(id) AS num_posts FROM posts");
    $posts->execute();
 
    $num_posts= $posts->fetch(PDO::FETCH_OBJ);


    //number of replies
    $replies = $conn->query("SELECT COUNT(id) AS num_replies FROM replies");
    $replies->execute();
     
    $num_replies= $replies->fetch(PDO::FETCH_OBJ); 
  
?>
 <div class="col-lg-3 mb-4 mb-lg-0 px-lg-0 mt-lg-0">
            <div style="visibility: hidden; display: none; width: 285px; height: 801px; margin: 0px; float: none; position: static; inset: 85px auto auto;"></div><div data-settings="{&quot;parent&quot;:&quot;#content&quot;,&quot;mind&quot;:&quot;#header&quot;,&quot;top&quot;:10,&quot;breakpoint&quot;:992}" data-toggle="sticky" class="sticky" style="top: 85px;"><div class="sticky-inner">
              <a class="btn btn-lg btn-block btn-success rounded-0 py-4 mb-3 bg-op-6 roboto-bold" href="create-post.php">Pregunta</a>
              <div class="bg-white mb-3">
                <h4 class="px-3 py-4 op-5 m-0">
                  Latest Posts
                </h4>
                <hr class="m-0">
                <?php foreach ($allPosts as $post) : ?>
                <div class="pos-relative px-3 py-3">
                  <h6 class="text-primary text-sm">
                    <a href="single.php?id=<?php echo $post->id; ?>" class="text-primary"><?php echo $post->title; ?> </a>
                  </h6>
                  <p class="mb-0 text-sm"><span class="op-6">Posted</span> <?php echo $post->created_at; ?> <a class="text-black" href="#"><?php echo $post->category; ?></a></p>
                </div>
                <hr class="m-0">
                <?php endforeach; ?>

                <div class="bg-white text-sm">
                    <h4 class="px-3 py-4 op-5 m-0 roboto-bold">
                      Stats
                    </h4>
                    <hr class="my-0">
                    <div class="row text-center d-flex flex-row op-7 mx-0">
                      <div class="col-sm-6 flex-ew text-center py-3 border-bottom border-right"> <a class="d-block lead font-weight-bold" href="#"><?php echo $num_cats->num_categories; ?></a> Categories </div>
                      <div class="col-sm-6 col flex-ew text-center py-3 border-bottom mx-0"> <a class="d-block lead font-weight-bold" href="#"><?php echo $num_posts->num_posts; ?></a> Posts </div>
                    </div>
                    <div class="row d-flex flex-row op-7">
                      <div class="col-sm-6 flex-ew text-center py-3 border-right mx-0"> <a class="d-block lead font-weight-bold" href="#"><?php echo $num_replies->num_replies; ?></a> Replies </div>
                    </div>
                </div>
              
            </div></div>
          </div>
        </div>
      </div>
  </body>
</html>