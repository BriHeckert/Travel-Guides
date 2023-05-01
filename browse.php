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
  $test = "1";

  if (isset($_POST['duration']) and $_POST['duration'] != 'na') {
    $guides = getFilteredGuidesWithDuration($_POST['sortby'], $_POST['sortorder'], $_POST['duration']);
  } else if (isset($_POST['sortby'])) {
    $guides = getFilteredGuides($_POST['sortby'], $_POST['sortorder']);
    $test = $_POST['sortby'] . $_POST['sortorder'];
  } else {
    $guides = getAllGuides();
  }

  // Format guides table
  $guideHTML = "
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
    $loc = $currentGuide['g_id'];
    $date = $currentGuide['date'];
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

  $guideHTML = $guideHTML . "</table>";
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
            <a class="nav-link text-danger text-dark" href="profile.php">My Profile</a>
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

  <?php echo $test?>

  <div class='container' align='center'>
    <form method='post' action='browse.php'>
      <table style="width: 80vw">
        <td>
          <b>Filter by: </b>
        </td>

        <td>
          <input type='radio' id='guidename' name='sortby' value='title' required>
          <label for='guidename'>Guide Title</label>&nbsp&nbsp&nbsp
          <input type='radio' id='guideloc' name='sortby' value='location' required>
          <label for='guideloc'>Location</label>&nbsp&nbsp&nbsp
          <input type='radio' id='guidedate' name='sortby' value='date' required>
          <label for='guideloc'>Date Created</label>
        </td>

        <td>
          <input type='radio' id='orderasc' name='sortorder' value='ASC' required>
          <label for='guidename'>Ascending Order</label>&nbsp&nbsp&nbsp
          <input type='radio' id='orderdesc' name='sortorder' value='DESC' required>
          <label for='guideloc'>Descending Order</label>
        </td>

        <td>
          Duration:
          <select id='guidelength' name='duration' required>
            <option value='na'>Select</option>
            <option value='1'>1 Day</option>
            <option value='2'>2 Days</option>
            <option value='3'>3 Days</option>
            <option value='4'>4 Days</option>
            <option value='5'>5 Days</option>
            <option value='6'>6 Days</option>
            <option value='7'>7 Days</option>
          </select>
        </td>

        <td>
          <input type='submit' value="Filter">
        </td>

      </table>
    </form>
  </div>

  <div class='container' style='overflow-y: scroll; height: 65vh;'>
    <?php echo $guideHTML?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</body>
</html>
