// cards array holds all cards
let card = document.getElementsByClassName("questionCard");
let cards = [...card];

var answerTimer;
var buzzTimer;
var keyboardInput;
var categories = new Array(6);
var clickedColumn; // will change per click
var clickedRow; // will change per click
var value; // will change per click
var question; // will change per click
var answer; // will change per click
var isRight;
var inputedAnswer;
var runningScore = 0;

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

function saveScore(){
	$.ajax({
        url: "saveScore.php",
        type: "POST",
        data: {score:runningScore},
        success: function(data) {
            console.log(data);
        }
	});
	window.location.href = 'menu.php';
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
				var elementsId = document.getElementsByClassName("categoryId");
				for (i = 0; i < data.length; i++) {
					categories[i] = (data[i]);
					elements[i].innerHTML = categories[i].title.toUpperCase();
					elementsId[i].innerHTML = categories[i].id;
					// console.log(elementsId[i].innerHTML)
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
				answer = data[0].answer.toLowerCase().trim()
				//console.log(question)
				var element = document.getElementById("question");
				element.innerHTML = question.toUpperCase();
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

function waitForBuzz() {
  // start timer for 10 seconds
  buzzTimer = setTimeout(noBuzz, 7500);

  //answer question
  document.addEventListener("keydown", spaceInput);
}

function noBuzz() {
  popUpMessage("Time is up! You did not buzz in.");
  document.removeEventListener("keydown", spaceInput);
  closeNav();
}

function spaceInput(key) {
  if (key.keyCode == "32") {
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

  // add timer for user to answer question:
  answerTimer = setTimeout(noAnswer, 7500);

  //answer question
  document.addEventListener("keydown", enterInput);

}

// check if answer matches the correct answer from api call
function enterInput(key) {
  if (key.keyCode == "13") {
	inputedAnswer = document.getElementById("answerInput").value.toLowerCase().trim();
    clearTimeout(answerTimer);
	document.getElementById("myModal").style.display = "none";
	document.removeEventListener("keydown", enterInput);
	closeNav();
	if (inputedAnswer == answer) {
		isRight = 1;
	}
	else{
		isRight = 2;
	}
	results();
  }
}

function popUpMessage(message) {
	// show pop-up
	document.getElementById("gameModal").style.display = "flex";
	document.getElementById("gameModalContent").innerHTML = message;

	// wait a few seconds before closing modal
	setTimeout(function(){
    	document.getElementById("gameModal").style.display = "none";
		}, 2000);

}

function hideMessage() {
		document.getElementById("gameModal").style.display = "none";
}

function noAnswer() {
  document.getElementById("myModal").style.display = "none";
  closeNav();
	popUpMessage("You have not answered in time!");
  document.removeEventListener("keydown", enterInput);
  isRight = 3;
  results();
}

// display result MALIN HERE
function results(){
	//(isRight + " " + answer + " " + inputedAnswer)
	// add or subtract points accordingly

	addToGameLog("The question was: " + question);

	var score = document.getElementById("currentScore");
	if (isRight == 1){
		popUpMessage("Correct! '" + answer + "' was right!");
		addToGameLog("You answered correctly! '" + answer + "' was the answer. You got $" + value + ".");
		runningScore = runningScore + value;
	}
	else if (isRight == 2){
		popUpMessage("Incorrect! Answer is '" + answer + "'");
		addToGameLog("You answered incorrectly! '" + answer + "' was the answer. (You said '" + inputedAnswer + "'). You lost $" + value + ".");
		runningScore = runningScore - value;
	} else {
		popUpMessage("You have not answered in time! Answer was '" + answer + "'");
			addToGameLog("You didn't answer in time! '" + answer + "' was the answer. You lost $" + value + ".");
		runningScore = runningScore - value;
	}
	score.innerHTML = "$" + runningScore; //updates score on side menue

}

function addToGameLog(message) {
  $("#gameLog").append("<p>" + message + "</p>");

}

// loop to add event listeners to each card
for (var i = 0; i < cards.length; i++){
  card = cards[i];
  card.addEventListener("click", displayCard);
};
