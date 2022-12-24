<?php
    require_once "includes/header.php";


    if(isset($_POST['submit'])){

      $seletedSeatsString=sanitizeData($_POST["hiddencontainer"]);
      $seatsList = explode(',', $seletedSeatsString);
      // echo '<pre>'; 
      // print_r($seatsList); 
      // echo '</pre>';
      echo json_encode($seatsList);
      $length = count($seatsList);
      
      echo "<div class=''>check: {$length}</div>";

       // sanitize the input Data
       $lname = sanitizeData($_POST['lname']);
       $fname = sanitizeData($_POST['fname']);
       $email = sanitizeData($_POST['email']);
       $wechat = sanitizeData($_POST['wechat']);

      //citation: https://www.php.net/manual/en/function.date.php
      // set the default timezone to use.
      date_default_timezone_set('Canada/Atlantic');
      $date = date("Y-m-d H:i:s");

      // $insertSQL = "INSERT INTO `tables`(`table_number`, `no_of_seats`, `price`) VALUES ('".$name."','".$noOfSeats."','".$price ."')";

      // // (4) Execute query
      // $done = $conn->query($insertSQL);

      // for ($i = 0; $i <$noOfSeats; $i++) {
      //     $seatSQL = "INSERT INTO `seats`(`seat_name`,`table_number`) VALUES ('". $name . "-" .($i+1)."','".$name."')";
      //     $insertSeat = $conn->query($seatSQL);
      // }       
      // if (!$done) {
      //     // Redirect the seller to the show=posted page.
      //     header ("Location: upload.php?failure");
      //     echo 'done for ' + $name;
      //     ob_end_flush();
      //     die();
      // }
  }   
?>
<main >
    <h1>DCSSA | 2023春晚订票</h1>

    <!-- <img src="img/img.png" alt="Responsive image">  -->
    
    <ul class="showcase">
      <li>
        <div class="seat"></div>
        <small>Available</small>
      </li>
      <li>
        <div class="seat label_selected"></div>
        <small>Selected</small>
      </li>
      <li>
        <div class="seat reserved"></div>
        <small>Reserved</small>
      </li>
      <li>
        <div class="seat occupied"></div>
        <small>Occupied</small>
      </li>
    </ul>

    <table>
        <tbody>
        <tr class="no-border">
<?php
    $tablesSQL = "SELECT * FROM `tables` ORDER BY `table_number` ASC";
    $tables = $conn->query($tablesSQL);
    $tableNum = 1;
    if ($tables->num_rows > 0){
      while ($table = $tables->fetch_assoc()) {
          $seatPrice = $table['price'];
          $seatsSQL = "SELECT * FROM `seats` WHERE `table_number` = '" . $table['table_number'] . "' ";
          $seats = $conn->query($seatsSQL);
          echo  "<td class='eachTable'>
                  <table>
                      <tbody>
                          <tr class='no-border'>";
          $seatNum = 1;
          while (($seat = $seats->fetch_assoc())) {
              if ($seat['status'] == 0) {
                  $seatStatus = 'seat';
              } elseif ($seat['status'] == 1) {
                  $seatStatus = 'seat reserved';
              } else {
                  $seatStatus = 'seat occupied';
              }
              if($seatNum == 4) {
                  echo "<td><div class='{$seatStatus}' id='{$seat['seat_name']}' onclick='seatSelected(this, {$seatPrice})'></div></td>";
                  echo "<td><div>{$table['table_number']}</div></td>";
                  $seatNum ++;
              } elseif ($seatNum % 3 != 0) {
                  echo "<td><div class='{$seatStatus}' id='{$seat['seat_name']}' onclick='seatSelected(this, {$seatPrice})'></div></td>";
              } else {
                  echo "<td><div class='{$seatStatus}' id='{$seat['seat_name']}' onclick='seatSelected(this, {$seatPrice})'></div></td>";
                  echo "</tr> <tr>";
              }
              $seatNum ++;
          }

          echo "</tr></tbody></table> </td>";
          
          if  ($tableNum % 6 == 0) {
              echo '</tr> <tr class="no-border">';
          }

          $tableNum ++;
      }
    }
  ?>
     </tr>           
  </tbody>    
</table>
    <p id="demo">You already seleted Seats: </p>
    <p class="text">
      You have selected <span id="count">0</span> seats for a price of
      <span id="$">$</span>
      <span id="total">0</span>
    </p>
    <p></p>
    

<!-- Button trigger modal -->
<button type="button" class="btn btn-secondary" onclick=resetClick()>Reset</button>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Submit
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-text" id="exampleModalLabel">Seat Booking</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" class="" method="post">
        <div class="modal-body">
            <div class="modal-text mb-3" id="selected-seats">You already seleted Seats: </div>
            <div class="mb-3">
              <input class="form-control" name="hiddencontainer" type="text" id="hiddencontainer" disabled required/>
            </div>
            <div class="mb-3">
                <input class="form-control" name="lname"  type="text" placeholder="Last Name" required>
            </div>
            <div class="mb-3">
                <input class="form-control" name="fname"  type="text" placeholder="Fist Name" required>
            </div>
            <div class="mb-3">
                <input type="email" class="form-control" name="email" placeholder="Email" required/>
            </div>
            <div class="mb-3">
                <input class="form-control" name="wechat"  type="text" placeholder="WeChat ID (Optional)">
            </div>
            <div class="mb-1 modal-text">* We'll never share your information with anyone else.</div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" name='submit' id="submit" >Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php
    require_once "includes/footer.php";
?>
    