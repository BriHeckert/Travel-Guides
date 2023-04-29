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

  $guide = getGuideDetails($gid);
  $activities = getGuideActivities($gid);

  $title = $guide['title'];
  $date = $guide['date'];
  $description = $guide['description'];
  $location = $guide['location'];
  $duration = $guide['duration'];
  $author = 'Travel Buddy :)';
  if ($guide['user_email']){
    $author = getName($guide['user_email']) . " " .getLastName($guide['user_email']);
  }
  
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

  ?>

<body>
  <!-- navbar stuff -->
  <nav class="navbar navbar-expand-lg navbar-light justify-content-between" style="background-color: #e3f2fd;">
    <div class="container">
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

  <br>
  
  <br>

  <div class='container bg-light border border-info p-3' style='overflow-y: scroll;'>
    <h4 class='text-end'><?php echo $date?></h3>
    <h1><?php echo $title?></h1>
    <p class='fw-bold'><?php echo $location?></p>
    <p>By: <?php echo $author?></p>
    <hr/>
    <div class='pt-4'>
      <h4>Description:</h4>
      <p class='pb-2'><?php echo $description?></p>
    </div>
    <div>
      <h4>Activities:</h4>
        <?php echo $activityDisplay;?>
    </div>
  </div>

</body>