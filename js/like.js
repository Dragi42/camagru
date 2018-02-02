var getHttpRequest = function () {

	var httpRequest = false;

	if (window.XMLHttpRequest) { // Mozilla, Safari,...
		httpRequest = new XMLHttpRequest();
		if (httpRequest.overrideMimeType) {
			httpRequest.overrideMimeType('text/xml');
		}
	}
	else if (window.ActiveXObject) { // IE
		try {
			httpRequest = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e) {
			try {
				httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e) {}
		}
	}

	if (!httpRequest) {
		alert('Abandon :( Impossible de créer une instance XMLHTTP');
		return false;
	}

	return httpRequest
}

/*var form = []

form.push(document.querySelector('#like-form'))
form.push(document.querySelector('#image-form'))*/
var button = document.querySelector('#like-button')
console.log(button);
//for (var j = 0; j < form.length; j++) {
//	let p = j
	button.addEventListener('click', function (e) {
		console.log(button);
		var errorElements = button.parentElement.querySelector('.has-error')
		console.log(errorElements);
		if (errorElements) {
			for (var i = 0; i < errorElements.length; i++) {
			errorElements[i].classList.remove('has-error')
			var span = errorElements[i].querySelector('.help-block')
			if (span) {
				span.parentNode.removeChild(span)
			}
		}
		}
		e.preventDefault()

		var data = new FormData()
		data.append('picture_id', button.value)
		var xhr = getHttpRequest()
		xhr.onreadystatechange = function () {
			if (xhr.readyState === 4) {
				if (xhr.status != 200) {
					var errors = JSON.parse(xhr.responseText)
					var errorsKey = Object.keys(errors)
					for (var i = 0; i < errorsKey.length; i++) {
						var key = errorsKey[i]
						var error = errors[key]
						var span = document.createElement('span')
						span.className = 'help-block'
						span.innerHTML = error 
						button.parentNode.classList.add('has-error')
						button.parentNode.appendChild(span) 
					}
				}
				else {
					var result = JSON.parse(xhr.responseText)
					alert(result.success)
				}
			}
		}
		xhr.open('POST', button.getAttribute('formaction'), true)
		xhr.setRequestHeader('X-Requested-With', 'xmlhttprequest')
		xhr.send(data)
	})
