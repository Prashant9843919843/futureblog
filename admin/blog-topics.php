<?php
//include config
require_once('../includes/config.php');

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }

//show message from add / edit page
if(isset($_GET['delcat'])){ 

    $stmt = $db->prepare('DELETE FROM topics WHERE topicid = :topicid') ;
    $stmt->execute(array(':topicid' => $_GET['delcat']));

    header('Location: topics.php?action=deleted');
    exit;
} 

?>
<?php include("head.php");  ?>
  <title>topics- The Blog Site</title>
  <script language="JavaScript" type="text/javascript">
  function delcat(id, title)
  {
      if (confirm("Are you sure you want to delete '" + title + "'"))
      {
          window.location.href = 'topics.php?delcat=' + id;
      }
  }
  </script>
  <?php include("header.php");  ?>

<div class="content">
 <?php 
    //show message from add / edit page
    if(isset($_GET['action'])){ 
        echo '<h3>Topic '.$_GET['action'].'.</h3>'; 
    } 
    ?>

    <table>
    <tr>
        <th>Title</th>
        <th>Operation</th>
    </tr>
    <?php
        try {

            $stmt = $db->query('SELECT topicid, topicName, topicSlug FROM topics ORDER BY topicName DESC');
            while($row = $stmt->fetch()){
                
                echo '<tr>';
                echo '<td>'.$row['topicName'].'</td>';
                ?>

                <td>
                  <button class="editbtn">  <a href="edit-blog-topics.php?id=<?php echo $row['topicid'];?>">Edit</a>   </button> 
                        <button class="delbtn">  <a href="javascript:delcat('<?php echo $row['topicid'];?>','<?php echo $row['topicSlug'];?>')">Delete</a></button>
                </td>
                
                <?php 
                echo '</tr>';

            }

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    ?>
    </table>

    <p><button class="editbtn"><a href='add-blog-topics.php'>Add New Topic</a></button></p>
</div>
  <?php include("sidebar.php");  ?>
<?php include("footer.php");  ?>
 