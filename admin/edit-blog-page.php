<?php require_once('../includes/config.php'); 
if(!$user->is_logged_in()){ header('Location: login.php'); }
?>
<?php include("head.php");  ?>
    <title>Update Page - The Blog Site</title>
    <!-- -------------------------for future use only -------------------
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
    <?php include("header.php");  ?>

<div class="content">
 
<h2>Edit Post</h2>


    <?php

   
    if(isset($_POST['submit'])){


        //collect form data
        extract($_POST);

        //very basic validation
        if($pageId ==''){
            $error[] = 'Invalid ID .';
        }

        if($pageTitle ==''){
            $error[] = 'Please enter the Page title.';
        }

        if($pageDescrip ==''){
            $error[] = 'Please enter the Page description.';
        }

        if($pageContent ==''){
            $error[] = 'Please enter the content.';
        }
          
        if($pageKeywords ==''){
            $error[] = 'Please enter the Article Keywords.';
        }



        if(!isset($error)){
try {

   
 $pageSlug = slug($pageTitle);
    //insert into database
    $stmt = $db->prepare('UPDATE pages SET pageTitle = :pageTitle, pageSlug = :pageSlug, pageDescrip = :pageDescrip, pageContent = :pageContent, pageKeywords = :pageKeywords WHERE pageId = :pageId') ;
$stmt->execute(array(
    ':pageTitle' => $pageTitle,
    ':pageSlug' => $pageSlug,
    ':pageDescrip' => $pageDescrip,
    ':pageContent' => $pageContent,
    ':pageId' => $pageId,
    ':pageKeywords' => $pageKeywords
));

    //redirect to index page
    header('Location: blog-pages.php?action=updated');
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

           $stmt = $db->prepare('SELECT pageId, pageSlug,pageTitle, pageDescrip, pageContent, pageKeywords FROM pages WHERE pageId = :pageId') ;
            $stmt->execute(array(':pageId' => $_GET['pageId']));
            $row = $stmt->fetch(); 

        } catch(PDOException $e) {
            echo $e->getMessage();
        }

    ?>

    <form action='' method='post'>
        <input type='hidden' name='pageId' value='<?php echo $row['pageId'];?>'>

           <h2><label>Page Title</label><br>
        <input type='text' name='pageTitle' style="width:100%;height:40px" value='<?php echo $row['pageTitle'];?>'></h2>
        


       <h2><label>Short Description(Meta Description) </label><br>
        <textarea name='pageDescrip' cols='120' rows='6'><?php echo $row['pageDescrip'];?></textarea></h2>

       <h2><label>Long Description(Body Content)</label><br>
        <textarea name='pageContent' id='textarea1' class='mceEditor' cols='120' rows='20'><?php echo $row['pageContent'];?></textarea></h2>
      
<h2><label>Page Keywords (Seprated by comma without space)</label><br>
<input type='text' name='pageKeywords' style="width:100%;height:40px;"value='<?php echo $row['pageKeywords'];?>' 
<br></h2>

        <input type='submit' class="editbtn" name='submit' value='Update'>

    </form>

</div>
  <?php include("sidebar.php");  ?>



<?php include("footer.php");  ?>
 