<?php require_once('../includes/config.php'); 

if(!$user->is_logged_in()){ header('Location: login.php'); }
?>

<?php include("head.php");  ?>
<!-- On page head area--> 
  <title>Add New Page - The Blog Site</title>
   <!-- ------------------text editor API FOR FUTURE USE ONLY--------------------
    <script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
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
        if($pageTitle ==''){
            $error[] = 'Please enter the Page title.';
        }

        if($pageDescription ==''){
            $error[] = 'Please enter the Page description.';
        }

        if($pageContent ==''){
            $error[] = 'Please enter the content.';
        }
         if($pageKeywords ==''){
            $error[] = 'Please enter the Page Keywords.';
        }

        if(!isset($error)){

          try {

    $pageSlug = slug($pageTitle);

    //insert into database
   $stmt = $db->prepare('INSERT INTO pages (pageTitle,pageSlug,pageDescrip,pageContent,pageKeywords) VALUES (:pageTitle, :pageSlug, :pageDescrip, :pageContent,:pageKeywords)') ;
  



$stmt->execute(array(
    ':pageTitle' => $pageTitle,
    ':pageSlug' => $pageSlug,
    ':pageDescrip' => $pageDescrip,
    ':pageContent' => $pageContent,
    ':pageKeywords' => $pageKeywords
));



    //redirect to index page
    header('Location: blog-pages.php?action=added');
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
 <form action='' method='post'>

        <h2><label>Page Title</label><br>
        <input type='text' name='pageTitle' style="width:100%;height:40px" value='<?php if(isset($error)){ echo $_POST['pageTitle'];}?>'></h2>

        <h2><label>Short Description(Meta Description) </label><br>
        <textarea name='pageDescrip' cols='120' rows='6'><?php if(isset($error)){ echo $_POST['pageDescrip'];}?></textarea></h2>

        <h2><label>Long Description(Body Content)</label><br>
        <textarea name='pageContent' id='textarea1' class='mceEditor' cols='120' rows='20'><?php if(isset($error)){ echo $_POST['pageContent'];}?></textarea></h2>
        
<h2><label>Page Keywords (Seprated by comma without space)</label><br>
<input type='text' name='pageKeywords' value='<?php if(isset($error)){ echo $_POST['pageKeywords'];}?>' style="width:100%;height:40px"></h2>

        <p><input type='submit' class="editbtn" name='submit' value='Submit'></p>

    </form>
</div>
  <?php include("sidebar.php");  ?>

<?php include("footer.php");  ?>

