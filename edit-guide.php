<html><head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Brianna Heckert, August Lamb, Alex Walsh">
    <meta name="description" content="Travel Guides Detailed Guide">  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css" type="text/css">
    <title>Edit Guide</title>
  </head>

  <?php 
  require("connect-db.php");
  require("sql-queries.php");
  session_start();
  if (!isset($_SESSION['username'])){
    header('Location: index.php');
  }

  $firstName = getName($_SESSION['username']);
  $gid = trim($_GET['gid']);
  $guide = getGuideDetails($gid);
  $old_title = $guide['title'];
  $old_days = $guide['duration'];
  $old_loc = explode(", ", $guide['location']);
  $old_city = $old_loc[0];
  $old_state = $old_loc[1];
  $old_desc = $guide['description'];
  $activities = getGuideActivities($gid);

  if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (isset($_POST["publishBtn"]) && $guide['user_email'] == $_SESSION['username']) {
      $title = trim($_POST['gtitle']);
      $city = $_POST['gcity'];
      $state = $_POST['gstate'];
      $location = $city . ", " . $state;
      $today = date("Y-m-d");
      editGuide($gid, $title, $today, $location, $old_days, trim($_SESSION['username']));
      $count = 0;
      foreach($activities as $activity){
        $actTitle = $_POST['title'.$count];
        $actTitle = str_replace("'", '', $actTitle);
        $actDesc = $_POST['description'.$count];
        $actDesc = str_replace("'", '', $actDesc);
        $actAddy = $_POST['address'.$count];
        $actAddy = str_replace("'", '', $actAddy);
        editActivity($activity['act_id'], $actTitle, $actDesc, $actAddy);
        $count = $count + 1;
      header('Location: detailed-guide-view.php?gid='.$gid);
      }
    } 
  }
  $activityDisplay = "";

  $count = 0;
  foreach($activities as $activity){
    $actTitle = trim($activity['title']);
    $actTitle = str_replace("'", '', $actTitle);
    $actDesc = trim($activity['description']);
    $actDesc = str_replace("'", '', $actDesc);
    $actAddy = trim($activity['address']);
    $actAddy = str_replace("'", '', $actAddy);
    $newCard = "
            <div class='form-group p-3'>
                <label for='titleInput'>Name of Activity / Title</label>
                <input type='text' class='form-control' placeholder='Activity' id='titleInput' name='title$count' value='$actTitle'>
            </div>
            <div class='form-group p-3'>
                <label for='addressInput'>Address</label>
                <input type='text' class='form-control' placeholder='Address or Location Description - whatever makes sense and would be helpful for finding the activity :)' name='address$count' id='activityInput' value='$actAddy'>
            </div>
            <div class='form-group p-3'>
                <label for='descInput'>Description</label>
                <textarea type='text' class='form-control' placeholder='Description' id='descInput' name='description$count'>$actDesc</textarea>
            </div>
      <br>
    ";
    $activityDisplay = $activityDisplay . $newCard;
    $count = $count + 1;
  };

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
  <a href='profile.php' style='color: grey'>< Back to Profile</a>
  </div>

  <br>

  <div class='container bg-light border border-info p-3' style='overflow-y: scroll;'>
    <h2 class="text-center"> Edit "<?php echo $old_title?>" Guide</h2>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="form-group row p-4">
            <p>Title & Duration:</p>
            <div class='form-group col-10'>
                <input type="text" class="form-control" placeholder="Title" name="gtitle" value="<?php echo $old_title?>" required>
            </div>
            <div class='form-group col-2'>
                <input type="number" class="form-control" placeholder='<?php echo $old_days?>' name="gdays" value='<?php echo $old_days?>' min="1" required>
            </div>
        </div>
        <div class="form-group row p-4">
                <p>Location:</p>
                <div class="form-group col">
                    <input type="text" class="form-control" placeholder='City' name="gcity" value='<?php echo $old_city?>' required>
                </div>
                <div class="form-group col">
                    <select class="custom-select custom-select-lg mb-3 form-control" name="gstate" required>
                        <option selected><?php echo $old_state?></option>
                        <option value="Alabama">Alabama</option>
                        <option value="Alaska">Alaska</option>
                        <option value="Arizona">Arizona</option>
                        <option value="Arkansas">Arkansas</option>
                        <option value="California">California</option>
                        <option value="Colorado">Colorado</option>
                        <option value="Connecticut">Connecticut</option>
                        <option value="Delaware">Delaware</option>
                        <option value="District of Columbia">District of Columbia</option>
                        <option value="Florida">Florida</option>
                        <option value="Georgia">Georgia</option>
                        <option value="Hawaii">Hawaii</option>
                        <option value="Idaho">Idaho</option>
                        <option value="Illinois">Illinois</option>
                        <option value="Indiana">Indiana</option>
                        <option value="Iowa">Iowa</option>
                        <option value="Kansas">Kansas</option>
                        <option value="Kentucky">Kentucky</option>
                        <option value="Louisiana">Louisiana</option>
                        <option value="Maine">Maine</option>
                        <option value="Maryland">Maryland</option>
                        <option value="Massachusetts">Massachusetts</option>
                        <option value="Michigan">Michigan</option>
                        <option value="Minnesota">Minnesota</option>
                        <option value="Mississippi">Mississippi</option>
                        <option value="	Missouri">Missouri</option>
                        <option value="Montana">Montana</option>
                        <option value="Nebraska">Nebraska</option>
                        <option value="Nevada">Nevada</option>
                        <option value="New Hampshire">New Hampshire</option>
                        <option value="New Jersey">New Jersey</option>
                        <option value="New Mexico">New Mexico</option>
                        <option value="New York">New York</option>
                        <option value="North Carolina">North Carolina</option>
                        <option value="North Dakota">North Dakota</option>
                        <option value="Ohio">Ohio</option>
                        <option value="Oklahoma">Oklahoma</option>
                        <option value="Oregon">Oregon</option>
                        <option value="Pennsylvania">Pennsylvania</option>
                        <option value="Rhode Island">Rhode Island</option>
                        <option value="South Carolina">South Carolina</option>
                        <option value="South Dakota">South Dakota</option>
                        <option value="Tennessee">Tennessee</option>
                        <option value="Texas">Texas</option>
                        <option value="Utah">Utah</option>
                        <option value="Vermont">Vermont</option>
                        <option value="Virginia">Virginia</option>
                        <option value="Washington">Washington</option>
                        <option value="West Virginia">West Virginia</option>
                        <option value="Wisconsin">Wisconsin</option>
                        <option value="Wyoming">Wyoming</option>
                    </select>
                </div>
        </div>
        <div class="text-center p-2">
        <h4 class="text-center">Editing Activities for "<?php echo $old_title?>"</h4>
        <?php echo $activityDisplay?>
        <input type="submit" class="btn btn-success btn-block" name="publishBtn" value="Publish Changes"></input>
        </div>
    </form>
    <br>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</body>