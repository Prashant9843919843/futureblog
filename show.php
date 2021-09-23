<?php require('includes/config.php'); 

$stmt = $db->prepare('SELECT articleid,articleDescription, articleSlug, articleTitle, articleContent, articleDate, articleTags FROM blogs WHERE articleSlug = :articleSlug');
$stmt->execute(array(':articleSlug' => $_GET['id']));
$row = $stmt->fetch();

//if post does not exists redirect user.
if($row['articleid'] == ''){
    header('Location: ./');
    exit;
}
?>

<?php include("head.php");  ?>

    <title><?php echo $row['articleTitle'];?>-The Blog Site</title>
  <meta name="description" content="<?php echo $row['articleDescription'];?>">    
<meta name="keywords" content="Article Keywords">

<?php include("header.php");  ?>
<div class="container">
<div class="content">


<?php
            echo '<div>';
                echo '<h1>'.$row['articleTitle'].'</h1>';

                echo '<p>Posted on '.date('jS M Y H:i:s', strtotime($row['articleDate'])).' under the topic:';

                $stmt2 = $db->prepare('SELECT topicName, topicSlug   FROM topics, topic_links WHERE topics.topicid = topic_links.topicid AND topic_links.articleid = :articleid');
                $stmt2->execute(array(':articleid' => $row['articleid']));
                
                $catRow = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                $links = array();
                foreach ($catRow as $cat){
                     $links[] = "<a href='topics/".$cat['topicSlug']."'>".$cat['topicName']."</a>";
                }
                echo implode(", ", $links);
                
                echo '</p>';
                  echo '<hr>';
                
                echo '<p>'.$row['articleContent'].'</p>';    
                echo '<p>Tagged as: ';
                $links = array();
                $parts = explode(',', $row['articleTags']);
                foreach ($parts as $tags)
                {
                 $links[] = "<a href='".$tags."'>".$tags."</a>";
                }
                echo implode(", ", $links);
                echo '</p>';
            echo '</div>';
        ?>
          </div>
   <?php //sidebar content 
include("sidebar.php");  ?>

     </div>

 <!--comment logic-->
<?php
if(isset($_POST['submit'])){
	$err=[];
	//check name
	if(isset($_POST['name']) && !empty($_POST['name']) && trim($_POST['name'])){
		$name= $_POST['name'];
	}else{
		$err['name'] = 'Enter your name';
	}
		if (isset($_POST['message']) && !empty($_POST['message']) && trim($_POST['message'])){
		$message = $_POST['message'];
	}else{
		$err['message'] = 'Enter your comment';
	}
	if (count($err) == 0) {
		 $stmt = $db->prepare('INSERT INTO comments (name, message)VALUES(:name, :message)');
         $stmt -> execute(array(
            ':name' => $name,
            ':message' => $message,
         ));
		
			}


}

    $stmt = $db->query('SELECT comment_id, name, message FROM comments ORDER BY comment_id DESC');
    while($row = $stmt->fetch()){
        
        echo '<tr>';
        echo '<td>'.'name:'.$row['name'].'<br>'.'</td>';
        echo '<td>'.'comment:'.$row['message'].'<br>'.'</td>';
        ?>

              
        <?php 
        echo '</tr>';

    }

?>
	
     <div>
      <h1>COMMENTS</h1>
<script src="comments.js"></script>
<div id="cwrap"></div>
<link href="comments.css" rel="stylesheet">

<!-- (D) ADD NEW COMMENT -->
<form id="cadd" onsubmit="return comments.add(this)" method="POST" name="form">
  <h3>Leave a reply</h3>
  <input type="text" id="name" name="name" placeholder="Name" required/>
  <textarea id="message" name="message" placeholder="Message" required></textarea>
  <input type="submit" value="Post Comment" name="submit" class="btn"/>
</form>

</div>
   
    	</div>
<?php include("footer.php");  ?> 

<!--  CREATE TABLE comments( id int(11), userid int(30), articleid int(30), body TEXT, created_at TIMESTAMP, updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, FOREIGN KEY (userid) REFERENCES users(userid), FOREIGN KEY (articleid) REFERENCES blogs(articleid) )-->