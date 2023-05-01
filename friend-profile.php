<html><head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Brianna Heckert, August Lamb, Alex Walsh">
    <meta name="description" content="Profile">  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css" type="text/css">
    <title>Friend Profile</title>
  </head>

  <?php 
  require("connect-db.php");
  require("sql-queries.php");
  session_start();
  if (!isset($_SESSION['username'])){
    header('Location: index.php');
  }

  $friendName = getName($friendEmail);
  $friendLastName = getLastName($friendEmail);
  $friendBio = getBio($friendEmail);
  $friendGuides = getUserGuides($friendEmail); // NEED TO FIGURE OUT HOW TO GET THIS
  $isFollowing = getFollowing($_SESSION['username']); 
  // was going to use this to see what to set the toggle buttons as... 
  // making sure friendEmail exists in this list would mean make button on following for now

  $guidesHTML = "
  <table class='table table-striped table-hover table-bordered'>
    <tr>
      <th>Guide</th>
      <th>Description</th>
      <th>Date Created</th>
    </tr>
  ";

  for ($i = 0; $i < count($friendGuides); $i++) {
    $currentGuide = $friendGuides[$i];
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

  # Follow / unfollow
  # still need to change that that the toggle says like "following" / "not following" when the input is clicked
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Follow")) {
      followUserpt1($_SESSION['username'], $friendEmail);
      followUserpt2($friendEmail, $_SESSION['username']);
    }
    else if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Unfollow")) {
      unfollowUserpt1($_SESSION['username'], $friendEmail);
      unfollowUserpt2($friendEmail, $_SESSION['username']);
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
      <h3><?php echo $friendName?> <?php echo $friendLastName?></h2>
      <p><?php echo $friendBio?></p>
  </div>
  <div class="container-fluid text-center">
      <div class="btn-group" role="group" aria-label="Follow/unfollow friend toggle">
        <input type="submit" class="btn btn-primary" name="actionBtn" value="Follow">
        <input type="submit" class="btn btn-primary" name="actionBtn" value="Unfollow">
      </div>
  </div>
  <div>
    <h2><?php echo $friendName?>'s Guides</h2>
    <?php echo $guidesHTML?>
  </div> 
