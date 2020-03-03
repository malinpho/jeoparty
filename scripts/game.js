// cards array holds all cards
let card = document.getElementsByClassName("card");
let cards = [...card];

var answerTimer;

var keyboardInput;



// display question and remove event listener
var displayCard = function (){
  // show question
  //document.getElementById("myNav").style.height = "100%";

  openNav();
  // disable card
  waitForBuzz();
  this.classList.add("disable");

  // remove event listener so it cannot be clicked again
  this.removeEventListener("click", displayCard);
}

function openNav() {
  document.getElementById("questionPrompt").style.height = "100%";
}

function closeNav() {
  document.getElementById("questionPrompt").style.height = "0%";
}

function waitForBuzz() {
  // start timer for 10 seconds
  answerTimer = setTimeout(noAnswer, 2000);

  // //answer question
  $(window).keydown(function(e) {
    if (e.keyCode == 32) {
      alert('Space pressed');
      clearTimeout(answerTimer);
    }
  });

}

function noAnswer() {
  alert("Time is up! No participants buzzed in.");
}
// loop to add event listeners to each card
for (var i = 0; i < cards.length; i++){
  card = cards[i];
  card.addEventListener("click", displayCard);
};
