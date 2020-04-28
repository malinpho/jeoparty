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
var cID;
var c_index = 1;

// display question and remove event listener
var displayCard = function (){
	// show question
	clickedColumn = this.cellIndex;
	clickedRow = this.parentNode.rowIndex;
	var classString = ("c" + (clickedColumn + 1) + "r" + (clickedRow) + "");
	value = document.getElementsByClassName(classString)[0].innerHTML;
	value = value.substring(1);
	//console.log(value);
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
	c_index = 1;
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
					cID = categories[i].id;
					console.log(cID);
					updatedValues(cID);
				}
			});
		}
	)
	.catch(function(err) {
		console.log('Fetch Error :-S', err);
	});
}

function updatedValues(catID){
	var valueElements = document.getElementsByClassName("c" + c_index);
	c_index = c_index + 1
	//get questions value api call
	fetch('https://jservice.io/api/clues?category=' + catID) // returns all questions in category
	.then(
		function(response) {
			if (response.status !== 200) {
				console.log('Looks like there was a problem. Status Code: ' +
				response.status);
				return;
			}
			// Examine the text in the response
			response.json().then(function(data) {
				var valueList = new Array(5);
				for (var x = 0; x < data.length; x++){
					var tempValue = data[x].value
					if (tempValue == null){ // category does not have this question
						location.reload();
						console.log("reloaded");
					}
					else{
						valueList.push(tempValue);
					}
					// can continue to create array for questions and answer with this api call but used another api call
					// it is resoruce extensive but don't matter for this project
				}
				valueList = valueList.sort(sortList);
				for (var y = 0; y < valueList.length; y++){
					valueElements[y].innerHTML = "$" + valueList[y]; // set value displayed for question to api value result
				}
			});
		}
	)
	.catch(function(err) {
		console.log('Fetch Error :-S', err);
	});
}

// sort int list
function sortList(a, b) {
	return a > b ? 1 : b > a ? -1 : 0;
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
  buzzTimer = setTimeout(noBuzz, 10000);

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
  answerTimer = setTimeout(noAnswer, 10000);

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
	value = parseInt(value);
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
