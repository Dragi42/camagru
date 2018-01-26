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

var form = document.querySelector('#loginform')
form.addEventListener('submit', function (e) {
	e.preventDefault()

	var data = new FormData(form)
	var xhr = getHttpRequest();
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4) {
			
		}
	}
	xhr.open('POST', form.getAttribute('action'), true)
	xhr.setRequestHeader('X-Requested-With', 'xmlhttprequest')
	xhr.send(data)
})
