<?php 
require_once('../includes/config.php');


if(!$user->is_logged_in()){ header('Location: login.php'); }
?>
<?php include("head.php");  ?>
    <title>Add New Topics- The Blog Site</title>
    <?php include("header.php");  ?>

<div class="content">
 <h2>Add Topics</h2>

    <?php

    //if form has been submitted process it
    if(isset($_POST['submit'])){

        $_POST = array_map( 'stripslashes', $_POST );

        //collect form data
        extract($_POST);

        //very basic validation
        if($topicName ==''){
            $error[] = 'Please enter the Topic.';
        }

        if(!isset($error)){

            try {

                $topicSlug = slug($topicName);

                //insert into database
                $stmt = $db->prepare('INSERT INTO topics (topicName,topicSlug) VALUES (:topicName, :topicSlug)') ;
                $stmt->execute(array(
                    ':topicName' => $topicName,
                    ':topicSlug' => $topicSlug
                ));

                //redirect to index page
                header('Location: blog-topics.php?action=added');
                exit;

            } catch(PDOException $e) {
                echo $e->getMessage();
            }

        }

    }

    //check for any errors
    if(isset($error)){
        foreach($error as $error){
            echo '<p class="message">'.$error.'</p>';
        }
    }
    ?>

    <form action="" method="post">

        <h2><label>Topic Title</label><br>
        <input type='text' name='topicName' value='<?php if(isset($error)){ echo $_POST['topicName'];}?>'>
        <p><input type="submit" name="submit" value="Submit"></p>

    

</h2></form></div>
  <?php include("sidebar.php");  ?>



<?php include("footer.php");  ?>


 