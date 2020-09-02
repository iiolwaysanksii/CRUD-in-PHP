<?php
session_start();
	$pdo = new PDO('mysql:host=localhost;port=3306;dbname=misc','fred', 'zap');
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
<html>
<head>
<title>Ankit</title>

</head>
<body>
<?php
if( isset($_SESSION['email'])){

	if ( isset($_SESSION['error']) ) {
    	echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    	unset($_SESSION['error']);
	}	
	if ( isset($_SESSION['success']) ) {
    	echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
    	unset($_SESSION['success']);
	}

	echo "<h2>Welcome to autos Database</h2><br>";

	$stmt = $pdo->query("SELECT autos_id,make,model,year,mileage FROM autos");
	if($stmt->fetch(PDO::FETCH_ASSOC) <1 ){
		echo "No rows found<br><br>";
	}
	else{	
		
		$rows = $pdo->query("SELECT autos_id,make,model,year,mileage FROM autos");
		$rows->setFetchMode(PDO::FETCH_ASSOC);

		echo('<table border="1">'."\n");
		foreach($rows as $row) {
    		echo "<tr><td>";
    		echo(htmlentities($row['make']));
   		 	echo("</td><td>");
    		echo(htmlentities($row['model']));
    		echo("</td><td>");
    		echo(htmlentities($row['year']));
    		echo("</td><td>");
    		echo(htmlentities($row['mileage']));
    		echo("</td><td>");
    		echo('<a href="edit.php?autos_id='.$row['autos_id'].'">Edit</a> / ');
    		echo('<a href="delete.php?autos_id='.$row['autos_id'].'">Delete</a>');
    		echo("</td></tr>\n");
		}
		echo("</table><br><br>");

	}
	echo('<a href="add.php">Add New Entry</a><br>');
	echo('<br><a href="logout.php">Logout</a>');
} 
	else{
		?>
		<h2>Welcome to the Automobiles Database</h2>
		<p><a href="login.php">Please log in</a></p>
		<p>Attempt to <a href="add.php">add data</a> without logging in it should fail.</p>
		<p>Attempt to <a href="edit.php">edit data</a> without logging in it should fail.</p>

		<?php
	}
?>
</body>
</html>
