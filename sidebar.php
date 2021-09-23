<div class="sidebar">
	<h2>Recent Articles</h2>
    <?php
$sidebar = $db->query('SELECT articleTitle, articleSlug FROM blogs ORDER BY articleid DESC LIMIT 6');
while($row = $sidebar->fetch()){
    echo ' <a href="http://localhost/next/'.$row['articleSlug'].'" >'.$row['articleTitle'].' </a >';
}
?>    

<h2>Topics</h2>

<?php
$stmt = $db->query('SELECT topicName, topicSlug FROM topics ORDER BY topicid DESC');
while($row = $stmt->fetch()){
    echo '<a href="http://localhost/next/topics/'.$row['topicSlug'].'">'.$row['topicName'].'</a>';
}
?>
 


</div>