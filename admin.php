<?php
    require_once "includes/header.php";

    /* ================= Admin log in process ==================  */

    session_start(); // start the session
    $error = false; // use to check if need to show the error message

    if (isset($_POST['a-login'])) {

      // Set some values to the session variable
      $uname = sanitizeData($_POST['a-uname']); 
      $l_password = sanitizeData($_POST['a-password']);

      // $hashed_password = password_hash($l_password, PASSWORD_DEFAULT);

      $matchSQL = "SELECT * FROM `dcssaAdmin` WHERE `username` = '{$uname}'";
      $result = $conn->query($matchSQL);

      if ($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $checkPassword = $row['password'];

        if (password_verify($l_password, $checkPassword)) {

          // Regenerate session ID
          session_regenerate_id(); // --> will not destroy old session

          $_SESSION['role'] = 'admin';
          $_SESSION['uname'] = $uname;

          $error = false;
        } else {
          // if password not matched, then show the error message
          $error = true;
        }
      } else {
        $error = true;
      }
    }

    $page = $_GET['tab'] ?? '';

    if(isset($_POST['create-table'])){

        // sanitize the input Data
        $name = stripslashes(htmlspecialchars(trim($_POST['tname'])));
        $noOfSeats = stripslashes(htmlspecialchars(trim($_POST['no-of-seats'])));
        $price = stripslashes(htmlspecialchars(trim($_POST['price'])));

        //citation: https://www.php.net/manual/en/function.date.php
        // set the default timezone to use.
        date_default_timezone_set('Canada/Atlantic');
        $date = date("Y-m-d H:i:s");

        $insertSQL = "INSERT INTO `tables`(`table_number`, `no_of_seats`, `price`) VALUES ('".$name."','".$noOfSeats."','".$price ."')";

        // (4) Execute query
        $done = $conn->query($insertSQL);

        for ($i = 0; $i <$noOfSeats; $i++) {
            $seatSQL = "INSERT INTO `seats`(`seat_name`,`table_number`) VALUES ('". $name . "-" .($i+1)."','".$name."')";
            $insertSeat = $conn->query($seatSQL);
        }       
        if (!$done) {
            // Redirect the seller to the show=posted page.
            header ("Location: upload.php?failure");
            echo 'done for ' + $name;
            ob_end_flush();
            die();
        }
    }   

?>
<main>

<h1>Admin</h1>
<?php
    if (!isset($_SESSION['role'])) {
?>

<section class="vh-100">
  <div class="container-fluid h-custom">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-md-9 col-lg-6 col-xl-5">
        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
          class="img-fluid" alt="Sample image">
      </div>
      <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
        <form method='post'>
          <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
            <h3 class="fw-normal mb-0 me-3">Sign In</h3>
          </div>

          <div class="divider d-flex align-items-center my-4"></div>

          <!-- UserName input -->
          <div class="form-outline mb-4">
            <input type="text" id="form3Example3" name='a-uname' class="form-control form-control-lg"
              placeholder="Enter Admin Username" />
          </div>

          <!-- Password input -->
          <div class="form-outline mb-3">
            <input type="password" id="form3Example4" name='a-password' class="form-control form-control-lg"
              placeholder="Enter password" />
          </div>

          <!-- show the error message -->
							<?php
								if ($error) {
									// when the user info is not matched...
									echo "<div class='col-md-12'>" . PHP_EOL;
									echo "<p class='text-danger'>* Wrong username or password.</p>" . PHP_EOL;
									echo "</div>" . PHP_EOL;
								}	
							?>
          <div class="text-center text-lg-start mt-4 pt-2">
            <button type="submit" class="btn btn-primary btn-lg"
              style="padding-left: 2.5rem; padding-right: 2.5rem;" name='a-login'>Login</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

<?php
    } else {
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark showcase mb-5">
  <a class="navbar-brand" href="">Navbar: </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item <?php echo ($page == "") ? "active" : ""; ?>">
        <a class="nav-link" href="admin.php">Booking Lists</a>
      </li>
      <li class="nav-item <?php echo ($page == "create-table") ? "active" : ""; ?>">
        <a class="nav-link" href="admin.php?tab=create-table">Create New Table</a>
      </li>
      <li class="nav-item">
        <a class="btn btn-primary" href="index.php" role="button">Back to User Page</a>
      </li>
      <li class="nav-item">
        <a class="btn btn-primary" href="includes/logout.php" role="button">Log out</a>
      </li>
    </ul>
    <?php
      if($page == "") {
    ?>
    <!-- <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form> -->
    <?php
      }
    ?>
  </div>
</nav>


<?php
  
  switch ($page) {
    case 'create-table':
      include 'includes/createTable.php';
      break;
    default:
      include 'includes/bookingList.php';
      break;
  }

}

?>
  
</main> 


<?php
    require_once "includes/footer.php";
?>
