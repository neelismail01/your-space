<?php
 require("common.php"); 
    
  if(empty($_SESSION['user'])) { 
  
    // If they are not, we redirect them to the login page. 
    $location = "http://" . $_SERVER['HTTP_HOST'] . "/login.php";
    echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL='.$location.'">';
    exit;
         
    // Remember that this die statement is absolutely critical.  Without it, 
    // people can view your members-only content without logging in. 
    die("Redirecting to login.php");
  }
    
  // To access $_SESSION['user'] values put in an array, show user his username
  $arr = array_values($_SESSION['user']);

  $connection = mysqli_connect($host, $username, $password) or die ("Unable to connect!");

  // select database
  mysqli_select_db($connection, $dbname) or die ("Unable to select database!");

?>

<!DOCTYPE html>
<html>
  <head>
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
    <title>Profile</title>

    <style>

        nav {
          background-color:#015a8e;
          height:80px;
          position:fixed;
          margin-bottom:5px;
          z-index:100;
        }

        .welcome {
          margin:auto;
          width:47%;
          text-align:center;
          margin-top:0px;
        }

        #search {
          position:fixed;
          margin-left:5px;
          width:51.5%;
        }

        #search button {
          margin-left:-10px;
          margin-top:10px;
        }

        .post {
          position:fixed;
          width:24%;
          float:left;
          margin-left:74.75%;
        }

        .tweet-cards {
          width:47%;
          margin:auto;
        }

        #like {
          height:12.5px;
          width:12.5px;
        }

        #like-text {
          color:#015a8e;
        }

        #report {
          color:#015a8e;
          text-align:right;
        }

        #image-posts {
          width:100%;
          height:275px;
          border-radius:5px;
        }

        #description {
          border-radius:5px;
          border-color:#9b9b9b;
          width:100%;
          height:100px;
          padding:7px;
          resize:none;
          outline:none;
        }

        #post-bottom {
          margin-top:-10px;
        }

        #separator {
          margin-left:13.5%;
          color:#015a8e;
        }

    </style>
  </head>
  <body style="background-color:#f4f4f4">

        <nav>
          <div class="nav-wrapper">
            <a href="edit.php" class="brand-logo center" style="margin-top:-6px"><h3>YourSpace</h3></a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a href="about.php">About</a></li>
                <li><a href="help.php">Help</a></li>
            </ul>
            <ul id="nav-mobile" class="left hide-on-med-and-down">
                <li><a href="logout.php">Logout</a></li>
            </ul>
          </div>
        </nav>
      
    <br><br><br><br>

    <div class="post" class="row">
        <div class="col s12 m6">
          <div class="card white" style='border:1px solid #b2b2b2'>
            <div class="card-content black-text">
              <span class="card-title" style="text-align:center">Post Thoughts and Images</span>
              <br>
              <form action="edit.php" method="post" enctype="multipart/form-data">
                <div>
                  <textarea id="description" placeholder="Share a thought..." class="form-control" type="text" name="description" rows="5" cols="4" id="comment"></textarea>
                </div>
                <br>
                <p style="text-align:center">Want to upload an image?</p>
                <br>
                <input type="hidden" name="size" value="1000000">
                <div style="margin-left:13%">
                  <input type="file" name="image">
                </div>
                <br>
                <br>
                <div id="button" style="margin-left:19%">
                  <a class="waves-effect waves-light btn" style="background-color:#015a8e">
                    <i class="material-icons right">add</i>
                    <input type="submit" name="upload" value="Post">
                  </a>
                </div>
              </form>
            </div>
          </div>
        </div>
    </div>

    <div id="search" class="row">
      <div class="col s12 m6">
          <div class="card white" style='border:1px solid #b2b2b2'>
              <div class="card-content black-text">
                <span class="card-title" style="margin-left:-10px">Explore Posts</span>
                  <form action="search.php" method="post">
                      <input placeholder="Search users, tweets, and hashtags" type="text" name="search" style="margin-left:-10px">
                      <br>
                      <button class="btn waves-effect waves-light" type="submit" name="action" style="background-color:#015a8e">Search
                        <i class="material-icons right">search</i>
                      </button>
                  </form>
              </div>
          </div>
      </div>
    </div>

    <div class="welcome" class="row">
        <div class="col s12 m6">
          <div class="card white" style='border:1px solid #b2b2b2'>
            <div class="card-content black-text">
              <span class="card-title">
              <?php
                echo "Your Feed, " . $arr[1] . ":";
              ?>
               </span>
            </div>
          </div>
        </div>
    </div>

  <?php

    // free result set memory
    mysqli_free_result($connection,$result);

    date_default_timezone_set("America/New_York");
    $timedate = date("F j, Y")." at " . date("g:i a");
    $usernm = $arr[1];
    $image = $_FILES['image']['name'];
    $description = $_POST['description'];


    if (isset($_POST['upload'])) {

      // path to store the uploaded image
      $target = "images/" . basename($_FILES['image']['name']);

      // build SQL query
      $query = "INSERT INTO symbols (username, image, description, timedate) VALUES ('$usernm', '$image', '$description', '$timedate')";
      // run the query
      mysqli_query($connection,$query);

      $msg = "";
      if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $msg = "Image uploaded successfully";
      } else {
        $msg = "There was a problem uploading the image";
      }
    }

    // if DELETE pressed, set an id, if id is set then delete it from DB
    if (isset($_GET['report'])) {

      // create query to delete record
      echo $_SERVER['PHP_SELF'];
      $query = "DELETE FROM symbols WHERE id = ".$_GET['report'];

      // run the query
      $result = mysqli_query($connection,$query) or die ("Error in query: $query. ".mysql_error());
      
      // reset the url to remove id $_GET variable
      $location = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
      echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL='.$location.'">';
      
    }
    
    if (isset($_GET['like'])) {

      //create query to update record
      echo $_SERVER['PHP_SELF'];
      $query = "UPDATE symbols SET likes = likes + 1 WHERE id = " .$_GET['like'];

      //run the query
      $result = mysqli_query($connection,$query) or die ("Error in query: $query. ".mysql_error());
      
      // reset the url to remove id $_GET variable
      $location = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
      echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL='.$location.'">';
      
    }

    // create query
    $query = "SELECT * FROM symbols ORDER BY id DESC";
       
    // execute query
    $result = mysqli_query($connection,$query) or die ("Error in query: $query. ".mysql_error());
    

    // see if any rows were returned
    if (mysqli_num_rows($result) > 0) {

        // print them one after another
        while($row = mysqli_fetch_row($result)) {

        echo "<div class='tweet-cards' class='row'>";
        echo "<div class='col s12 m6'>";
          echo "<div class='card white' style='border:1px solid #b2b2b2'>";
            echo "<div class='card-content black-text'>";
              echo "<table>";
                echo "<tr>";
                  echo "<td><p style='font-size:19px'><strong>" . $row[1] . "</strong> posted:</p></td>";
                  echo "<td style='text-align:right'>" . $row[5] . "</td>";
                echo "</tr>";

                if ($row[3] != "") {
                
                echo "<tr>";
                  echo "<td colspan='2'>".$row[3]."</td>";
                echo "</tr>";

                }

                if ($row[2] != "") {

                echo "<tr>";
                  echo "<td colspan='2'><img id='image-posts' src='images/".$row[2]."'></td>";
                echo "</tr>";
                
                }

                echo "<tr style='border-top:1px solid #b2b2b2'>";
                  echo "<td><a id='like-text' href=".$_SERVER['PHP_SELF']."?like=".$row[0]."><strong><p style='font-size:15px'><img id='like' src='like.png' /> " . $row[4] . " likes</p></strong></a></td>";
                  echo "<td><a id='report' href=".$_SERVER['PHP_SELF']."?report=".$row[0]."><strong><p style='font-size:15px'>Report Post</p></strong></a></td>";
                echo "</tr>";
                echo "</table>";
            echo "</div>";
          echo "</div>";
        echo "</div>";
        echo "</div>";
        }

    } else {

      echo "<div class='tweet-cards' class='row'>";
        echo "<div class='col s12 m6'>";
          echo "<div class='card white'>";
            echo "<div class='card-content black-text'>";
              echo "No one has posted anything yet. Be the first one!";
            echo "</div>";
          echo "</div>";
        echo "</div>";
      echo "</div>";
    }

    // close connection
    mysqli_close($connection);

  ?>

  </body>
</html>