<?php
//currently not using any of this
$servername = 'localhost';
$username = 'root';
$password = 'root';
$dbname = 'cityguide';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


$value1 = $_POST['name'];
$value2 = $_POST['rating'];
$value3 = $_POST['comment'];

$sql = "INSERT INTO food (name, rating, comment)
VALUES ('$value1', '$value2', '$value3')";

if ($conn->query($sql) === TRUE) {
    echo "success!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>