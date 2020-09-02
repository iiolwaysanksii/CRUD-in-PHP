<?php
session_start();
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=misc','fred', 'zap');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ( ! isset($_SESSION['email']) || strlen($_SESSION['email']) < 1  ) {
    die('ACCESS DENIED');
}

if ( isset($_POST['save']) && isset($_POST['autos_id']) ) {

    // Data validation
    if ((strlen($_POST['make'])<1) or (strlen($_POST['year'])<1) or (strlen($_POST['model'])<1) or (strlen($_POST['mileage'])<1)) {
        $_SESSION['error'] = 'Missing data';
        header("Location: edit.php?autos_id=".$_POST['autos_id']);
        return;
    }

    else if(is_numeric($_POST['year'])==false) {
        $_SESSION['error']='Year must be an integer';
        header("Location: edit.php?autos_id=".$_POST['autos_id']);
        return;
    }

    else if(is_numeric($_POST['mileage'])==false){
        $_SESSION['error']='Mileage must be an integer';
        header("Location: edit.php?autos_id=".$_POST['autos_id']);
        return;
    }

    $sql = "UPDATE autos SET make = :make,
            year = :year, model = :model,
            mileage = :mileage
            WHERE autos_id = :autos_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':make' => $_POST['make'],
        ':year' => $_POST['year'],
        ':mileage' => $_POST['mileage'],
        ':model' => $_POST['model'],
        ':autos_id' => $_POST['autos_id']));
    $_SESSION['success'] = 'Record updated';
    header( 'Location: index.php' ) ;
    return;
}

// Guardian: Make sure that user_id is present
if ( !isset($_GET['autos_id']) ) {
  $_SESSION['error'] = "Missing autos_id";
  header('Location: index.php');
  return;
}

$stmt = $pdo->prepare("SELECT * FROM autos where autos_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for autos_id';
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

<p>Edit User</p>

<form method="post">

<p>Make:<input type="text" name="make" size="40" value="<?= $row['make'] ?>" /></p>
<p>Model:<input type="text" name="model" size="40" value="<?= $row['model'] ?>" /></p>
<p>Year:<input type="text" name="year" size="10" value="<?= $row['year'] ?>" /></p>
<p>Mileage:<input type="text" name="mileage" size="10" value="<?= $row['mileage'] ?>" /></p>

<input type="hidden" name="autos_id" value="<?= $row['autos_id'] ?>">

<p><input type="submit" name="save" value="Save"/>
<a href="index.php">Cancel</a></p>

</form>
</body>
</html>