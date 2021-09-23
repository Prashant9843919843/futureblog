<?php //include connection file 
require_once('../includes/config.php');


if(!$user->is_logged_in()){ header('Location: login.php'); }
?>

<?php include("head.php");  ?>
    <title>EDIT Topic- The Blog Site</title>
    <?php include("header.php");  ?>

<div class="content">
 <h2>Edit Topic-The Blog Site</h2>


    <?php

    //if form has been submitted process it
    if(isset($_POST['submit'])){

        $_POST = array_map( 'stripslashes', $_POST );

        //collect form data
        extract($_POST);

        //very basic validation
        if($topicid ==''){
            $error[] = 'Invalid id.';
        }

        if($topicName ==''){
            $error[] = 'Please enter the topic Title .';
        }

        if(!isset($error)){

            try {

                $topicSlug = slug($topicName);

                //insert into database
                $stmt = $db->prepare('UPDATE topics SET topicName = :topicName, topicSlug = :topicSlug WHERE topicid = :topicid') ;
                $stmt->execute(array(
                    ':topicName' => $topicName,
                    ':topicSlug' => $topicSlug,
                    ':topicid' => $topicid
                ));

                //redirect to categories  page
                header('Location: blog-topics.php?action=updated');
                exit;

            } catch(PDOException $e) {
                echo $e->getMessage();
            }

        }

    }

    ?>


    <?php
    //check for any errors
    if(isset($error)){
        foreach($error as $error){
            echo $error.'<br>';
        }
    }

        try {

            $stmt = $db->prepare('SELECT topicid, topicName FROM topics WHERE topicid = :topicid') ;
            $stmt->execute(array(':topicid' => $_GET['id']));
            $row = $stmt->fetch(); 

        } catch(PDOException $e) {
            echo $e->getMessage();
        }

    ?>

    <form action="" method="post">
        <input type='hidden' name='topicid' value='<?php echo $row['topicid'];?>'>

        <p><label>Category Title</label><br>
        <input type='text' name='topicName' value='<?php echo $row['topicName'];?>'>

        </p><p><input type="submit" name="submit" value="Update"></p>

    </form>


</div>
  <?php include("sidebar.php");  ?>



<?php include("footer.php");  ?>




    