// cards array holds all cards
let card = document.getElementsByClassName("card");
let cards = [...card];

var answerTimer;
var buzzTimer;
var keyboardInput;
var categories = new Array(6);
var clickedColumn; // will change per click
var clickedRow; // will change per click
var value; // will change per click
var question; // will change per click


// display question and remove event listener
var displayCard = function (){
	// show question
	//document.getElementById("myNav").style.height = "100%";
	//alert("clicked cell at: " + this.cellIndex + ", " + this.parentNode.rowIndex);
	clickedColumn = this.cellIndex;
	clickedRow = this.parentNode.rowIndex;
	switch (clickedRow) {
	  case 1:
		value = 200;
		break;
	  case 2:
		 value = 400;
		break;
	  case 3:
		value = 600;
		break;
	  case 4:
		value = 800;
		break;
	  case 5:
		value = 1000;
		break;
	  default:
		value = 200;
	}
	// get question then set questions
	getQuestion();
	openNav();
	//disable card
	waitForBuzz();
	this.classList.add("disable");
	// // remove event listener so it cannot be clicked again
	this.removeEventListener("click", displayCard);
}

// function for API call to get categories
function getCategories(){
	var offset = Math.floor(Math.random() * Math.floor(1000)); // using 1000 but should be number of categories in api database
	fetch('https://jservice.io/api/categories?count=6&offset=' + offset) // get 6 categories json
	.then(
		function(response) {
			if (response.status !== 200) {
				console.log('Looks like there was a problem. Status Code: ' +
				response.status);
				return;
			}

			// Examine the text in the response
			response.json().then(function(data) {
				var i;
				// update game screen categories
				var elements = document.getElementsByClassName("categoryContent"); // should be equal to # of categories called (6)
				for (i = 0; i < data.length; i++) {
					categories[i] = (data[i]);
					elements[i].innerHTML = categories[i].title.toUpperCase();
					//console.log(elements[i].innerHTML);
					//console.log(categories[i].title); // .title for title, .id for id
				}
			});
		}
	)
	.catch(function(err) {
		console.log('Fetch Error :-S', err);
	});
}


function getQuestion(){
	fetch('https://jservice.io/api/clues?category=' + categories[clickedColumn].id + '&value=' + value) // get question for column and row value
	.then(
		function(response) {
			if (response.status !== 200) {
				console.log('Looks like there was a problem. Status Code: ' +
				response.status);
				return;
			}
			// Examine the text in the response
			response.json().then(function(data) {
				question = data[0].question
				//console.log(question)
				var element = document.getElementById("question");
				element.innerHTML = question
			});
		}
	)
	.catch(function(err) {
		console.log('Fetch Error :-S', err);
	});
}

function openNav() {
	document.getElementById("questionPrompt").style.height = "100%";

}

function closeNav() {
  document.getElementById("questionPrompt").style.height = "0%";
}

function openScore() {
  document.getElementById("sideScore").classList.add("show");
}

function closeScore() {
  document.getElementById("sideScore").classList.remove("show");
}

function waitForBuzz() {
  // start timer for 10 seconds
  buzzTimer = setTimeout(noBuzz, 5000);

  //answer question
  document.addEventListener("keydown", spaceInput);
}

function noBuzz() {
  alert("Time is up! No buzzed in.");
  document.removeEventListener("keydown", spaceInput);
  closeNav();
}

function spaceInput(key) {
  if (key.keyCode == "32") {
    alert("You have buzzed in! Press enter to submit your answer.");
    clearTimeout(buzzTimer);
    // to add to css

    openKeyboard();

    document.removeEventListener("keydown", spaceInput);
  }
}

function openKeyboard(){
  // show pop-up
  document.getElementById("myModal").style.display = "flex";

  //make cursor go to textbox automatically
  document.getElementById("answerInput").focus();
  document.getElementById("answerInput").select();

  // add timer for user to enter QUESTION:

  answerTimer = setTimeout(noAnswer, 5000);

  //answer question
  document.addEventListener("keydown", enterInput);

}

function enterInput(key) {
  if (key.keyCode == "13") {
    alert("You have answered!");
    clearTimeout(answerTimer);
    document.getElementById("myModal").style.display = "none";
    closeNav();
    document.removeEventListener("keydown", enterInput);
  }
}

function noAnswer() {
  alert("You have not answered in time!");
  document.getElementById("myModal").style.display = "none";
  closeNav();
  document.removeEventListener("keydown", enterInput);
}

// loop to add event listeners to each card
for (var i = 0; i < cards.length; i++){
  card = cards[i];
  card.addEventListener("click", displayCard);
};
