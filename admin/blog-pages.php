
<?php
//include connection file 
require_once('../includes/config.php');

//check login or not 
if(!$user->is_logged_in()){ header('Location: login.php'); }


if(isset($_GET['delpost'])){ 

    $stmt = $db->prepare('DELETE FROM pages WHERE pageId = :pageId') ;
    $stmt->execute(array(':pageId' => $_GET['delpost']));

    header('Location: blog-pages.php?action=deleted');
    exit;
} 


?>

<?php include("head.php");  ?>

  <title>Admin Page </title>
  <script language="JavaScript" type="text/javascript">
  function delpost(id, title)
  {
      if (confirm("Are you sure you want to delete '" + title + "'"))
      {
          window.location.href = 'blog-pages.php?delpost=' + pageId;
      }
  }
  </script>
  <?php include("header.php");  ?>

<div class="content">
<?php 
    //show message from add / edit page
    if(isset($_GET['action'])){ 
        echo '<h3>Post '.$_GET['action'].'.</h3>'; 
    } 
    ?>

    <table>
    <tr>
        <th>Article Title</th>

        <th>Update</th>
         <th>Delete</th>
    </tr>
    <?php
        try {

            $stmt = $db->query('SELECT pageId,pageTitle,pageDescrip,pageContent,pageKeywords FROM pages ORDER BY pageId DESC');
            while($row = $stmt->fetch()){
                
                echo '<tr>';
                echo '<td>'.$row['pageTitle'].'</td>';
                
                ?>

                <td>
                        <button class="editbtn">  <a href="edit-blog-page.php?pageId=<?php echo $row['pageId'];?>">Edit</a>       </button></td><td>
                   <button class="delbtn">  <a href="javascript:delpost('<?php echo $row['pageId'];?>','<?php echo $row['pageTitle'];?>')">Delete</a></button>
                </td>
                
                <?php 
                echo '</tr>';

            }

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    ?>
    </table>

    <p><button class="editbtn"><a href='add-blog-page.php'>Add New Page</a></button></p>       
</div>
  <?php include("sidebar.php");  ?>
<?php include("footer.php");  ?> 

