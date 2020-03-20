
//function to parse signup input, and redirect to login
//once backend is functional this function will handle semantic parsing of signup input, with user creation, and database validity handled serverside

function addEvent(){
	document.querySelector("#slickButtonBack").addEventListener("click", function(){goHome();});
}

function goHome(){
	window.location.href = "homepage.html";
}
