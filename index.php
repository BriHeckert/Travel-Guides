<html><head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Brianna Heckert, August Lamb, Alex Walsh">
    <meta name="description" content="Welcome to Travel Guides">  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css" type="text/css">
    <title>Login</title>
  </head>

  <?php 
  require("connect-db.php");
  session_start();

  function checkUser($username, $password){
    global $db;
    $query = "select count(*) from users where user_email=:user_email";
    $statement = $db->prepare($query);
    $statement->bindValue(':user_email', $username);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();

    // now that we found user check the hashed passwords match
    global $db;
    $query = "select password from users where user_email=:user_email";
    $statement = $db->prepare($query);
    $statement->bindValue(':user_email', $username);
    $statement->execute();
    $passresult = $statement->fetch();
    $statement->closeCursor();

    if ($result["count(*)"] != 0){
      if (password_verify($password, $passresult["password"])){
        return True;
      } else {
        ?><h3 class='text-center text-danger pt-2'>Incorrect credentials!</h3><?php
      }
    } else {
      ?><h3 class='text-center text-danger pt-2'>Incorrect credentials!</h3><?php
      return False;
    }
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (!empty($_POST['LoginBtn']) && !empty($_POST['username']) && !empty($_POST['password'])){
      // $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
      $password = trim($_POST['password']);
      $username = trim($_POST['username']);
      if (checkUser($username, $password)){
        $_SESSION['username'] = $username;
        header('Location: browse.php');
      }
    } 
  }

  ?>

  <body>
  <div class="container mp-5 " style="min-height: 100vh">
    <div class="jumbotron m-5 align-items-center">
      <div class="row p-4 m-4 align-items-center">
        <div class='col mp-5'>
          <div class="container p-4">
            <!-- <img src="plane.jpeg" class="img-fluid" alt="plane window during sunset"> -->
            <h1 class="display-1 font-bold">Travel Buddy</h1>
            <p class="lead">Featuring guides by real people for cities across the US</p>
          </div>
        </div>

        <div class='col mp-5 mb-lg-0'>
          <div class="container p-4">
          <div class='card'>
            <div class="card-body">
              <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                <div class="form-group">
                  <div class='p-4'>
                    <input type="email" class="form-control" placeholder="Email" name="username" required>
                  </div>
                </div>
                <div class="form-group">
                  <div class='p-4'>
                    <input type="text" class="form-control" placeholder="Password" name="password" required>
                  </div>
                </div>
                <div class="text-center p-5">
                  <input type="submit" class="btn btn-primary btn-block mb-4" name="LoginBtn" value="Log In"></input>
                  <p>No account? No worries!</p>
                  <a href="sign-up.php">Sign Up</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
     
  </body></html>