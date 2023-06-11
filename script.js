function showBidUI(isLogIn) {
	console.log(isLogIn)
	if (isLogIn === 0) {
		console.log("Attempt to go to login page")
		window.location.href = "./login.php";
	} else {
		console.log("Show the UI")
	}
}