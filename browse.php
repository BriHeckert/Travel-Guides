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

  // Retrieve all guides
  global $db;
  $queryAllGuides = 'SELECT * FROM guides;';
  $statement = $db->prepare($queryAllGuides);
  $statement->execute();
  $allGuides = $statement->fetchAll();
  $statement->closeCursor();

  // Format guides table
  $guideHTML = "
  <table class='table table-striped table-hover table-bordered'>
    <tr>
      <th>Guide</th>
      <th>Description</th>
      <th>Date Created</th>
    </tr>
  ";

  for ($i = 0; $i < count($allGuides); $i++) {
    $currentGuide = $allGuides[$i];
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

    $guideHTML = $guideHTML . $newRow;
  }

  $guideHTML = $guideHTML . "</table>"
  ?>

<body>
  <!-- navbar stuff -->
  <nav class="navbar navbar-expand-lg navbar-light justify-content-between" style="background-color: #e3f2fd;">
    <div class="container">
      <div class="col">
        <a class="navbar-brand">Travel Buddy</a>
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
            <a class="nav-link text-danger text-dark" href="profile.php"><?php echo $firstName?>'s Page</a>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <!-- body content -->
  <br>

  <div class='container'>
    <h1>Welcome, <?php echo $firstName?>!</h1>
    <h3>Check out our available guides:</h3>
  </div>
  
  <br>

  <div class='container' style='overflow-y: scroll; height: 70vh;'>
    <?php echo $guideHTML?>
  </div>
</body>