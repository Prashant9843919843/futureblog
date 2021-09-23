<?php require_once('../includes/config.php'); 

if(!$user->is_logged_in()){ header('Location: login.php'); }
?>
<?php include("head.php");  ?>
    <title>Update Article - The Blog Site</title>
       <!-- <script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script> -->
    <!-- ---------------------for future use only------------------------------------------------
       <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  <script>
          tinymce.init({
           mode : "specific_textareas",
    editor_selector : "mceEditor",
              plugins: [
                  "advlist autolink lists link image charmap print preview anchor",
                  "searchreplace visualblocks code fullscreen",
                  "insertdatetime media table contextmenu paste"
              ],
              toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
          });
  </script> -->
    <?php include("header.php");  ?>

<div class="content">
 
<h2>Edit Post</h2>


    <?php

   
    if(isset($_POST['submit'])){


        //collect form data
        extract($_POST);

        //very basic validation
        if($articleid ==''){
            $error[] = 'This post is missing a valid id!.';
        }

        if($articleTitle ==''){
            $error[] = 'Please enter the title.';
        }

        if($articleDescription ==''){
            $error[] = 'Please enter the description.';
        }

        if($articleContent ==''){
            $error[] = 'Please enter the content.';
        }
        


        if(!isset($error)){
try {

   

    //insert into database
    $stmt = $db->prepare('UPDATE blogs SET articleTitle = :articleTitle, articleSlug = :articleSlug, articleDescription = :articleDescription, articleContent = :articleContent, articleTags= :articleTags WHERE articleid = :articleid') ;
$stmt->execute(array(
    ':articleTitle' => $articleTitle,
    ':articleSlug' => $articleSlug,
    ':articleDescription' => $articleDescription,
    ':articleContent' => $articleContent,
    ':articleid' => $articleid,
    ':articleTags' => $articleTags,
  
));

$stmt = $db->prepare('DELETE FROM topic_links WHERE articleid = :articleid');
$stmt->execute(array(':articleid' => $articleid));

if(is_array($topicid)){
    foreach($_POST['topicid'] as $topicid){
        $stmt = $db->prepare('INSERT INTO topic_links (articleid,topicid)VALUES(:articleid,:topicid)');
        $stmt->execute(array(
            ':articleid' => $articleid,
            ':topicid' => $topicid
        ));
    }
}

    //redirect to index page
    header('Location: index.php?action=updated');
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

           $stmt = $db->prepare('SELECT articleid,articleTitle,articleSlug, articleDescription, articleContent, articleTags FROM blogs WHERE articleid = :articleid') ;
            $stmt->execute(array(':articleid' => $_GET['id']));
            $row = $stmt->fetch(); 

        } catch(PDOException $e) {
            echo $e->getMessage();
        }

    ?>

    <form action='' method='post'>
        <input type='hidden' name='articleid' value="<?php echo $row['articleid'];?>">

           <h2><label>Article Title</label><br>
        <input type='text' name='articleTitle' style="width:100%;height:40px" value="<?php echo $row['articleTitle'];?>"></h2>
        

       
       <h2><label>Short Description(Meta Description) </label><br>
        <textarea name='articleDescription' cols='120' rows='6'><?php echo $row['articleDescription'];?></textarea></h2>

       <h2><label>Long Description(Body Content)</label><br>
        <textarea name='articleContent' id='textarea1' class='mceEditor' cols='120' rows='20'><?php echo $row['articleContent'];?></textarea></h2>
        <h2><label>Articles Tags (Seprated by comma without space)</label><br>
<input type='text' name='articleTags' style="width:100%;height:40px;"value='<?php echo $row['articleTags'];?>'>
<br></h2>
        <fieldset>
     <h2><legend>Topics</legend>

    <?php
$checked = null;
    $stmt2 = $db->query('SELECT topicid, topicName FROM topics ORDER BY topicName');
    while($row2 = $stmt2->fetch()){

        $stmt3 = $db->prepare('SELECT topicid FROM topic_links WHERE topicid = :topicid AND articleid = :articleid') ;
        $stmt3->execute(array(':topicid' => $row2['topicid'], ':articleid' => $row['articleid']));
        $row3 = $stmt3->fetch(); 

        if(isset($row3['topicid']) == $row2['topicid']){
            $checked = 'checked=checked';
        } else {
            $checked = null;
        }

        echo "<input type='checkbox' name='topicid[]' value='".$row2['topicid']."' $checked> ".$row2['topicName']."<br />";
    }

    ?>
</h2>
</fieldset>

       
        <button name='submit' class="subbtn"> Update</button>

    </form>

</div>
  

<?php 
include("sidebar.php");  ?>

<?php include("footer.php");  ?>

 