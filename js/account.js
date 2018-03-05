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

var form = []

form.push(document.querySelector('#sign-up'))
form.push(document.querySelector('#sign-in'))

for (var j = 0; j < form.length; j++) {
	let p = j
	form[j].addEventListener('submit', function (e) {
		var button = form[p].querySelector('button[type=submit]')
		var buttonText = button.textContent
		button.disabled = true
		button.textContent = 'Loading...'
		var errorElements = form[p].querySelectorAll('.has-error')
		for (var i = 0; i < errorElements.length; i++) {
			errorElements[i].classList.remove('has-error')
			var span = errorElements[i].querySelector('.help-block')
			if (span) {
				span.parentNode.removeChild(span)
			}
		}
		e.preventDefault()

		var data = new FormData(form[p])
		var xhr = getHttpRequest();
		xhr.onreadystatechange = function () {
			if (xhr.readyState === 4) {
				if (xhr.status != 200) {
					var errors = JSON.parse(xhr.responseText)
					var errorsKey = Object.keys(errors)
					for (var i = 0; i < errorsKey.length; i++) {
						var key = errorsKey[i]
						var error = errors[key]
						var input = document.querySelector('[name=' + key + ']')
						var span = document.createElement('span')
						span.className = 'help-block'
						span.innerHTML = error 
						input.parentNode.classList.add('has-error')
						input.parentNode.appendChild(span) 
					}
				}
				else {
					if (p == 1) {
						window.location.replace('../')
					}
					else {
						var result = JSON.parse(xhr.responseText)
						alert(result.success)												//--------------------------------------
						var inputs = form[p].querySelectorAll('input')
						for (var i = 0; i < inputs.length; i++) {
							inputs[i].value = ''
						}
					}
				}
				button.disabled = false
				button.textContent = buttonText
			}
		}
		xhr.open('POST', form[p].getAttribute('action'), true)
		xhr.setRequestHeader('X-Requested-With', 'xmlhttprequest')
		xhr.send(data)
	})
}
