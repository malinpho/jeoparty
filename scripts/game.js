// cards array holds all cards
let card = document.getElementsByClassName("card");
let cards = [...card];



// display question and remove event listener
var displayCard = function (){
  // show question
  //document.getElementById("myNav").style.height = "100%";
  openNav();
  // disable card
  this.classList.add("disable");

  // remove event listener so it cannot be clicked again
  this.removeEventListener("click", displayCard);

}

function openNav() {
  document.getElementById("myNav").style.height = "100%";
}


function closeNav() {
  document.getElementById("myNav").style.height = "0%";
}
// loop to add event listeners to each card
for (var i = 0; i < cards.length; i++){
  card = cards[i];
  card.addEventListener("click", displayCard);
};
