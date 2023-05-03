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
  $rvGuides = getRVGuides($_SESSION['username']);
  $followers = getFollowers($_SESSION['username']);
  $following = getFollowing($_SESSION['username']);

  $myGuidesDisplay = "You haven't created any guides yet!";
  if (count($myGuides) > 0){
     // Format my guides table
    $myGuidesDisplay = "
    <table class='table table-striped table-hover table-bordered'>
    <h4 class='text-start font-weight-bold'>$firstName's Guides:</h4>
      <tr>
        <th>Guide</th>
        <th>Description</th>
        <th>Date Created</th>
        <th>Edit Guide</th>
        <th>Delete Guide</th>
      </tr>
    ";
  }
  for ($i = 0; $i < count($myGuides); $i++) {
    $currentGuide = $myGuides[$i];
    $title = $currentGuide['title'];
    $desc = $currentGuide['description'];
    $date = $currentGuide['g_date'];
    $gid = $currentGuide['g_id'];
    $newRow = "
    <tr>
      <td onclick='location.href=`detailed-guide-view.php?gid=$gid`'>$title</td>
      <td onclick='location.href=`detailed-guide-view.php?gid=$gid`'>$desc</td>
      <td onclick='location.href=`detailed-guide-view.php?gid=$gid`'>$date</td>
      <td><a href=edit-guide.php?gid=$gid class='btn btn-warning col-12'>Edit</a></td>
      <td><form action='$_SERVER[PHP_SELF]' method='post'><input class='btn btn-danger col-12' type='submit' name='deleteBtn' value='Delete'></input><input type='hidden' name='gid_del' value='$gid'></form></td>
    ";

    $myGuidesDisplay = $myGuidesDisplay . $newRow;
  }

  $myGuidesDisplay = $myGuidesDisplay . "</table>";

  $savedGuidesDisplay = "No Saved Guides";
  if(count($savedGuides) > 0){
    // Format saved guides
  $savedGuidesDisplay = "
  <table class='table table-striped table-hover table-bordered'>
  <h4 class='text-start font-weight-bold'>Saved Guides:</h4>
    <tr>
      <th>Guide</th>
      <th>Description</th>
      <th>Date Created</th>
    </tr>
  ";
  }

  for ($i = 0; $i < count($savedGuides); $i++) {
    $currentGuide = getGuideDetails($savedGuides[$i]['g_id']);
    $title = $currentGuide['title'];
    $desc = $currentGuide['description'];
    $date = $currentGuide['g_date'];
    $gid = $currentGuide['g_id'];
    $newRow = "
    <tr>
      <td onclick='location.href=`detailed-guide-view.php?gid=$gid`'>$title</td>
      <td onclick='location.href=`detailed-guide-view.php?gid=$gid`'>$desc</td>
      <td onclick='location.href=`detailed-guide-view.php?gid=$gid`'>$date</td>
    </tr>
    ";

    $savedGuidesDisplay = $savedGuidesDisplay . $newRow;
  }

  $savedGuidesDisplay = $savedGuidesDisplay . "</table>";

  $rvGuidesDisplay = "No Recently Viewed Guides";
  if(count($rvGuides) > 0){
    // Format saved guides
  $rvGuidesDisplay = "
  <h4 class='text-start font-weight-bold'>Recently Viewed Guides:</h4>
  <table class='table table-striped table-hover table-bordered'>
    <tr>
      <th>Guide</th>
      <th>Description</th>
      <th>Date Created</th>
    </tr>
  ";
  }

  for ($i = 0; $i < count($rvGuides); $i++) {
    $currentGuide = getGuideDetails($rvGuides[$i]['g_id']);
    $title = $currentGuide['title'];
    $desc = $currentGuide['description'];
    $date = $currentGuide['g_date'];
    $gid = $currentGuide['g_id'];
    $newRow = "
    <tr>
      <td onclick='location.href=`detailed-guide-view.php?gid=$gid`'>$title</td>
      <td onclick='location.href=`detailed-guide-view.php?gid=$gid`'>$desc</td>
      <td onclick='location.href=`detailed-guide-view.php?gid=$gid`'>$date</td>
    </tr>
    ";

    $rvGuidesDisplay = $rvGuidesDisplay . $newRow;
  }

  $rvGuidesDisplay = $rvGuidesDisplay . "</table>";

  // Following and followers display

  $followersDisplay = "You currently have no followers!";
  if(count($followers) > 0){
    // Format 
  $followersDisplay = "
  <h4 class='text-start font-weight-bold'>Followers:</h4>
  <table class='table table-striped table-hover table-bordered'>
    <tr>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Bio</th>
    </tr>
  ";
  }
  for ($i = 0; $i < count($followers); $i++) {
    $currentUser = $followers[$i];
    $userEmail = $currentUser['user_email'];
    $first_name = $currentUser['first_name'];
    $last_name = $currentUser['last_name'];
    $u_bio = $currentUser['bio'];
    $newRow = "
    <tr>
      <td onclick='location.href=`friend-profile.php?friendUsername=$userEmail`'>$first_name</td>
      <td onclick='location.href=`friend-profile.php?friendUsername=$userEmail`'>$last_name</td>
      <td onclick='location.href=`friend-profile.php?friendUsername=$userEmail`'>$u_bio</td>
    </tr>
    ";

    $followersDisplay = $followersDisplay . $newRow;
  }

  $followersDisplay = $followersDisplay . "</table>";

  $followingDisplay = "You currently are not following anyone!";
  if(count($following) > 0){
    // Format 
  $followingDisplay = "
  <h4 class='text-start font-weight-bold'>Following:</h4>
  <table class='table table-striped table-hover table-bordered'>
    <tr>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Bio</th>
    </tr>
  ";
  }
  for ($i = 0; $i < count($following); $i++) {
    $currentUser = $following[$i];
    $userEmail = $currentUser['user_email'];
    $first_name = $currentUser['first_name'];
    $last_name = $currentUser['last_name'];
    $u_bio = $currentUser['bio'];
    $newRow = "
    <tr>
      <td onclick='location.href=`friend-profile.php?friendUsername=$userEmail`'>$first_name</td>
      <td onclick='location.href=`friend-profile.php?friendUsername=$userEmail`'>$last_name</td>
      <td onclick='location.href=`friend-profile.php?friendUsername=$userEmail`'>$u_bio</td>
    </tr>
    ";

    $followingDisplay = $followingDisplay . $newRow;
  }

  $followingDisplay = $followingDisplay . "</table>";


  // General display table gets changed when toggles
  $guidesDisplay = $myGuidesDisplay;
  $followDisplay = $followingDisplay;


  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['logOutBtn'])){
      session_destroy();
      header('Location: index.php');
    }
    if (isset($_POST['actionBtn']) && ($_POST['actionBtn']) == "My Guides") {
      $guidesDisplay = $myGuidesDisplay;
    }
    if (isset($_POST['actionBtn']) && ($_POST['actionBtn']) == "Saved Guides") {
      $guidesDisplay = $savedGuidesDisplay;
    }
    if (isset($_POST['editBtn'])){
      header('Location: edit-guide.php?gid='.$gid);
    }
    if (isset($_POST['actionBtn']) && ($_POST['actionBtn']) == "Recently Viewed") {
      $guidesDisplay = $rvGuidesDisplay;
    }
    if (isset($_POST['followBtn']) && ($_POST['followBtn']) == "Followers") {
      $followDisplay = $followersDisplay;
    }
    if (isset($_POST['followBtn']) && ($_POST['followBtn']) == "Following") {
      $followDisplay = $followingDisplay;
    }
    if (isset($_POST['deleteBtn'])){
      deleteGuide($_POST['gid_del']);
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

  <!-- body content -->
    <div class="container-fluid text-center">
      <br>
      <h3><?php echo $firstName?> <?php echo $lastName?></h2>
      <p><b>Bio:</b> <?php echo $bio?></p>
      <div class="container-fluid text-center">
        <a href="edit-profile.php" class="btn btn-info" role="button">Edit Profile</a>
      </div><br>
        
      <br>
      <div class="container-fluid text-center">
        <form name="toggleForm" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
          <div class="btn-group text-center" role="group" aria-label="Profile guides toggle">
            <input type="submit" class="btn btn-secondary" name="actionBtn" value="My Guides">
            <input type="submit" class="btn btn-secondary" name="actionBtn" value="Saved Guides">
            <input type="submit" class="btn btn-secondary" name="actionBtn" value="Recently Viewed">
          </div>
        </form>
      </div>
    </div><br>
    <div class='container text-center' style='overflow-y: scroll;'>
      <?php echo $guidesDisplay?>
    </div>
    <br>

    <div class="container-fluid text-center">
        <form name="toggleFollowForm" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
          <div class="btn-group text-center" role="group" aria-label="Follow toggle">
            <input type="submit" class="btn btn-secondary" name="followBtn" value="Followers">
            <input type="submit" class="btn btn-secondary" name="followBtn" value="Following">
          </div>
        </form>
    </div>
    <div class='container text-center' style='overflow-y: scroll;'>
      <?php echo $followDisplay?>
    </div>
    <br>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
    <center>
      <input type="submit" class="btn btn-danger" name="logOutBtn" value="Log Out"></input>
    </center>
    </form>
</body>