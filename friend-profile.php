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

  $friendEmail = $_GET['friendUsername'];
  $friendName = getName($friendEmail);
  $friendLastName = getLastName($friendEmail);
  $friendBio = getBio($friendEmail);
  $friendGuides = getUserGuides($friendEmail);

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
    $gid = $currentGuide['g_id'];
    $newRow = "
    <tr>
      <td onclick='location.href=`detailed-guide-view.php?gid=$gid`'>$title</td>
      <td onclick='location.href=`detailed-guide-view.php?gid=$gid`'>$desc</td>
      <td onclick='location.href=`detailed-guide-view.php?gid=$gid`'>$date</td>
    </tr>
    ";

    $guidesHTML = $guidesHTML . $newRow;
  }
  $guidesHTML = $guidesHTML . "</table>";

  # Follow / unfollow
  # still need to change that that the toggle says like "following" / "not following" when the input is clicked
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['followBtn']) && ($_POST['followBtn']) == "Follow") {
        followUser($_SESSION['username'], $friendEmail);
      }
    if (isset($_POST['followBtn']) && ($_POST['followBtn']) == "Unfollow") {
        unfollowUser($_SESSION['username'], $friendEmail);
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
      <div class="col container d-flex text-end justify-content-end">
        <div class="row d-flex align-items-center justify-content-end">
          <div class="col  text-end">
            <a class="nav-link text-danger text-dark" href="browse.php">Home</a>
          </div>
          <div class="col text-start">
            <a class="nav-link text-danger text-dark" href="profile.php">Profile</a>
          </div>
          <div class='col'>
          <a class="text-dark" href="create-guide.php"><button class="btn btn-primary btn-sm btn-block" style="width: 100px">Create Guide</button></a>
        </div>
        </div>
      </div>
    </div>
  </nav>

  <!-- body content -->
  <br>
  <div class="container-fluid text-center">
      <h3><?php echo $friendName?> <?php echo $friendLastName?></h2>
      <p><?php echo $friendBio?></p>
  </div>
  <div class="container-fluid text-center">
      <div class="btn-group" role="group" aria-label="Follow/unfollow friend toggle">
        <input type="submit" class="btn btn-primary" name="followBtn" value="Follow">
        <input type="submit" class="btn btn-primary" name="followBtn" value="Unfollow">
      </div>
  </div><br>
  <div class='container text-center' style='overflow-y: scroll; height: 60vh;'>
    <h3><?php echo $friendName?>'s Guides</h3>
    <?php echo $guidesHTML?>
  </div> 
