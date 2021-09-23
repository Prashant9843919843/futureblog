<?php //include config
require_once('../includes/config.php');

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }
?>

<?php include("head.php");  ?>
    <title>Edit User- The Blog Site</title>
    <?php include("header.php");  ?>

<div class="content">
 
<h2>Edit User</h2>


    <?php

    //if form has been submitted process it
    if(isset($_POST['submit'])){

        //collect form data
        extract($_POST);

        //very basic validation
        if($username ==''){
            $error[] = 'Please enter the username.';
        }

        if( strlen($password) > 0){

            if($password ==''){
                $error[] = 'Please enter the password.';
            }

            if($passwordConfirm ==''){
                $error[] = 'Please confirm the password.';
            }

            if($password != $passwordConfirm){
                $error[] = 'Passwords do not match.';
            }

        }
        

        if($email ==''){
            $error[] = 'Please enter the email address.';
        }

        if(!isset($error)){

            try {

                if(isset($password)){

                    $hashedpassword = $user->create_hash($password);

                    //update into database
                    $stmt = $db->prepare('UPDATE users SET username = :username, password = :password, email = :email WHERE userid = :userid') ;
                    $stmt->execute(array(
                        ':username' => $username,
                        ':password' => $hashedpassword,
                        ':email' => $email,
                        ':userid' => $userid
                    ));


                } else {

                    //update database
                    $stmt = $db->prepare('UPDATE users SET username = :username, email = :email WHERE userid = :userid') ;
                    $stmt->execute(array(
                        ':username' => $username,
                        ':email' => $email,
                        ':userid' => $userid
                    ));

                }
                

                //redirect to users page
                header('Location: blog-users.php?action=updated');
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

            $stmt = $db->prepare('SELECT userid, username, email FROM users WHERE userid = :userid') ;
            $stmt->execute(array(':userid' => $_GET['id']));
            $row = $stmt->fetch(); 

        } catch(PDOException $e) {
            echo $e->getMessage();
        }

    ?>

    <form action="" method="post">
        <input type="hidden" name="userid" value="<?php echo $row['userid'];?>">

        <p><label>Username</label><br>
        <input type="text" name="username" value="<?php echo $row['username'];?>"></p>

        <p><label>Password (only to change)</label><br>
        <input type="password" name="password" value=""></p>

        <p><label>Confirm Password</label><br>
        <input type="password" name="passwordConfirm" value=""></p>

        <p><label>Email</label><br>
        <input type="text" name="email" value="<?php echo $row['email'];?>"></p>

        <p><input type="submit" name="submit" value="Update"></p>

    </form>

</div>

<?php 
include("sidebar.php");  ?>

<?php include("footer.php");  ?>