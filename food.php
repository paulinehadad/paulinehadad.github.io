<!DOCTYPE html>
<html>
<html lang="en">
  <head> 

    <meta charset="UTF-8">
    <meta name="city-guide" content="Personal City Guide">
    <meta name="keywords" content="guide,new york,food">
    <title>Food</title>
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Shadows+Into+Light+Two" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

  </head> 
  <body>

    <h1>Where should I eat?</h1>

    <div id="container" class="container">
    
      <ul id="scene" class="scene border fill">
        <li class="layer expand-width" data-depth="1.00"><button><a href="about.html">About</button></li>
        <li class="layer expand-width" data-depth="0.80"><button><a href="events.html">Events</button></li>
        <li class="layer expand-width" data-depth="0.60"><button><a href="bar.html">NightLife</button></li>
        <li class="layer expand-width" data-depth="0.40"><button><a href="#"></button></li>
        <li class="layer expand-width" data-depth="0.20"><button><a href="#"></button></li>
        <li class="layer expand-width" data-depth="0.00"><button><a href="index.html">Home</a></button></li>
      </ul>
    
    </div>
    
    <div id="target"></div> <!-- Instagram pictures here -->


    <!-- Scripts -->
    <script src="scripts/parallax.js"></script>

    <script>

    var scene = document.getElementById('scene');
    var parallax = new Parallax(scene);

    </script>
<script src="scripts/insta.js"></script>
   
     <form method="post" action="food.html" enctype="multipart/form-data" >
            Name: <input type="text" name="name"><br>
            Rating: <input type="text" name="rating"><br>
            Comment:<br><textarea rows="5" name="comment" cols="30"></textarea><br>
            <input type="submit" name="submit" value="Submit">
        </form>

        <?php

// DB connection info
$host = "localhost";
$user = "root";
$pwd = "root";
$db = "cityguide";
// Connect to database.

// Create connection
$conn = new mysqli($host, $user, $pwd, $db);
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

$sql_select = "SELECT * FROM food";
$stmt = $conn->query($sql_select);
$entries = $stmt->fetchAll(); 
if(count($entries) > 0) {
    echo "<h2>Entries:</h2>";
    echo "<table>";
    echo "<tr><th>Name</th>";
    echo "<th>Rating</th>";
    echo "<th>Comment</th></tr>";
    foreach($entries as $entry) {
        echo "<tr><td>".$entry['name']."</td>";
        echo "<td>".$entry['rating']."</td>";
        echo "<td>".$entry['comment']."</td></tr>";
    }
    echo "</table>";
} else {
    echo "<h3>There is currently no entry.</h3>";
}

        ?>

  </body>

</html> 
