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
  <nav class="navbar navbar-expand-lg navbar-light justify-content-between" style="background-color: #e3f2fd;">
    <div class="container">
      <div class="col">
        <a class="navbar-brand">TravelGuides</a>
      </div>
      <div class="col">
        <form class="form-inline my-2 my-lg-0">
          <div class="input-group">
            <input class="form-control mr-lg-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-info my-2 my-sm-0" type="submit">Search</button>
          </div>
        </form>
      </div>
      <div class="col">
        <div class="row">
          <div class="col  text-end">
            <a class="nav-link text-danger text-dark" href="browse.php">Home</a>
          </div>
          <div class="col text-start">
            <a class="nav-link text-danger text-dark" href="profile.php">My Profile</a>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <div class="containter-fluid text-center">
    <h1>Edit Profile</h1>
    <div>
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="form-group">
            <label for="newFirstName">First Name:</label>
            <input type="text" class="form-control" id="newFirstName" placeholder="Update your first name here" name="newFirstName" required>
        </div>
        <div class="form-group">
            <label for="newLastName">Last Name:</label>
            <input type="text" class="form-control" id="newLastName" placeholder="Update your last name here" name="newLastName" required>
        </div>
        <div class="form-group">
            <label for="newBio">Bio:</label>
            <textarea class="form-control" id="newBio" rows="3" name="newBio" placeholder="Update your bio here" required></textarea>
        </div>
        <div>
            <input type="submit" class="btn btn-primary" name="editProfile" value="Update"></input>
        </div>
    </div>
  </div>
</body>