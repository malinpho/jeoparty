
//function to parse signup input, and redirect to login
//once backend is functional this function will handle semantic parsing of signup input, with user creation, and database validity handled serverside
function signup(){
	var user = document.getElementById("username").value;
	var pass = document.getElementById("password").value;
	var name = document.getElementById("name").value;
	var errorMessage = "";

	if (user == ""){
		errorMessage += "You must enter a username. ";
	}

	if (pass == "") {
		errorMessage += "You must enter a password. ";
	} else if (pass.length < 6 || pass.length > 20) {
		errorMessage += "You must enter a password with a length of 6 to 20 characters. ";
	} else {
		var numericFlag = 0;
		for (var i = pass.length - 1; i >= 0; i--) {
			if (! isNaN(pass[i]) ) {

				numericFlag = 1;
				break;
			}
		}

		if (numericFlag == 0){
			errorMessage += "Your password must contain a number. " + numericFlag;
		}
	}
	
	if (name == "") {
		errorMessage += "You must enter a name. ";
	}

	if (errorMessage == "") {
		window.location.href = "login.html";
	} else {
		window.alert(errorMessage);

	}
	
}