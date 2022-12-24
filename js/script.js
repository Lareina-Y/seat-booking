const container = document.querySelector("td");
const seats = document.querySelectorAll("td .seat:not(.occupied)");
const count = document.getElementById("count");
const total = document.getElementById("total");

const myhidden = document.getElementById("hiddencontainer");

const submitButton = document.getElementById("submitButton");
submitButton.disabled = true; //setting button state to disabled

myhidden.addEventListener("change", stateHandle);

function stateHandle() {
    if (myhidden.value === "") {
        button.disabled = true; //button remains disabled
    } else {
        button.disabled = false; //button is enabled
    }
}

// populateUI();

// let ticketPrice = +movieSelect.value;

// Update total and $count
function updateSelectedCount() {
  const selectedSeats = document.querySelectorAll(".seat.selected");

  const seatsIndex = [...selectedSeats].map((seat) => seat.id);

  // localStorage.setItem("selectedSeats", JSON.stringify(seatsIndex));

  document.getElementById("demo").innerText = "You already seleted Seats: " + seatsIndex;
  document.getElementById("selected-seats").innerHTML = "You already seleted Seats: <strong>" + seatsIndex + "</strong>";
  myhidden.value = seatsIndex;

  const selectedSeatsCount = seatsIndex.length;
  count.innerText = selectedSeatsCount;
  
  // total.innerText = selectedSeatsCount * ticketPrice;
}



// Get data from localstorage and populate UI
// function populateUI() {
  // const selectedSeats = JSON.parse(localStorage.getItem("selectedSeats"));
  // if (selectedSeats !== null && selectedSeats.length > 0) {
  //   seats.forEach((seat, index) => {
  //     document.getElementById(seat).classList.add("selected");
  //   });
  // }
// }

// Seat click event
// container.addEventListener("click", (e) => {
//   if (
//     e.target.classList.contains("seat") &&
//     !e.target.classList.contains("occupied")
//   ) {
//     e.target.classList.toggle("selected");

//     updateSelectedCount();
//   }
// });

// Initial count and total set
updateSelectedCount();


function seatSelected(e, $seatPrice) {
  if (
    e.classList.contains("seat") &&
    !e.classList.contains("occupied")&&
    !e.classList.contains("reserved")
  ) {

    if (e.classList.contains("selected")){
      e.classList.remove("selected");
      total.innerText = parseInt(total.innerText) - parseInt($seatPrice);
    } else {
      e.classList.add("selected");
      total.innerText = parseInt(total.innerText) + parseInt($seatPrice);
    }

    // e.classList.toggle("selected");
    updateSelectedCount();
    
    // total.innerText = parseInt(total.innerText) + parseInt($seatPrice);
    // total.innerText = $check;
  }
}

function resetClick() {
  location.reload();
}

