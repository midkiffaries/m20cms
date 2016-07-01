var http;
var dF;
var d;

function Ajax() {
	dF = document.form;
	http = GetXmlHttpObject();
	if (http) {
		var url = "ajax.php";
		var vars = "pollID=" + dF.pollID.value +
			"&poll=" + dF.poll.value;
		http.open('post', url, true);
		http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		http.setRequestHeader("Content-length",vars.length);
		http.setRequestHeader("Connection","close");
		http.onreadystatechange = stateChanged;
		isWorking = true;
		http.send(vars);
	}
	if (!http) {
		alert("Your browser is not supported by this application.");
	}
} 

function stateChanged() {
	dF = document.form;
	if (http.readyState == 4 || http.readyState == 'complete') {
		if (http.responseText.indexOf('invalid') == -1) {
			response = http.responseText.split('||');
			document.getElementById('PollBox').innerHTML = response[0];
			dF.return2.value = response[1];
		}
		document.getElementById('Processing').style.display = 'none';
		isWorking = false;
	} else {
		document.getElementById('Processing').style.display = 'block';
	}
}

function GetXmlHttpObject() {
	http = null;
	try {
		http = new XMLHttpRequest();
	} catch (e) {
		try {
			http = new ActiveXObject('Msxml2.XMLHTTP');
		} catch (e) {
			http = new ActiveXObject('Microsoft.XMLHTTP');
		}
	}
	return http;
}