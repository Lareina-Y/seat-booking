<?php
    require_once "includes/header.php";
    if(isset($_POST['submit'])){

      $seletedSeatsString=sanitizeData($_POST['selectedSeats']);
      $seatsList = explode(',', $seletedSeatsString);
       // sanitize the input Data
       $lname = sanitizeData($_POST['lname']);
       $fname = sanitizeData($_POST['fname']);
       $email = sanitizeData($_POST['email']);
       $wechat = sanitizeData($_POST['wechat']);

      //citation: https://www.php.net/manual/en/function.date.php
      // set the default timezone to use.
      date_default_timezone_set('Canada/Atlantic');
      $date = date("Y-m-d H:i:s");

      if ($seatsList !== [""]) {
        foreach ( $seatsList as $seatName) {
          
          $checkExistSQL = "SELECT `seat_name`, `status` FROM `booking` WHERE `seat_name` = '{$seatName}'";
          $checkExist = $conn->query($checkExistSQL);

          if ($checkExist->num_rows > 0){
            $bookingExist = $checkExist->fetch_assoc();
            if ($bookingExist['status'] == 1) {
              $bookingExistStatus = 'Reserved !';
            } else{
              $bookingExistStatus = 'Occupied !';
            }
            echo "<div class='p-3 mb-2 bg-danger text-white'>{$bookingExist['seat_name']} already be {$bookingExistStatus}</div>";
          } else {
            $insertBookingSQL = "INSERT INTO `booking`(`seat_name`, `updateTime`, `lastName`, `firstName`, `email`, `weChat`) VALUES ('{$seatName}','{$date}','{$lname}','{$fname}','{$email}','{$wechat}')";
            $upsateSeatStatusSQL = "UPDATE `seats` SET `status`= 1 WHERE `seat_name` = '{$seatName}'";
            $addBooking = $conn->query($insertBookingSQL);
            $upsateSeatStatus = $conn->query($upsateSeatStatusSQL);
            if (!$addBooking || !$upsateSeatStatus) {
              echo "<div class='showcase p-2 mb-2 bg-danger text-white'>Unsuccessfully book the Seat: {$seatName}, Something wrong!</div>";
                die();
            } else {
              echo "<span class='showcase p-2 mb-2 bg-success text-white'>Successfully book the Seat: {$seatName}, Please e-transfer in 24hr for the e-ticket!</span>";
            }
          }
        }
      }
  }   
?>
<main >
    <h2>DCSSA | 2023春晚订票</h2>
    <h7>若有任何问题请及时与官微联系，官方微信号：Dalhousie_DCSSA</h7>
    <section>
    <ul class="showcase mt-2">
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

    <div class='frontStage'> 
      <div class="screen" id='screen1'>Screen</div>
      <div class="stage">Stage</div>
      <div class="screen" id='screen2'>Screen</div>
    </div>
   
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
</section>

<section>
    <p id="demo">You already seleted Seats: </p>
    <p class="text">
      You have selected <span id="count">0</span> seats for a price of
      <span id="$">$</span>
      <span id="total">0</span>
    </p>
    <p></p>
    

  <!-- Button trigger modal -->
  <button type="button" class="btn btn-secondary" onclick=resetClick()>Reset</button>
  <button type="button" class="btn btn-primary" id="submitButton" data-toggle="modal" data-target="#exampleModal" disabled>
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
              <div class="modal-text mb-2" id="selected-seats">You already seleted Seats: </div>
              <div class="modal-text mb-3">Total Price: <strong>$<span id="total-price">0</span></strong></div>
              <div class="mb-3">
                <input class="form-control" name="selectedSeats" type="hidden" id="hiddencontainer" required/>
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
              <button type="submit" class="btn btn-primary" name='submit'>Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
 
<?php
    require_once "includes/footer.php";
?>
    