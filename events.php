<!DOCTYPE html>
<html lang="en">
  
  <head> 
    <meta charset="UTF-8">
    <meta name="city-guide" content="Personal City Guide">
    <meta name="keywords" content="guide,new york,events">
    <title>Events</title>
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Shadows+Into+Light+Two" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
  </head> 

  <body>

    <!-- Navigation Bar -->
    <div id="container" class="container">
      <ul id="scene" class="scene border fill">
        <li class="layer expand-width" data-depth="1.00"><button><a href="about.html">About</button></li>
        <li class="layer expand-width" data-depth="0.80"><button><a href="food.php">Restaurants</button></li>
        <li class="layer expand-width" data-depth="0.60"><button><a href="bar.php">NightLife</button></li>
        <li class="layer expand-width" data-depth="0.40"><button><a href="#"></button></li>
        <li class="layer expand-width" data-depth="0.20"><button><a href="#"></button></li>
        <li class="layer expand-width" data-depth="0.00"><button><a href="index.html">Home</a></button></li>
      </ul>
    </div>

    <!-- Scripts -->
    <script src="scripts/parallax.js"></script>

    <script>
    var scene = document.getElementById('scene');
    var parallax = new Parallax(scene);
    </script>

    <h1>What should I do today?</h1>
    
    <script src="scripts/instaEvent.js"></script>
    <div id="target"></div> <!-- Instagram pictures here -->

    <?php

      // // DB connection info a-server
      $host = "localhost";
      $user = "hadap176";
      $pwd = "qRznml12=";
      $db = "hadap176";

      // DB connection info computer
      // $host = "localhost";
      // $user = "root";
      // $pwd = "root";
      // $db = "cityguide";

      // Create connection
      $conn = new mysqli($host, $user, $pwd, $db);
      // Check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      } 

      mysql_real_escape_string($name);
      mysql_real_escape_string($rating);
      mysql_real_escape_string($comment);

      $value1 = $_POST['name'];
      $value2 = $_POST['rating'];
      $value3 = $_POST['comment'];

      $sql = "INSERT INTO events (name, rating, comment)
      VALUES ('$value1', '$value2', '$value3')";

      if ($conn->query($sql) === TRUE) {
        //echo "success!";
      } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }

      // define variables and set to empty values
      $nameErr = $ratingErr = "";
      $value1 = $value2 = $value3 = "";

      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["name"])) {
          $nameErr = "Name is required";
        } else {
            $value1 = test_input($_POST["name"]);
           // check if name only contains letters and whitespace
        }
        if (empty($_POST["rating"])) {
           $ratingErr = "Rating is required";
         } else {
           $value2 = test_input($_POST["rating"]);
         }
       
         if (empty($_POST["comment"])) {
           $comment = "";
         } else {
           $value3 = test_input($_POST["comment"]);
         }
      }

      function test_input($data) {
         $data = trim($data);
         $data = stripslashes($data);
         $data = htmlspecialchars($data);
         return $data;
      }

    ?>

    <div class="formclass">

      <p><span class="error">* required field.</span></p>
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
         Name: <input type="text" name="name" value="<?php echo $value1;?>">
        <span class="error">* <?php echo $nameErr;?></span>
        <br><br>
        Rating:
          <input type="radio" name="rating" <?php if (isset($value2) && $value2=="Very good!") echo "checked";?>  value="Very good!">Very Good!
          <input type="radio" name="rating" <?php if (isset($value2) && $value2=="Good") echo "checked";?>  value="Good">Good
          <input type="radio" name="rating" <?php if (isset($value2) && $value2=="So so") echo "checked";?>  value="So so">So so
          <input type="radio" name="rating" <?php if (isset($value2) && $value2=="Very Bad!") echo "checked";?>  value="Very Bad!">Very Bad!
          <span class="error">* <?php echo $ratingErr;?></span>
        <br><br>
        Comment: <textarea name="comment" rows="5" cols="40"><?php echo $comment;?></textarea>
        <input type="submit" name="submit" value="Submit"> 
      </form>

      <?php
        $sql = "SELECT name, rating, comment FROM events";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          echo "<table><tr><th>Name</th><th>Rating</th><th>Comment</th></tr>";
          // output data of each row
          while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["name"]. "</td><td>" . $row["rating"]. "</td><td>" . $row["comment"];
          }
          echo "</table>";
        } else {
           echo "0 results";
        }
      ?>
    </div>
  </body>
</html>