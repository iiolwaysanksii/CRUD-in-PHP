<?php
session_start();
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=misc','fred', 'zap');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ( ! isset($_SESSION['email']) || strlen($_SESSION['email']) < 1  ) {
    die('ACCESS DENIED');
}

else if(isset($_POST['cancel'])){
    header("Location:index.php");
    return;
}

else if(isset($_POST['add'])) {
    
    if( ( strlen($_POST['make'])<1) or (strlen($_POST['year'])<1) or (strlen($_POST['model'])<1) or (strlen($_POST['mileage'])<1) ) {
        $_SESSION['error'] = "All fields are required";
        header("Location: add.php");
        return;
    }

    else if(is_numeric($_POST['year'])==false) {
        $_SESSION['error']='Year must be an integer';
        header("Location:add.php");
        return;
    }

    else if(is_numeric($_POST['mileage'])==false){
        $_SESSION['error']='Mileage must be an integer';
        header("Location:add.php");
        return;
    }

    $sql = "INSERT INTO autos (make, model, year, mileage)
              VALUES (:make, :model, :year, :mileage)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':make' => $_POST['make'],
        ':model' => $_POST['model'],
        ':year' => $_POST['year'],
        ':mileage' => $_POST['mileage']));
    
    $_SESSION['success'] = 'Record Added';
    header( 'Location: index.php' ) ;
    return;
}

// Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ankit</title>
</head>
<body>
<h1>Tracking Automobiles for: 
<?php 
echo $_SESSION['email']."</h1>";
?>
<form method="post">
<p>Make:
<input type="text" name="make" size="40"/></p>
<p>Model:
<input type="text" name="model" size="40"/></p>
<p>Year:
<input type="text" name="year" size="10"/></p>
<p>Mileage:
<input type="text" name="mileage" size="10"/></p>

<input type="submit" name='add' value="Add">
<input type="submit" name="cancel" value="Cancel">
</form>
<p>
</form>
</body>
</html>

