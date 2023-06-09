<html><head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Brianna Heckert, August Lamb, Alex Walsh">
    <meta name="description" content="Travel Guides Detailed Guide">  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css" type="text/css">
    <title>Detailed Guide</title>
  </head>

  <?php 
  require("connect-db.php");
  require("sql-queries.php");
  session_start();
  if (!isset($_SESSION['username'])){
    header('Location: index.php');
  }

  $firstName = getName($_SESSION['username']);
  $gid = $_GET['gid'];
  $rating = getRating($gid);
  $today = date("Y-m-d");

  if (checkRecentlyViewed($_SESSION['username'], $gid) == False) {
    addToRecentlyViewed($_SESSION['username'], $gid, $today);
  }
  
  $guide = getGuideDetails($gid);
  $activities = getGuideActivities($gid);
  $comments = getComments($gid);

  $title = $guide['title'];
  $date = $guide['g_date'];
  $description = $guide['description'];
  $location = $guide['location'];
  $duration = $guide['duration'];
  $author = 'Travel Buddy :)';
  if ($guide['user_email']){
    $author = getName($guide['user_email']) . " " .getLastName($guide['user_email']);
  }
  $friendEmail = $guide['user_email'];

  $creatorDisplay = "
  <table class='table table-striped table-hover table-bordered'>
    <tr>
      <th>Created By</th>
    </tr>
  ";

  $newCreatorRow = "
    <tr>
      <td onclick='location.href=`friend-profile.php?friendUsername=$friendEmail`'>$author</td>
    </tr>
    ";
  
  $creatorDisplay = $creatorDisplay . $newCreatorRow;
  $creatorDisplay = $creatorDisplay . "</table>";

  $rateDisplay = "
  <table class='table table-striped table-hover table-bordered'>
    <tr>
      <th>Average Rating</th>
    </tr>
  ";

  $newRateRow = "
  <tr>
    <td>$rating</td>
  </tr>
  ";

  $rateDisplay = $rateDisplay . $newRateRow;
  $rateDisplay = $rateDisplay . "</table>";
  
  $activityDisplay = "";

  foreach($activities as $activity){
    $actTitle = $activity['title'];
    $actDesc = $activity['description'];
    $actAddy = $activity['address'];
    $newCard = "
      <div class='card'>
        <div class='card-body'>
          <h5 class='card-title'>$actTitle</h5>
          <p class='card-text'>$actAddy</p>
          <hr/>
          <p class='card-text'>Description: $actDesc</p>
        </div>
      </div>
      <br>
    ";

    $activityDisplay = $activityDisplay . $newCard;
  };

  $commentsDisplay = "
  <table class='table table-striped table-hover table-bordered'>
    <tr>
      <th>User</th>
      <th>Comment</th>
      <th>Date</th>
    </tr>
  ";

  for ($i = 0; $i < count($comments); $i++) {
    $comment = $comments[$i];
    $userEmail = $comment['user_email'];
    $user = getName($comment['user_email']) . " " . getLastName($comment['user_email']);
    $text = $comment['text'];
    $time = $comment['timestamp'];
    $newRow = "
    <tr>
      <td onclick='location.href=`friend-profile.php?friendUsername=$userEmail`'>$user</td>
      <td>$text</td>
      <td>$time</td>
    </tr>
    ";

    $commentsDisplay = $commentsDisplay . $newRow;
  }

  if (count($comments) > 0){
    $commentsDisplay = $commentsDisplay . "</table>";
  } else {
    $commentsDisplay = "";
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (!empty($_POST['commentBtn'])) {
      addComment($_SESSION['username'], $gid , $_POST['comment'], date("Y-m-d"));
      $comments = getComments($gid);
      header('Location: detailed-guide-view.php?gid='.$gid);
    }
    if (isset($_POST['ratingBtn'])){
      if (checkRated($gid,  $_SESSION['username'])){
        leaveRating($gid, $_SESSION['username'], trim($_POST['rating']));
      }
      header('Location: detailed-guide-view.php?gid='.$gid);
    }
    if (isset($_POST['saveBtn'])) {
      saveGuide($_SESSION['username'], $gid);
    }
    header('Location: detailed-guide-view.php?gid='.$gid);
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

  <br>

  <div class='container'>
  <a href='browse.php' style='color: grey'>< Back to Browse</a>
  </div>

  <br>

  <div class='container bg-light border border-info p-3' style='overflow-y: scroll;'>
  <h5 class='text-end'><?php echo $date?></h5>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" class='text-end'>
      <input type="submit" class="btn btn-outline-success text-end" style='width: 15vh; align: center' name="saveBtn" value="Save Guide"></input>
    </form>
    <h1><?php echo $title?></h1>
    <p class='fw-bold'><?php echo $location?></p>
    <div>
        <?php echo $creatorDisplay;?>
    </div>
    <div>
        <?php echo $rateDisplay;?>
    </div>
    <form name="ratingForm" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
          <div class="form-group col">
            <select class="custom-select form-control-sm" name="rating">
              <option selected>Rate</option>
              <option value=5>5</option>
              <option value=4>4</option>
              <option value=3>3</option>
              <option value=2>2</option>
              <option value=1>1</option>
            <input type="submit" class="btn btn-primary btn-block btn-sm" name="ratingBtn" value="Submit Rating"></input>
          </div>
    </form>
    <hr/>
    <div class='pt-4'>
      <h4>Description:</h4>
      <p class='pb-2'><?php echo $description?></p>
    </div>
    <div>
      <h4>Activities:</h4>
        <?php echo $activityDisplay;?>
    </div>
    <div>
      <h4>Comments:</h4>
        <?php echo $commentsDisplay;?>
        <form name="commentForm" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
          <div class="form-group row">
            <textarea class="form-control" name="comment" rows="2" placeholder="Leave a Comment Here!" required></textarea>
            <input type="submit" class="btn btn-primary btn-block mb-4 mt-4" name="commentBtn" value="Comment"></input>
          </div>
        </form>
    </div>
  </div>

</body>