<!DOCTYPE html>
<html>
  <head>
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
    <title>About</title>

    <style>

        nav {
          background-color:#015a8e;
          height:80px;
          position:fixed;
          margin-bottom:5px;
          z-index:100;
        }

        .body {
          margin:auto;
          width:55%;
        }

        #about {
          margin-top:75px;
        }

        .contact {
          width:27%;
        }

        #justin {
          position:relative;
          margin-left:22.5%;
        }

        #justin img {
          margin-top:-24px;
          margin-left:-24px;
          height:290px;
          width:116%;
        }

        #neel {
          position:relative;
          margin-left:50.5%;
          margin-top:-495px;
        }

        #neel img {
          margin-top:-24px;
          margin-left:-23.5px;
          height:290px;
          width:116%;
        }

        #justin h5 {
          margin-left:28%;
        }

        #neel h5 {
          margin-left:31%;
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
                <li><a href="register.php">Register</a></li>
            </ul>
          </div>
        </nav>
      
    <br>

      <div id="about" class="body" class="row">
        <div class="col s12 m6">
          <div class="card white" style='border:1px solid #b2b2b2'>
            <div class="card-content black-text">
              <span class="card-title">What can you do on YourSpace?</span>
            </div>
          </div>
        </div>
      </div>

      <div class="body" class="row">
        <div class="col s12 m6">
          <div class="card white" style='border:1px solid #b2b2b2'>
            <div class="card-content black-text">
              <ol>
                <li>Share what you are thinking to the YourSpace community by posting a message.</li>
                <li>Group posts on YourSpace by implementing hashtags into messages you post.</li>
                <li>Share interesting pictures you have taken to the YourSpace community.</li>
                <li>See other people's message and image posts in your feed when you log in.</li>
                <li>Search keywords from posts, hashtags, and posts from specific users on the YourSpace community</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <div class="body" class="row">
        <div class="col s12 m6">
          <div class="card white" style='border:1px solid #b2b2b2'>
            <div class="card-content black-text">
              <span class="card-title">The Team</span>
            </div>
          </div>
        </div>
      </div>

      <div class="contact" id="justin" class="row">
        <div class="col s12 m6">
          <div class="card white" style='border:1px solid #b2b2b2'>
            <div class="card-content black-text">
              <img src=https://s16.postimg.org/m1jul984l/image.jpg>
              <br><br>
              <h5>Justin Gilbert</h5>
              <br>
              <p style="margin-left:25%">Co-founder of YourSpace</p>
              <p style="margin-left:22%">Upper Canada College Student</p>
              <p style="margin-left:26%">Contact: <a href="mailto:justin.gilbert@ucc.on.ca">Justin Gilbert</a></p>
            </div>
          </div>
        </div>
      </div>

      <div class="contact" id="neel" class="row">
        <div class="col s12 m6">
          <div class="card white" style='border:1px solid #b2b2b2'>
            <div class="card-content black-text">
              <img src=https://s2.postimg.org/7rk12cbrd/neel.jpg>
              <br><br>
              <h5>Neel Ismail</h5>
              <br>
              <p style="margin-left:25%">Co-founder of YourSpace</p>
              <p style="margin-left:22%">Upper Canada College Student</p>
              <p style="margin-left:26%">Contact: <a href="mailto:neel.ismail@ucc.on.ca">Neel Ismail</a></p>
            </div>
          </div>
        </div>
      </div>

</body>
</html>