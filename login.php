<?php 
//Your connection file 
require_once('includes/config.php');


// user looged in or not 
if( $user->is_logged_in() ){ header('Location: login.php'); } 
?>
<!DOCTYPE html>
<head>
  <meta charset="utf-8">
  <title>User Login</title>
  <link rel="stylesheet" href="admin/assets/style.css">
 <style>
form{
    align-items: center;
}
 </style>
</head>
<body>

<div id="login">

<?php 

   //Login form for submit 
    if(isset($_POST['submit'])){

        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        
        if($user->login($username,$password)){ 

            //If looged in , the redirects to index page 
            header('Location: pageindex.php');
            exit;
        

        } else {
            $message = '<p class="invalid">Invalid username or Password</p>';
        }

    }

    if(isset($message)){ echo $message; }
?>

    <form action="login.php" method="POST" class="form">
        <label>Username</label>
   <input type="text" id="username" name="username" value="" placeholder="Please enter username"  />
<br>
 <label>Password</label>
 <input type="password" id="password" name="password" value="" placeholder="Please enter password"  />
<br>
    <label></label><input type="submit" name="submit" value="Login"  />

    <script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/dist/jquery.validate.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#loginForm").validate({
			rules: {
				username: "required",				
				password: {
					required: true,
					password: true
				}
			},
			messages: {
				username: "Please enter your name",
				password: {
					required: "Please enter password address",
					password: "Enter valid password",
				}
			}
		});
	});
</script>  

</div>
</body>
</html>
