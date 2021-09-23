<?php
include_once 'includes/fileslogic.php';

// fetch files
$sql = "select filename from tbl_files";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload File ||The Blog Site </title>
    <link href="assets/style.css" rel="stylesheet" type="text/css">
    <meta content="width=device-width, initial-scale=1.0" name="viewport" >
    <style>
      body {
    margin: 0;
    font-family: "Lato", sans-serif;
  }
  h1{ 
  color:black;
 text-align: center;
    text-decoration: none;
   }
   .container{
        border: 3px solid blue;
        background-color: blanchedalmond;
       padding-top: 10px;
       padding-left: 640px;
       
           }
          .btn-info{
            background: blue;
            color: white;
            
                    }
                   
          .btn-info:hover{
            color: white;
            background: green;
          }
    </style>
</head>
<body>
<header>

<a href="pageindex.php" class="logo">
      <h1 class="logo-text">The<span>Blog</span>Site</h1>
    </a>
    <i class="fa fa-bars menu-toggle"></i>
    <ul class="nav">
    <li><a href="pageindex.php">Home</a></li>
     
    
            <?php
$baseUrl="http://localhost/next/pageindex/"; 
            ?>
  <li><a href='logout.php'><font color="red">Logout</font></a></li>
        
</ul>
</header>
  <h1>Send your Blog Files Here</h1>
 <br/>
<div class="container">
    <div class="row">
        <div class="col-xs-8 col-xs-offset-2 well">
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <legend>Select File to Upload:</legend>
            <div class="form-group">
                <input type="file" name="file1" />
            </div>
            <div class="form-group">
                <input type="submit" name="submit" value="Upload" class="btn btn-info"/>
            </div>
            <?php if(isset($_GET['st'])) { ?>
                <div class="alert alert-danger text-center">
                <?php if ($_GET['st'] == 'success') {
                        echo "File Uploaded Successfully!.";
                    }
                    else
                    {
                        echo 'Invalid File Extension!';
                    } ?>
                </div>
            <?php } ?>
        </form>
        </div>
    </div>
    
    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $i = 1;
                while($row = mysqli_fetch_array($result)) { ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo $row['filename']; ?></td>
                    <td><a href="uploads/<?php echo $row['filename']; ?>" target="_blank">View</a></td>
                    <td><a href="uploads/<?php echo $row['filename']; ?>" download>Download</td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>