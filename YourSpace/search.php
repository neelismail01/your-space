<!DOCTYPE html>
<html>
	<head>
		<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
		<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
    <title>Search Results</title>

    <style>

        nav {
          background-color:#015a8e;
          height:80px;
          position:fixed;
          margin-bottom:5px;
          z-index:100;
        }

        #back {
          margin-top:5px;
        }

        .body {
          margin:auto;
          width:47%;
        }

        #search-results {
        	margin-top:55px;
          text-align:center;
        }

        .tweet-cards {
          margin-top:-15px;
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
          border-top:1px solid #b2b2b2;
          padding-top:10px;
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
                <li><a href="edit.php"><strong>Return to Profile</strong></a></li>
            </ul>
          </div>
        </nav>
    	
    <br><br>

	<div id="search-results" class="body" class="row">
    <div class="col s12 m6">
      <div class="card white" style='border:1px solid #b2b2b2'>
        <div class="card-content black-text">
          <span class="card-title">Search results for, <strong>"<?php echo $_POST["search"]?>"</strong>:</span>
        </div>
      </div>
    </div>
  </div>

	<?php

		// pass in some info;
		require("common.php"); 
		
		if(empty($_SESSION['user'])) { 
  
			// If they are not, we redirect them to the login page. 
			$location = "http://" . $_SERVER['HTTP_HOST'] . "/login.php";
			echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL='.$location.'">';
			//exit;
         
        	// Remember that this die statement is absolutely critical.  Without it, 
        	// people can view your members-only content without logging in. 
        	die("Redirecting to login.php"); 
    	}
		
		// To access $_SESSION['user'] values put in an array, show user his username
		$arr = array_values($_SESSION['user']);

		// open connection
		$connection = mysqli_connect($host, $username, $password) or die ("Unable to connect!");

		// select database
		mysqli_select_db($connection, $dbname) or die ("Unable to select database!");

		$search = $_POST["search"];


    // create query
		$query  = "SELECT * FROM symbols WHERE (username LIKE '%{$search}%') OR (description LIKE '%{$search}%') ORDER BY id DESC";
       
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
                  echo "<td><p style='font-size:20px'><strong>" . $row[1] . "</strong> posted:</p></td>";
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
              echo "No posts matching your search have been found!";
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