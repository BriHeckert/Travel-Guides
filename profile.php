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
            <a class="nav-link text-danger text-dark" href="profile.php"><?php echo $firstName?>'s Page</a>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <!-- body content -->
    <p><?php echo $_SESSION["username"] ?> Profile</p>
</body>