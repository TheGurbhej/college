
<?php

$servername = "localhost";
$user = "root";
$pass = "";
$dbname = "college";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   // echo "Done";
} catch (PDOException $err) {
 //   echo "Connection failed: " . $err->getMessage();
}

?>
