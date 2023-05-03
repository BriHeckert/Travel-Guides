<html><head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Brianna Heckert, August Lamb, Alex Walsh">
    <meta name="description" content="Travel Guides Browse">  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css" type="text/css">
    <title>Browse</title>
  </head>

  <?php 
  require("connect-db.php");
  require("sql-queries.php");
  session_start();
  if (!isset($_SESSION['username'])){
    header('Location: index.php');
  }

  $firstName = getName($_SESSION['username']);

  // Prepare guide query
  $guides = [];

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['search']) && (!empty($_POST['loc'])) && (isset($_POST['duration']) and $_POST['duration'] != 'na')) {
      $loc = trim($_POST['loc']);
      $dur = $_POST['duration'];
      $guides = getGuidesWithLocDur($loc, $dur);
    } else if (!empty($_POST['search']) && (isset($_POST['duration']) and $_POST['duration'] != 'na')) {
      $guides = getGuidesWithDuration($_POST['duration']);
    } else if (!empty($_POST['search']) && (!empty($_POST['loc']))) {
      $loc = trim($_POST['loc']);
      $guides = getGuidesWithLocation($loc);
    } else {
      $guides = getAllGuides();
    }
  } else {
    $guides = getAllGuides();
  }

  // Format guides table
  $guideHTML = "<br><br><center>No guides found, please widen your search parameters.</center>";

  if (count($guides) > 0) {
    $guideHTML = "
    <div class='container' style='overflow-y: scroll; height: 65vh;'>
    <table class='table table-striped table-hover table-bordered'>
      <tr>
        <th>Guide</th>
        <th>Location</th>
        <th>Description</th>
        <th>Date Created</th>
      </tr>
    ";

    for ($i = 0; $i < count($guides); $i++) {
      $currentGuide = $guides[$i];
      $title = $currentGuide['title'];
      $desc = $currentGuide['description'];
      $loc = $currentGuide['location'];
      $date = $currentGuide['g_date'];
      $gid = $currentGuide['g_id'];
      $newRow = "
      <tr>
        <td onclick='location.href=`detailed-guide-view.php?gid=$gid`'>$title</td>
        <td onclick='location.href=`detailed-guide-view.php?gid=$gid`'>$loc</td>
        <td onclick='location.href=`detailed-guide-view.php?gid=$gid`'>$desc</td>
        <td onclick='location.href=`detailed-guide-view.php?gid=$gid`'>$date</td>
      </tr>
      ";

      $guideHTML = $guideHTML . $newRow;
    }

    $guideHTML = $guideHTML . "</table></div>";
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
    <h1>Welcome, <?php echo $firstName?>!</h1>
    <h4>Check out our available guides:</h4><br>
  </div>

  <div class='container'>
        <form name="searchForm" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
          <div class="input-group" style='width: 70vw'>
          <table style='width: 100vw'>
            <td>
            <input class="form-control" type="search" placeholder="Search locations by City, State" id="loc" name="loc" aria-label="Search">
            </td>
            <td></td>
            <td>
            <select id='guidelength' name='duration' required>
              <option value='na' selected disabled>Select Duration</option>
              <option value='1'>1 Day</option>
              <option value='2'>2 Days</option>
              <option value='3'>3 Days</option>
              <option value='4'>4 Days</option>
              <option value='5'>5 Days</option>
              <option value='6'>6 Days</option>
              <option value='7'>7 Days</option>
            </select>
            </td>
            <td></td>
            <td>
            <input type="submit" class="btn btn-primary" name="search" value="Search"></input>
            <input type="submit" class="btn btn-warning" name="clear" value="Clear Filters"></input>
            </td>
          </table>
          </div>
        </form>
  </div>

  <?php echo $guideHTML?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</body>
</html>
