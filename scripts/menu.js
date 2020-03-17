function toggleModal(){
	//get all the images in similar products to monitor for event
	document.querySelector(".modal").classList.toggle("modal--hidden");
	
}

function addEvent(){
	document.querySelector("#showModal").addEventListener("click", function(){toggleModal();});
	document.querySelector("#hideModal").addEventListener("click", function(){toggleModal();});
}