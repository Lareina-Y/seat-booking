const container = document.querySelector("td");
const seats = document.querySelectorAll("td .seat:not(.occupied)");
const count = document.getElementById("count");
const total = document.getElementById("total");
const totalPrice = document.getElementById("total-price");

const myhidden = document.getElementById("hiddencontainer");
const submitButton = document.getElementById("submitButton");

function stateHandle() {
    if (myhidden.value === "") {
      submitButton.disabled = true; //button remains disabled
    } else {
      submitButton.disabled = false; //button is enabled
    }
}

// Update total and $count
function updateSelectedCount() {
  const selectedSeats = document.querySelectorAll(".seat.selected");

  const seatsIndex = [...selectedSeats].map((seat) => seat.id);

  document.getElementById("demo").innerText = "You already seleted Seats: " + seatsIndex;
  document.getElementById("selected-seats").innerHTML = "You already seleted Seats: <strong>" + seatsIndex + "</strong>";
  myhidden.value = seatsIndex;

  const selectedSeatsCount = seatsIndex.length;
  count.innerText = selectedSeatsCount;
  stateHandle();
}

// Initial count and total set
updateSelectedCount();


function seatSelected(e, $seatPrice) {
  if (
    e.classList.contains("seat") &&
    !e.classList.contains("occupied")&&
    !e.classList.contains("reserved")
  ) {

    if (e.classList.contains("selected")){
      total.innerText = parseInt(total.innerText) - parseInt($seatPrice);
      totalPrice.innerText = parseInt(totalPrice.innerText) - parseInt($seatPrice);
      e.classList.remove("selected");
    } else {
      total.innerText = parseInt(total.innerText) + parseInt($seatPrice);
      totalPrice.innerText = parseInt(totalPrice.innerText) - parseInt($seatPrice);
      e.classList.add("selected");
    }

    updateSelectedCount();
  }
}

function resetClick() {
  location.reload();
}

function deleteBooking(e) {
  var r = confirm("Will you delete the Booking for Seat " + e.id + "?");
  if (r == true) {
      window.location.href = "admin.php?delete=" + e.id;
  } 
}

function paid(e) {
  var r = confirm("Seat " + e.id + " already be paid?");
  if (r == true) {
      window.location.href = "admin.php?paid=" + e.id;
  } 
}

function unpaid(e) {
  var r = confirm("Seat " + e.id + " hasn't be paid?");
  if (r == true) {
      window.location.href = "admin.php?unpaid=" + e.id;
  } 
}

