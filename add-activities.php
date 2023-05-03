<html><head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Brianna Heckert, August Lamb, Alex Walsh">
    <meta name="description" content="Travel Guides Detailed Guide">  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css" type="text/css">
    <title>Add Activities</title>
  </head>

  <?php 
  require("connect-db.php");
  require("sql-queries.php");
  session_start();
  if (!isset($_SESSION['username'])){
    header('Location: index.php');
  }
  if (!isset($_SESSION['g_id'])){
    header('Location: browse.php');
  }

// source for function https://www.uuidgenerator.net/dev-corner/php
function guidv4($data = null) {
    // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
    $data = $data ?? random_bytes(16);
    assert(strlen($data) == 16);
  
    // Set version to 0100
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    // Set bits 6-7 to 10
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
  
    // Output the 36 character UUID.
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
  }

  $firstName = getName($_SESSION['username']);
  $gid = $_SESSION['g_id'];
  $g_title = $_SESSION['g_title'];
  $g_today = $_SESSION['g_date'];
  $g_desc = trim($_SESSION['g_desc']);
  $g_location = $_SESSION['g_loc'];
  $g_days = $_SESSION['g_dur'];
  

  if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (!empty($_POST['title']) && !empty($_POST['description']) && !empty($_POST['address'])){
        $act_id = guidv4();
        $title = trim($_POST['title']);
        $description = trim($_POST['description']);
        $address = trim($_POST['address']);
        if (isset($_POST['publishBtn'])){
            createGuide($gid, $g_title, $g_today, $g_desc, $g_location, $g_days, $_SESSION['username']);
            createActivity($gid, $act_id, $title, $description, $address);
            header('Location: profile.php');
            unset($_SESSION["g_id"]);
        }
        if (isset($_POST['addBtn'])){
            createActivity($gid, $act_id, $title, $description, $address);
            header('Location: add-activities.php');
        }
    }
    if (isset($_POST['deleteBtn'])){
        deleteGuide($gid);
        header('Location: browse.php');
        unset($_SESSION["g_id"]);
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

  <br>

  <div class='container bg-light border border-info p-3' style='overflow-y: scroll;'>
    <h2 class="text-center"> Add Activity to "<?php echo $g_title?>" Guide </h2>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="form-group p-3">
            <label for="titleInput">Name of Activity / Title</label>
            <input type="text" class="form-control" placeholder="Activity" id="titleInput" name="title">
        </div>
        <div class="form-group p-3">
            <label for="addressInput">Address</label>
            <input type="text" class="form-control" placeholder="Address or Location Description - whatever makes sense and would be helpful for finding the activity :)" name="address" id="activityInput">
        </div>
        <div class="form-group p-3">
            <label for="descInput">Description</label>
            <textarea type="text" class="form-control" placeholder="Description" id="descInput" name="description"></textarea>
        </div>
        <div class="text-center p-5">
            <input type="submit" class="btn btn-success btn-block" name="publishBtn" value="Publish Guide"></input>
            <input type="submit" class="btn btn-primary btn-block" name="addBtn" value="Add Another Activity"></input>
        </div>
        <div class="p-4 text-center">
            <input type="submit" class="btn btn-danger btn-sm" name="deleteBtn" value="Delete Guide"></input>
            <br>
            <small>By clicking "Delete Guide" you will lose all progress - all activities and guide info will be lost</small>
        </div>
    </form>
    
  </div>

</body>