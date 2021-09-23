<div class="sidebar">
    <h2>Quick Shorcut</h2>
  
        <a href="index.php">View Blogs </a>
         <a href="add-blog-article.php">Add New Blog Post </a>

        <a href="blog-topics.php">View Topics </a>
           <a href="add-blog-topics.php">Add New Topic </a>
             <a href="blog-users.php">View Users </a>
          <!--   <a href="add-blog-page.php">Add New Page </a>
              <a href="blog-pages.php">View Pages </a> -->
               <a href="add-blog-user.php">Add New Users  </a>
                 <a target="_blank" href="../">Visit Blog </a>
  <?php 
  $sql = $db->query('select count(*) from blogs')->fetchColumn(); 
echo'<h2>Total Posted '.'<font color="red">'.$sql.'</font>'.'</h2>' ;
?>


</div>