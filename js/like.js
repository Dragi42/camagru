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
var button = document.querySelectorAll('#like-button')
for (var j = 0; j < button.length; j++) {
	let p = j
	button[j].addEventListener('click', function (e) {
		var errorElements = button[p].parentNode.parentNode.querySelectorAll('.has-error')
		var successElements = button[p].parentNode.parentNode.querySelectorAll('.has-success')
		if (errorElements) {
			for (var i = 0; i < errorElements.length; i++) {
				errorElements[i].classList.remove('has-error')
				errorElements[i].classList.remove('alert-danger')
				var span = errorElements[i].querySelector('.help-block')
				if (span) {
					span.parentNode.removeChild(span)
				}
			}
		}
		if (successElements) {
			for (var i = 0; i < successElements.length; i++) {
				successElements[i].classList.remove('has-success')
				successElements[i].classList.remove('alert-success')
				var span = successElements[i].querySelector('.help-block')
				if (span) {
					span.parentNode.removeChild(span)
				}
			}
		}
		e.preventDefault()

		var data = new FormData()
		data.append('picture_id', button[p].value)
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
						button[p].parentNode.classList.add('alert-danger')
						button[p].parentNode.classList.add('has-error')
						button[p].parentNode.appendChild(span) 
					}
				}
				else {
					var success = JSON.parse(xhr.responseText)
					var successKey = Object.keys(success)
					for (var i = 0; i < successKey.length; i++) {
						var key = successKey[i]
						var result = success[key]
						if (key === 'like') {
							button[p].querySelector('p').textContent++
							button[p].querySelector('i').textContent = "favorite"
							button[p].querySelector('i').style.color = "red"
						}
						else {
							button[p].querySelector('p').textContent--
							button[p].querySelector('i').textContent = "favorite_border"
							button[p].querySelector('i').style.color = "black"
						}
//						var span = document.createElement('span')
//						span.className = 'help-block'
//						span.innerHTML = result
//						button[p].parentNode.classList.add('has-success')
//						button[p].parentNode.classList.add('alert-success')
//						button[p].parentNode.appendChild(span) 
//						alert(result.success)	
					}
				}
			}
		}
		xhr.open('POST', button[p].getAttribute('formaction'), true)
		xhr.setRequestHeader('X-Requested-With', 'xmlhttprequest')
		xhr.send(data)
	})
}
