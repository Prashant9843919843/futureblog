<?php require('includes/config.php'); 

$stmt = $db->prepare('SELECT pageId,pageTitle,pageSlug,pageContent,pageDescrip,pageKeywords FROM pages WHERE pageSlug = :pageSlug');
$stmt->execute(array(':pageSlug' => $_GET['pageId']));
$row = $stmt->fetch();

//if post does not exists redirect user.
if($row['pageId'] == ''){
    header('Location: ./');
    exit;
}


?>
<!--header-->
<link href="http://localhost/next/assets/style.css" rel="stylesheet" type="text/css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
</head>
<body>
    <header>

<a href="index.php" class="logo">
      <h1 class="logo-text">The<span>Blog</span>Site</h1>
    </a>
    <i class="fa fa-bars menu-toggle"></i>
    <ul class="nav">
      <li><a href="index.php">Home</a></li>
      <li><a href="about.php">About</a></li>
      <?php
$baseUrl="http://localhost/next/page/"; 
        try {

            $stmt = $db->query('SELECT pageTitle,pageSlug FROM pages ORDER BY pageId ASC');
            while($rowlink = $stmt->fetch()){
                
                echo '<li><a href="'.$baseUrl.''.$rowlink['pageSlug'].'">'.$rowlink['pageTitle'].'</a></li>';
            }

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    ?>
    <li><a href='logout.php'><font color="red">Logout</font></a></li>
        
</ul>
</header>
<!--header-->

  <title><?php echo $row['pageTitle'];?></title>
  <meta name="description" content="<?php echo $row['pageDescrip'];?>">    
<meta name="keywords" content="<?php echo $row['pageKeywords'];?>">

  <?php include("header.php");  ?>
<div class="content">
 
<?php
echo '<h1>'.$row['pageTitle'].'</h1>';
?>
<hr> 
<?php 
echo '<p>'.$row['pageContent'].'</p>';
       
?>
</div>
<div id="disqus_thread"></div>

<?php include("sidebar.php");  ?>

<?php include("footer.php");  ?>
 