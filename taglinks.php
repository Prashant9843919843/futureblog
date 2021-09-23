
<?php require('includes/config.php'); ?>

<?php include("head.php");  ?>

    <title><?php echo htmlspecialchars($_GET['id']);?>-The Blog Site</title>
    <?php include("header.php");  ?>
<div class="content">


    <p>Articles in tag:- <?php echo htmlspecialchars($_GET['id']);?></p>
        <hr>
       

        <?php   
            try {

                $stmt = $db->prepare('SELECT articleid, articleTitle, articleSlug, articleDescription, articleDate, articleTags FROM blogs WHERE articleTags like :articleTags ORDER BY articleid DESC');
                $stmt->execute(array(':articleTags' => '%'.$_GET['id'].'%'));
                while($row = $stmt->fetch()){
                    
                    echo '<div>';
                        echo '<h1><a href="../'.$row['articleSlug'].'">'.$row['articleTitle'].'</a></h1>';
                        echo '<p>Posted on '.date('jS M Y H:i:s', strtotime($row['articleDate'])).' in ';

                            $stmt2 = $db->prepare('SELECT topicName, topicSlug FROM topics, topic_links WHERE topics.topicid = topic_links.topicid AND topic_links.articleid = :articleid');
                            $stmt2->execute(array(':articleid' => $row['articleid']));

                            $catRow = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                            $links = array();
                            foreach ($catRow as $cat)
                            {
                                $links[] = "<a href='../topics/".$cat['topicSlug']."'>".$cat['topicName']."</a>";
                            }
                            echo implode(", ", $links);

                        echo '</p>';
                    echo '<p>Tagged as: ';
                    $links = array();
                    $parts = explode(',', $row['articleTags']);
                    foreach ($parts as $tags)
                    {
                      $links[] = "<a href='".$tags."'>".$tags."</a>";
                    }
                    echo implode(", ", $links);
                    echo '</p>';
                        echo '<p>'.$row['articleDescription'].'</p>';               
                        echo '<p><button class="readbtn"><a href="../'.$row['articleSlug'].'">Read More</a></button></p>'; 


                    echo '</div>';

                }

            } catch(PDOException $e) {
                echo $e->getMessage();
            }

            ?>
</div>
<?php include("sidebar.php");  ?>

<?php include("footer.php");  ?>