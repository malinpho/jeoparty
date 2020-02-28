// cards array holds all cards
let card = document.getElementsByClassName("card");
let cards = [...card];




// @description toggles open and show class to display cards
var displayCard = function (){
    this.innerHTML="question will appear here";
    this.classList.add("show");
};


// loop to add event listeners to each card
for (var i = 0; i < cards.length; i++){
  card = cards[i];
  card.addEventListener("click", displayCard);

};
