<?php

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
            // header ("Location: upload.php?failure");
            echo 'Something went wrong';
            ob_end_flush();
            die();
        }
    }   
?>

<section id="contact-section mt-3">
    <div class="container">
      <div class="col-md-8 col-lg-9">
        <form action="" class="form-contact contact_form" method="post" >
          <div class="form-group">
            <input class="form-control" name="tname" id="tname" type="text" placeholder="Table Name" required>
          </div>
          <div class="form-group">
            <input class="form-control" name="no-of-seats" id="no-of-seats" type="number" placeholder="Number of seats" value = "8" required>
          </div>
          <div class="form-group">
            <input class="form-control" name="price" id="no-of-seats" type="number" placeholder="Price" value = "15" required>
          </div>
          <div class="form-group text-center">
            <button type="submit" class="btn btn-primary" id="submit" name="create-table" >create</button>
          </div>
        </form>
      </div>
    </div>
  </section>
