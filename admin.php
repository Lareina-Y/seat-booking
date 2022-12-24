<?php
    require_once "includes/header.php";

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

?>
  
</main> 


<?php
    require_once "includes/footer.php";
?>
