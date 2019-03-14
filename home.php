<?php
ob_start();
session_start();
require_once 'dbconnect.php';

// if session is not set this will redirect to login page
if( !isset($_SESSION['user']) ) {
 header("Location: index.php");
 exit;
}
// select logged-in users details
$res=mysqli_query($conn, "SELECT * FROM users WHERE userId=".$_SESSION['user']);
$userRow=mysqli_fetch_array($res, MYSQLI_ASSOC);


if(isset($_GET["id"])){
	$id = $_GET["id"];
	$fk_user = $_SESSION["user"];

	echo "<form method='post'><input type='date' name='td'><input type='date' name='bd'><input type='submit' name='submitbook'> </form>";

	if(isset($_POST["submitbook"])){
		$takedate= $_POST["td"];
		$backdate= $_POST["bd"];

		$sql = "insert into booking (TakeDate ,	BackDate 	,CarId 	,userId) values ('$takedate','$backdate',$id,$fk_user)";
		mysqli_query($conn,$sql);
	}


}

?>
<!DOCTYPE html>
<html>
<head>
<title>Welcome - <?php echo $userRow['userEmail']; ?></title>
<!-- Latest compiled and minified CSS -->
<script
  src="http://code.jquery.com/jquery-3.3.1.js"
  integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
  crossorigin="anonymous"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<style>
	.btn{
		position: absolute;
		left: 90%;
		transform: translateY(-10%);
	}
	a.alert-link{
		text-align: center;
	}

</style>
</head>
<body>
	<div class="alert alert-info" role="alert">
  <a href="#" class="alert-link"> Welcome <?php echo $userRow['userName'] ." to our Booking-Page!";?></a>
   <a href="logout.php?logout"><button type="" class="btn btn-danger">Sign Out</button></a>
 
</div>

<div class="container">
  <h2>Select Car</h2>
  <form>
    <div class="form-group">
      <label for="sel1">Select a Model:</label>
        <table>
        <?php
        $sql = "SELECT Model, Type,CarId FROM car";
		$result = $conn->query($sql);
			if ($result->num_rows > 0) {
	   		 while($row = $result->fetch_assoc()) {
	   		 echo "<tr><td>".$row['Model']." ".$row['Type']."</td><td><a href='home.php?id=".$row['CarId']."'>Book me</a></td></tr>";
	   		 }
		}
		?>
		</table>
	 
      <br>
      <button type="">Check Availability</button>
    </div>
  </form>
</div>
      
 
</body>
</html>
<?php ob_end_flush(); ?>