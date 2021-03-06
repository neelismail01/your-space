<?php 

    // First we execute our common code to connection to the database and start the session 
    require("common.php"); 
     
    // This variable will be used to re-display the user's username to them in the 
    // login form if they fail to enter the correct password.  It is initialized here 
    // to an empty value, which will be shown if the user has not submitted the form. 
    $submitted_username = ''; 
     
    // This if statement checks to determine whether the login form has been submitted 
    // If it has, then the login code is run, otherwise the form is displayed 
    if(!empty($_POST)) 
    { 
        // This query retreives the user's information from the database using 
        // their username. 
        $query = " 
            SELECT 
                id, 
                username, 
                password, 
                salt, 
                email 
            FROM users 
            WHERE 
                username = :username 
        "; 
         
        // The parameter values 
        $query_params = array( 
            ':username' => $_POST['username'] 
        ); 
         
        try 
        { 
            // Execute the query against the database 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            // Note: On a production website, you should not output $ex->getMessage(). 
            // It may provide an attacker with helpful information about your code.  
            die("Failed to run query: " . $ex->getMessage()); 
        } 
         
        // This variable tells us whether the user has successfully logged in or not. 
        // We initialize it to false, assuming they have not. 
        // If we determine that they have entered the right details, then we switch it to true. 
        $login_ok = false; 
         
        // Retrieve the user data from the database.  If $row is false, then the username 
        // they entered is not registered. 
        $row = $stmt->fetch(); 
        if($row) 
        { 
            // Using the password submitted by the user and the salt stored in the database, 
            // we now check to see whether the passwords match by hashing the submitted password 
            // and comparing it to the hashed version already stored in the database. 
            $check_password = hash('sha256', $_POST['password'] . $row['salt']); 
            for($round = 0; $round < 65536; $round++) 
            { 
                $check_password = hash('sha256', $check_password . $row['salt']); 
            } 
             
            if($check_password === $row['password']) 
            { 
                // If they do, then we flip this to true 
                $login_ok = true; 
            } 
        } 
         
        // If the user logged in successfully, then we send them to the private members-only page 
        // Otherwise, we display a login failed message and show the login form again 
        if($login_ok) 
        { 
            // Here I am preparing to store the $row array into the $_SESSION by 
            // removing the salt and password values from it.  Although $_SESSION is 
            // stored on the server-side, there is no reason to store sensitive values 
            // in it unless you have to.  Thus, it is best practice to remove these 
            // sensitive values first. 
            unset($row['salt']); 
            unset($row['password']); 
             
            // This stores the user's data into the session at the index 'user'. 
            // We will check this index on the private members-only page to determine whether 
            // or not the user is logged in.  We can also use it to retrieve 
            // the user's details. 
            $_SESSION['user'] = $row; 
             
            // Redirect the user to the private members-only page. 
            header("Location: edit.php"); 
            die("Redirecting to: edit.php"); 
        } 
        else 
        { 
            // Tell the user they failed 
            print("Login Failed."); 
             
            // Show them their username again so all they have to do is enter a new 
            // password.  The use of htmlentities prevents XSS attacks.  You should 
            // always use htmlentities on user submitted values before displaying them 
            // to any users (including the user that submitted them).  For more information: 
            // http://en.wikipedia.org/wiki/XSS_attack 
            $submitted_username = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8'); 
        } 
    } 

?>
<!DOCTYPE html>
<html>
<head>
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
    <title>Sign in</title>
    <style>

        nav {
          background-color:#015a8e;
          height:80px;
          position:fixed;
          margin-bottom:5px;
          z-index:100;
        }

        .login-card {
            width:385px;
            margin:auto;
            margin-top:120px;
            padding:10px;
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
                <li><a href="register.php">Sign Up</a></li>
            </ul>
        </div>
    </nav>    

    <br>

    <div class="login-card" class="row">
        <div class="col s12 m6">
            <div class="card white" style='border:1px solid #b2b2b2'>
                <div class="card-content black-text">
                    <span class="card-title" style="text-align:center">Log in to your account</span>
                    <br>
                    <form action="login.php" method="post">
                        <div class="input-field col s12">
                            <input placeholder="Username" type="text" name="username" value="<?php echo $submitted_username; ?>" /> 
                        </div>
                        <div class="input-field col s12">    
                            <input placeholder="Password" type="password" name="password" value="" />
                        </div>
                        <br>
                        <button class="btn waves-effect waves-light" type="submit" name="action" style="background-color:#015a8e">
                            <input type="submit" value="login" /></a>
                        </button>
                    </form>
                    <br><p style="padding:5px">Don't have an account? <a href="register.php">Sign up!</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>