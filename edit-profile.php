<html><head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Brianna Heckert, August Lamb, Alex Walsh">
    <meta name="description" content="Profile">  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css" type="text/css">
    <title>Edit Profile</title>
  </head>

  <?php 
  require("connect-db.php");
  require("sql-queries.php");
  session_start();
  if (!isset($_SESSION['username'])){
    header('Location: index.php');
  }

  $username = $_SESSION['username'];

  if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (!empty($_POST['editProfile'])){
        updateProfile($username, $_POST['newFirstName'], $_POST['newLastName'], $_POST['newBio']);
        header('Location: profile.php');
    } 
  }

  ?>

<body>
  <!-- navbar stuff -->
  <nav class="navbar navbar-expand-lg navbar-light justify-content-between d-flex align-items-center" style="background-color: #e3f2fd;">
    <div class="container d-flex align-items-center">
      <div class="col">
        <a class="navbar-brand" href="browse.php">Travel Buddy</a>
      </div>
      <div class="col">
        <form class="form-inline my-2 my-lg-0">
          <div class="input-group">
            <input class="form-control mr-lg-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-info my-2 my-sm-0" type="submit">Search</button>
          </div>
        </form>
      </div>
      <div class="col container d-flex text-end justify-content-end">
        <div class="row d-flex align-items-center justify-content-end">
          <div class="col  text-end">
            <a class="nav-link text-dark" href="browse.php">Home</a>
          </div>
          <div class="col text-start">
            <a class="nav-link text-dark" href="profile.php">Profile</a>
          </div>
          <div class='col'>
          <a class="text-dark" href="create-guide.php"><button class="btn btn-primary btn-sm btn-block" style="width: 100px">Create Guide</button></a>
        </div>
        </div>
      </div>
    </div>
  </nav>

  <div class="containter-fluid text-center">
    <br>
    <h2>Edit My Info</h2><br>
    <div class='container'>
      <center>
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
          <div class="form-group">
            <input type="text" class="form-control" id="newFirstName" placeholder="First name (required)" name="newFirstName" style='width: 20vw; align: center;' required>
          </div><br>
          <div class="form-group">
            <input type="text" class="form-control" id="newLastName" placeholder="Last name (required)" name="newLastName" style='width: 20vw; align: center;' required>
          </div><br>
          <div class="form-group">
            <textarea class="form-control" id="newBio" rows="3" name="newBio" placeholder="New bio (required)" style='width: 50vw; align: center;' required></textarea>
          </div><br>
          <div>
            <input type="submit" class="btn btn-primary" name="editProfile" value="Update"></input>
          </div>
        </form>

        <a href='profile.php' class='btn btn-danger' style='width: 10vh; align: center'>Cancel</a>
      </center>
    </div>
  </div>
</body>
</html>