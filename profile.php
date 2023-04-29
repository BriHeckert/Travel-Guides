<html><head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Brianna Heckert, August Lamb, Alex Walsh">
    <meta name="description" content="Profile">  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css" type="text/css">
    <title>Profile</title>
  </head>

  <?php 
  require("connect-db.php");
  require("sql-queries.php");
  session_start();
  if (!isset($_SESSION['username'])){
    header('Location: index.php');
  }

  $firstName = getName($_SESSION['username']);
  $lastName = getLastName($_SESSION['username']);
  $bio = getBio($_SESSION['username']);
  $myGuides = getUserGuides($_SESSION['username']);
  $savedGuides = getSavedGuides($_SESSION['username']);

  // Format my guides table
  $guidesHTML = "
  <table class='table table-striped table-hover table-bordered'>
    <tr>
      <th>Guide</th>
      <th>Description</th>
      <th>Date Created</th>
    </tr>
  ";

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['actionBtn']) && ($_POST['actionBtn']) == "My Guides") {
      for ($i = 0; $i < count($myGuides); $i++) {
        $currentGuide = $myGuides[$i];
        $title = $currentGuide['title'];
        $desc = $currentGuide['description'];
        $date = $currentGuide['date'];
        $newRow = "
        <tr>
          <td>$title</td>
          <td>$desc</td>
          <td>$date</td>
        </tr>
        ";
        $guidesHTML = $guidesHTML . $newRow;
      }
      $guidesHTML = $guidesHTML . "</table>";
    }
    else if (!empty($_POST['actionBtn']) && ($_POST['actionBtn']) == "Saved Guides") {
      for ($i = 0; $i < count($savedGuides); $i++) {
        $currentGuide = $savedGuides[$i];
        $title = $currentGuide['title'];
        $desc = $currentGuide['description'];
        $date = $currentGuide['date'];
        $newRow = "
        <tr>
          <td>$title</td>
          <td>$desc</td>
          <td>$date</td>
        </tr>
        ";
        $guidesHTML = $guidesHTML . $newRow;
      }
      $guidesHTML = $guidesHTML . "</table>";
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

  <!-- body content -->
    <div class="container-fluid text-center">
      <h3><?php echo $firstName?> <?php echo $lastName?></h2>
      <p><?php echo $bio?></p>
    </div>
    <div class="container-fluid text-center">
      <a href="edit-profile.php" class="btn btn-info" role="button">Edit Profile</a>
    </div>
    <div class="container-fluid text-center">
      <div class="btn-group" role="group" aria-label="Profile guides toggle">
        <input type="submit" class="btn btn-primary" name="actionBtn" value="My Guides">
        <input type="submit" class="btn btn-primary" name="actionBtn" value="Saved Guides">
      </div>
    </div>
    <div class='container' style='overflow-y: scroll; height: 70vh;'>
      <?php echo $guidesHTML?>
    </div>
</body>