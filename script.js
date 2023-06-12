function showBidUI(isLogIn, part) {
	console.log(isLogIn, part)
	if (isLogIn === 0) {
		console.log("Attempt to go to login page")
		window.location.href = "./login.php"
	} else {
		console.log("Show the UI")

		if (part === "main") {
			var marketplace = document.getElementById("marketplace")
			var info = document.getElementById("main_bid_info")
			var button = document.getElementById("main_bid_button")
			marketplace.classList.toggle("opened_main_bid")
			info.classList.toggle("opened_main_bid_container")
			button.classList.toggle("opened_main_bid_button")
		} else if (part === "gallery1") {
			//var marketplace = document.getElementById("marketplace")
			var info = document.getElementById("gallery_1_bid_info")
			var button = document.getElementById("gallery_1_bid_button")
			//marketplace.classList.toggle("opened_main_bid")
			info.classList.toggle("opened_gallery_1_bid_container")
			button.classList.toggle("opened_gallery_1_bid_button")
		} else if (part === "gallery2") {
			//var marketplace = document.getElementById("marketplace")
			var info = document.getElementById("gallery_2_bid_info")
			var button = document.getElementById("gallery_2_bid_button")
			//marketplace.classList.toggle("opened_main_bid")
			info.classList.toggle("opened_gallery_2_bid_container")
			button.classList.toggle("opened_gallery_2_bid_button")
		} else if (part === "gallery3") {
			//var marketplace = document.getElementById("marketplace")
			var info = document.getElementById("gallery_3_bid_info")
			var button = document.getElementById("gallery_3_bid_button")
			//marketplace.classList.toggle("opened_main_bid")
			info.classList.toggle("opened_gallery_3_bid_container")
			button.classList.toggle("opened_gallery_3_bid_button")
		}
	}
}

limitedTextareas = [
	"title_main",
	"button_main",
	"title_marketplace",
	"button_marketplace",
	"title_create",
	"button_create",
	"title_popular",
	"button_popular",
	"title_newsletter",
	"text_second_button",
	"title_site",
]

function adaptTextAreaSize(element) {
	console.log(element, "adaptTextAreaSize", element.name)
	var limited = false

	for (var i = 0; i < limitedTextareas.length; i++) {
		if (element.name === limitedTextareas[i]) {
			limited = true
			break
		}
	};

	if (limited){
		//Pour avoir le meilleur résultat, il faudrait remplacer les mot-clés persos par leur équivalant HTML
		//pour avoir la vrai taille du texte. Mais j'ai plus assez de temps

		var inputValue = element.value
		var currentLength = inputValue.length

		if (currentLength > 255) {
			element.value = inputValue.substring(0, 255)
			currentLength = 255
		}
	}

	element.style.height = "auto"
	element.style.height = element.scrollHeight + "px"
}

function updateCountdowns() {
	console.log(weeklyDates, "updateCountdowns")
	var endshowcaseDate = new Date(showcaseDate)
	var currentDate = new Date()
	var time = endshowcaseDate - currentDate

	var endInterval = 0

	var days = Math.floor(time / (1000 * 60 * 60 * 24))
	var hours = Math.floor((time % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))
	var minutes = Math.floor((time % (1000 * 60 * 60)) / (1000 * 60))
	var seconds = Math.floor((time % (1000 * 60)) / 1000)

	if (seconds < 10) {
		seconds = "0" + seconds
	}
	if (minutes < 10) {
		minutes = "0" + minutes
	}
	if (hours < 10) {
		hours = "0" + hours
	}
	if (days < 10) {
		days = "0" + days
	}

	if (days > 0)
		document.getElementById("timeleft_main").innerHTML = days + ":" + hours + ":" + minutes + ":" + seconds
	else
		document.getElementById("timeleft_main").innerHTML = hours + ":" + minutes + ":" + seconds

	if (time <= 0) {
		endInterval++
		document.getElementById("timeleft_main").innerHTML = "00:00:00"
	}

	weeklyDates.forEach(function(date) {

	})

	for (var i = 0; i < weeklyDates.length; i++) {
		var date = new Date(weeklyDates[i])
		var time = date - currentDate

		var days = Math.floor(time / (1000 * 60 * 60 * 24))
		var hours = Math.floor((time % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))
		var minutes = Math.floor((time % (1000 * 60 * 60)) / (1000 * 60))
		var seconds = Math.floor((time % (1000 * 60)) / 1000)

		if (seconds < 10) {
			seconds = "0" + seconds
		}
		if (minutes < 10) {
			minutes = "0" + minutes
		}
		if (hours < 10) {
			hours = "0" + hours
		}
		if (days < 10) {
			days = "0" + days
		}

		if (days > 0)
			document.getElementById("timeleft_"+(i+1)).innerHTML = days + ":" + hours + ":" + minutes + ":" + seconds
		else
			document.getElementById("timeleft_"+(i+1)).innerHTML = hours + ":" + minutes + ":" + seconds

		if (time <= 0) {
			endInterval++
			document.getElementById("timeleft_"+(i+1)).innerHTML = "00:00:00"
		}

		if (endInterval >= 4)
			clearInterval(interval)
	}
}

function inversePanel() {
	document.getElementById("userpanel").classList.toggle("hidden")
	document.getElementById("adminpanel").classList.toggle("hidden")

	if (!document.getElementById("adminpanel").classList.contains("hidden")) {
		var textareas = document.querySelectorAll("textarea");
	    textareas.forEach(function(textarea) {
	      adaptTextAreaSize(textarea)
	    });
	}
}

window.addEventListener("load", function() {
    var textareas = document.querySelectorAll("textarea");
    textareas.forEach(function(textarea) {
      adaptTextAreaSize(textarea)
    });

    if (typeof(showcaseDate) !== 'undefined' && typeof(weeklyDates) !== 'undefined') {
    	updateCountdowns()
		var interval = setInterval(updateCountdowns, 1000)
	}
});