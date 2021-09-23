<?php //include connection file 
require_once('includes/config.php');


// Define variables and initialize with empty values
$fname = $lname = $email =$password ="";
$fname_err = $lname_err = $email_err = $password_err= "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_fname = trim($_POST["username"]);
    if(empty($input_fname)){
        $fname_err = "Please enter a username.";
    } else{
        $fname = $input_fname;
    }

       //dfs
    $input_password = trim($_POST["password"]);
    if(empty($input_password)){
        $password_err = "Please enter the password.";     
    } else{
        $password = $input_password;
    }
   

    // Close connection
    //mysqli_close($link);
}
?>


<?php include("head.php");  ?>
    <title>The Blog Site</title>
   
     <?php include("header.php");  ?>

<div class="content">
 

    <h2>Add User</h2>

    <?php

    //if form has been submitted process it
    if(isset($_POST['submit'])){

        //collect form data
        extract($_POST);

        //very basic validation
        if($username ==''){
            $error[] = 'Please enter the username.';
        }

        if($password ==''){
            $error[] = 'Please enter the password.';
        }

        if($passwordConfirm ==''){
            $error[] = 'Please confirm the password.';
        }

        if($password != $passwordConfirm){
            $error[] = 'Passwords do not match.';
        }

        if($email ==''){
            $error[] = 'Please enter the email address.';
        }

        if(!isset($error)){

            $hashedpassword = $user->create_hash($password);

            try {

                //insert into database
                $stmt = $db->prepare('INSERT INTO users (username,password,email) VALUES (:username, :password, :email)') ;
                $stmt->execute(array(
                    ':username' => $username,
                    ':password' => $hashedpassword,
                    ':email' => $email
                ));

                //redirect to user page 
                header('Location:pageindex.php?action=added');
                exit;

            } catch(PDOException $e) {
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

    <form action="index.php" method="post">

        <p><label>Username</label><br>
        <input type="text" name="username" value="<?php if(isset($error)){ echo $_POST['username'];}?>"></p>

        <p><label>Password</label><br>
        <input type="password" name="password" value="<?php if(isset($error)){ echo $_POST['password'];}?>"></p>

        <p><label>Confirm Password</label><br>
         <input type="password" name="passwordConfirm" value="<?php if(isset($error)){ echo $_POST['passwordConfirm'];}?>"></p>

        <p><label>Email</label><br>
        <input type="text" name="email" value="<?php if(isset($error)){ echo $_POST['email'];}?>"></p>
        
        <button name="submit" class="subbtn"> Add User</button>

    


</div>

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/dist/jquery.validate.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#loginForm').validate();
	});
</script>  
<?php include("footer.php");  ?>

