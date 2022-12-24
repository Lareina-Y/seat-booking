<?php
   $bookingsSQL = "SELECT * FROM `booking`";
   $bookings = $conn->query($bookingsSQL);
   
   if(isset($_GET['delete'])) {
    $deleteSQL = "DELETE FROM `booking` WHERE `seat_name` = '{$_GET['delete']}'";
    $upsateSeatStatusSQL = "UPDATE `seats` SET `status`= 0 WHERE `seat_name` = '{$_GET['delete']}'";
    $delete = $conn->query($deleteSQL);
    $upsateSeatStatus = $conn->query($upsateSeatStatusSQL);
   }

     //citation: https://www.php.net/manual/en/function.date.php
    // set the default timezone to use.
    date_default_timezone_set('Canada/Atlantic');
    $date = date("Y-m-d H:i:s");

   if(isset($_GET['paid'])) {
    $paidSQL = "UPDATE `booking` SET `status`= 2,`updateTime`='{$date}' WHERE `seat_name` = '{$_GET['paid']}'";
    $upsateSeatStatusSQL = "UPDATE `seats` SET `status`= 2 WHERE `seat_name` = '{$_GET['paid']}'";
    $paid = $conn->query($paidSQL);
    $upsateSeatStatus = $conn->query($upsateSeatStatusSQL);
   }

   if(isset($_GET['unpaid'])) {
    $unpaidSQL = "UPDATE `booking` SET `status`= 1,`updateTime`='{$date}' WHERE `seat_name` = '{$_GET['unpaid']}'";
    $upsateSeatStatusSQL = "UPDATE `seats` SET `status`= 1 WHERE `seat_name` = '{$_GET['unpaid']}'";
    $unpaid = $conn->query($unpaidSQL);
    $upsateSeatStatus = $conn->query($upsateSeatStatusSQL);
   }

?>

<table class="table table-hover table-dark">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Seat</th>
      <th scope="col">Status</th>
      <th scope="col">Paid/Unpaid</th>
      <th scope="col">Update Date</th>
      <th scope="col">Last Name</th>
      <th scope="col">First Name</th>
      <th scope="col">Email</th>
      <th scope="col">WeChat</th>
      <th scope="col">Delete</th>
    </tr>
  </thead>
  <tbody>
<?php
    $bookingsSQL = "SELECT * FROM `booking`";
    $bookings = $conn->query($bookingsSQL);
    if ($bookings->num_rows > 0){
        while ($booking = $bookings->fetch_assoc()) {
            if ($booking['status'] == 1) {
                $bookingStatus = '<span class="text-warning">Reserved</span>';
                $updateStatusButton = "<button class='btn btn-outline-warning' type='submit' id='{$booking['seat_name']}' onclick=paid(this)>Paid</button>";
            } else{
                $bookingStatus = 'Occupied';
                $updateStatusButton = "<button class='btn btn-outline-info' type='submit' id='{$booking['seat_name']}' onclick=unpaid(this)>UnPaid</button>";
            }
            $row = <<<ENDDELETESTRING
            <tr>
                <th scope="row">{$booking['booking_id']}</th>
                <td>{$booking['seat_name']}</td>
                <td>{$bookingStatus}</td>
                <td>{$updateStatusButton}</td>
                <td>{$booking['updateTime']}</td>
                <td>{$booking['lastName']}</td>
                <td>{$booking['firstName']}</td>
                <td>{$booking['email']}</td>
                <td>{$booking['weChat']}</td>
                <td><button class="btn btn-outline-danger" type="submit" id='{$booking['seat_name']}' onclick=deleteBooking(this)>Delete</button></td>
            </tr>
        ENDDELETESTRING;

        echo $row . PHP_EOL;

        }
    }
?>
  </tbody>
</table>
