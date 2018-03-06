var	video = document.querySelector("#camera-stream"),
	image = document.querySelector("#snap"),
	start_camera = document.querySelector("#start-camera"),
	start_upload = document.querySelector("#start-upload"),
	controls = document.querySelector(".controls"),
	filters = document.querySelector("#filters"),
	filter_snap = document.querySelector("#filter-snap"),
	take_photo_btn = document.querySelector('#take-photo'),
	delete_photo_btn = document.querySelector('#delete-photo'),
	upload_photo_btn = document.querySelector('#upload-photo'),
	filter = 0,
	error_message = document.querySelector('#error-message');

	navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia || navigator.oGetUserMedia;

if (!navigator.getUserMedia){
	displayErrorMessage("Your browser doesn't have support for the navigator.getUserMedia interface.");
}

else {
	navigator.getUserMedia(
			{video: true},
			function(stream) {
				video.src = window.URL.createObjectURL(stream);
//				video.play();
///				video.onplay = function() {
//					showVideo();
//				};
			},
			function(err) {
				displayErrorMessage("There was an error with accessing the camera stream: " + err.name, err);
			}
		);
}

start_camera.addEventListener("click", function(e){

	e.preventDefault();

	// Start video playback manually.
	video.play();
	showVideo();
});

take_photo_btn.addEventListener("click", function(e){

	e.preventDefault();

	var snap = takeSnapshot();

	// Show Image.
	image.setAttribute('src', snap);
	image.classList.add("visible");

	// Enable delete and save buttons
	delete_photo_btn.classList.remove("disabled");
	take_photo_btn.classList.add("disabled");
	upload_photo_btn.classList.remove("disabled");

	// Pause video playback of stream.
	video.pause();
});

function selectFilter(button) {
	var child = filters.children;
	for (i = 0; i < child.length; i++) {
		child[i].style.background = "";
	}
	if (image.className == "visible" || video.className == "visible") {
		filter = button.children[0].src;
		button.style.background = "grey";
		filter_snap.setAttribute('src', filter);
		filter_snap.classList.add("visible");
		if (!image.src) {
			take_photo_btn.classList.remove("disabled");
		}
		else {
			upload_photo_btn.classList.remove("disabled");
		}
	}
//	}
}

upload_photo_btn.addEventListener("click", function(e){

	e.preventDefault();

	// Show Image.
	image.innerHTML = "<form method='POST' action='./modeles/images/upload.php'><input type='hidden' name='image'><input type='hidden' name='filter'></form>";
	form = image.children[0];
	inputimg = image.children[0].children[0];
	inputfilter = image.children[0].children[1];
	inputimg.setAttribute('value', image.getAttribute('src'));
	inputfilter.setAttribute('value', filter);
	form.submit();
});

delete_photo_btn.addEventListener("click", function(e){
	e.preventDefault();
	
	// Hide image.
	image.removeAttribute('src');
	image.classList.remove("visible");
	filter_snap.removeAttribute('src');
	filter_snap.classList.remove("visible");

	// Disable delete and save buttons
	upload_photo_btn.classList.add("disabled");
	take_photo_btn.classList.add("disabled");
	start_upload.children[0].value = '';
	var child = filters.children;
	for (i = 0; i < child.length; i++) {
		child[i].style.background = "";
	}
	filter = "";

	// Resume playback of stream.
	showUI();
});

function	showVideo() {
	// Display the video stream and the controls.

	hideUI();
	video.classList.add("visible");
	controls.classList.add("visible");
}

function takeSnapshot() {
	// Here we're using a trick that involves a hidden canvas element.

	var hidden_canvas = document.querySelector('canvas'),
		context = hidden_canvas.getContext('2d');

	var width = video.videoWidth,
		height = video.videoHeight;

	if (width && height) {

		// Setup a canvas with the same dimensions as the video.
		hidden_canvas.width = width;
		hidden_canvas.height = height;

		// Make a copy of the current frame in the video on the canvas.
		context.drawImage(video, 0, 0, width, height);

		// Turn the canvas image into a dataURL that can be used as a src for our photo.
		return hidden_canvas.toDataURL('image/png');
	}
}

function displayErrorMessage(error_msg, error){

	error = error || "";
	if(error){
		console.log(error);
	}

	error_message.innerText = error_msg;

	hideUI();
	start_upload.style.display = "block";
	error_message.classList.add("visible");
}

function showUI(){
	// Helper function for clearing the app UI.

	controls.classList.remove("visible");
	start_camera.style.display = "block";
	start_upload.style.display = "block";
	video.classList.remove("visible");
	snap.classList.remove("visible");
	error_message.classList.remove("visible");
}

function hideUI(){
	// Helper function for clearing the app UI.

	controls.classList.remove("visible");
	start_camera.classList.remove("visible");
	start_upload.classList.remove("visible");
	start_camera.style.display = "none";
	start_upload.style.display = "none";
	video.classList.remove("visible");
	snap.classList.remove("visible");
	error_message.classList.remove("visible");
}

function readURL(input) {
	var extension = input.files[0].name.split('.').pop();
	if (extension == "jpeg" || extension == "jpg" || extension == "png") {
		getBase64(input.files[0], mdrmdr);
	}
}

function mdrmdr(snap) {
	video.play();
	showVideo();

	image.setAttribute('src', snap);
	image.classList.add("visible");

	// Enable delete and save buttons
	take_photo_btn.classList.add("disabled");

	// Pause video playback of stream.
	video.pause();
}

function getBase64(file, callback) {
	var reader = new FileReader();
	reader.readAsDataURL(file);
	reader.onload = function () {
		callback(reader.result);
	};
	reader.onerror = function (error) {
		console.log('Error: ', error);
	};
}
