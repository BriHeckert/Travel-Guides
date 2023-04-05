<html><head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Brianna Heckert, August Lamb, Alex Walsh">
    <meta name="description" content="Sign Up For Travel Guides">  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css" type="text/css">
    <title>Travel Guides Sign Up</title>
  </head>

<?php 
require("connect-db.php");
require("sql-queries.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  if (!empty($_POST['SignUpBtn'])){
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
    $username = trim($_POST['username']);
    if (validUser($username)){
      addUser($username, $password, $_POST['firstName'], $_POST['lastName'], $_POST['bio']);
      $_SESSION['username'] = $username;
      header('Location: browse.php');
    } else {
      ?><h3 class='text-center text-danger pt-2'>An Account with that email already exists.</h3><?php
    }
  } 
}

?>

  <body>
  <div class="container mp-5 " style="min-height: 100vh">
    <div class="jumbotron m-5 align-items-center">
    <a href="index.php" class="btn btn-secondary btn-md active m-4" role="button" aria-pressed="true">Back to Login</a>
      <div class="row align-items-center">
      <h1 class="display-4 font-bold text-center">TravelGuides</h1>
      <p class="lead text-center">Sign up for free today</p>
        <div class='col mp-5 mb-lg-0'>
          <div class="container p-4">
          <div class='card'>
            <div class="card-body">
              <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                <div class="form-group row p-3">
                    <div class='pr-3 col'>
                        <label for="firstName">First Name:</label>
                        <input type="text" class="form-control" id="firstName" placeholder="First Name" name="firstName" required>
                    </div>
                    <div class='pl-3 col'>
                        <label for="lastName">Last Name:</label>
                        <input type="text" class="form-control" id="lastName" placeholder="Last Name" name="lastName" required>
                    </div>
                </div>
                <div class="form-group p-3">
                    <label for="bioField">Bio:</label>
                    <textarea class="form-control" id="bioField" rows="3" name="bio" placeholder="share something cool about yourself!" required></textarea>
                </div>
                <div class="form-group">
                  <div class='p-3'>
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" placeholder="Email" name="username" required>
                  </div>
                </div>
                <div class="form-group">
                  <div class='p-3'>
                    <label for="password">Password:</label>
                    <input type="text" class="form-control" id="password" placeholder="Password" name="password" required>
                  </div>
                </div>
                <div class="text-center p-2">
                  <input type="submit" class="btn btn-primary btn-block mb-4" name="SignUpBtn" value="Sign Up!"></input>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
     
  </body></html>