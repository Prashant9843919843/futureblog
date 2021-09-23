<?php require_once('../includes/config.php'); 

if(!$user->is_logged_in()){ header('Location: login.php'); }
?>

<?php include("head.php");  ?>
<!-- On page head area--> 
  <title>Add New Article - The Blog Site</title>
   <!-- <script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script> -->
  <!-- TEXT EDITOR API FOR FUTURE USEONLY!!!!!!!!!!!!!!!!!!!!!!!
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

  <?php include("header.php"); 

   ?>

<div class="content">
 
    <h1>Add New Article</h1>

    <?php

    //if form has been submitted process it
    if(isset($_POST['submit'])){

 

        //collect form data
        extract($_POST);

        //very basic validations
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


            $articleSlug = slug($articleTitle);
    //insert into database
   $stmt = $db->prepare('INSERT INTO blogs (articleTitle,articleSlug,articleDescription,articleContent,articleDate,articleTags)
    VALUES (:articleTitle, :articleSlug, :articleDescription, :articleContent, :articleDate, :articleTags)') ;
  



$stmt->execute(array(
    ':articleTitle' => $articleTitle,
    ':articleSlug' => $articleSlug,
    ':articleDescription' => $articleDescription,
    ':articleContent' => $articleContent,
    ':articleDate' => date('Y-m-d H:i:s'),
    ':articleTags' => $articleTags,
    
));
//add categories
 
 
$articleid = $db->lastInsertId();
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
    header('Location: index.php?action=added');
    exit;

}catch(PDOException $e) {
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

        <h2><label>Article Title</label><br>
        <input type="text" name="articleTitle" style="width:100%;height:40px" value="<?php if(isset($error)){ echo $_POST['articleTitle'];}?>"></h2>

        <h2><label>Short Description(Meta Description) </label><br>
        <textarea name="articleDescription" cols="120" rows="6"><?php if(isset($error)){ echo $_POST['articleDescription'];}?></textarea></h2>
        <h2><label>Long Description(Body Content)</label><br>
        <textarea name="articleContent" id="textarea1" class="mceEditor" cols="120" rows='20'><?php if(isset($error)){ echo $_POST['articleContent'];}?></textarea></h2>
        
        <h2><label>Articles Tags (Separated by comma without space)</label><br>
<input type='text' name='articleTags' value='<?php if(isset($error)){ echo $_POST['articleTags'];}?>' style="width:100%;height:40px"></h2>
 
        <fieldset>
    <h2><legend>Topics</legend>

    <?php    
$checked = null;
    $stmt2 = $db->query('SELECT topicid, topicName FROM topics ORDER BY topicName');

    while($row2 = $stmt2->fetch()){

        if(isset($_POST['topicid'])){

            if(in_array($row2['topicid'], $_POST['topicid'])){
               $checked="checked='checked'";
            }else{
               

            }
        }

 echo "<input type='checkbox' name='topicid[]' value='".$row2['topicid']."' $checked> ".$row2['topicName']."<br />";
    }

    ?>
</h2>
</fieldset>
       
        <button name="submit" class="subbtn">Submit</button>


    </form>



</div>
<?php 
include("sidebar.php");  ?>

<?php include("footer.php");  ?>

 