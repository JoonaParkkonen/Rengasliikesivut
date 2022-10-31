<?php
$conn = mysqli_connect("localhost","root","");
 
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
// sql query with CREATE DATABASE
$sql = "CREATE DATABASE IF NOT EXISTS `rengasliikekanta` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";

// Performs the $sql query on the server to create the database
if ($conn->query($sql) === TRUE) {
  echo 'Database "rengasliikekanta" successfully created.';
  include('createtables.php');
}
else {
 echo 'Error: '. $conn->error;
 mysqli_close($conn);
}
?>