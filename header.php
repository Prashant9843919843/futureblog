
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
    <li><a href="<?php echo 'register.php' ?>">Sign Up</a></li>
        <li><a href="<?php echo 'login.php' ?>">Login</a></li>
        
</ul>
</header>