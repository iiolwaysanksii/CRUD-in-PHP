<?php
session_start();

$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';

if ( isset($_POST['email']) && isset($_POST['pass']) ) {
    
    if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 ) {
        $_SESSION['error'] = "User name and password are required";
        header("Location:login.php");
        return;
    }
    
    else if(strpos($_POST['email'],'@')==false){
        $_SESSION['error'] = "Email must have an at-sign (@)";
        header("Location:login.php");
        return;
    } 
    else {
        $check = hash('md5', $salt.$_POST['pass']);
       
        if ( $check == $stored_hash ) {
            $_SESSION['email']= $_POST['email'];
            header("Location: index.php");
            return;
        } 

        else {
            $_SESSION['error'] = "Incorrect password";
            header("Location:login.php");
            return;
        }
    }
}

?>
<!DOCTYPE html>
<html>
<head>
<?php require_once "bootstrap.php"; ?>
<title>Ankit's Login Page</title>
</head>
<body>
<div class="container">
<h1>Please Log In</h1>
<?php
if ( isset($_SESSION['error']) ) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
}
?>
<form method="POST">
<label for="nam">User Name</label>
<input type="text" name="email"><br/>
<label for="id_1723">Password</label>
<input type="text" name="pass"><br/>
<input type="submit" value="Log In">
<a href="index.php">Cancel</a>
</form>
<p>
For a password hint, view source and find a password hint
in the HTML comments.
<!-- Hint: php123. -->
</p>
</div>
</body>
</html>
