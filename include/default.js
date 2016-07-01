var dF;
var d;
var l;
var i = 0;
var c = 0;

function pageLoad() {
	//cFontSize(getCookie('FontSize'));
}

function printWin() {
	window.print();
}

function cFontSize(fsize) {
	document.getElementById('Content').style.fontSize = fsize + '%';
	setCookie('FontSize', fsize, 7);
}

function setCookie(name, value, days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime() + (days*24*60*60*1000));
		var expires = "; expires=" + date.toGMTString();
	}
	else var expires = '';
	document.cookie = name + '=' + value + expires + "; path=/";
}

function getCookie(name) {
	var nameEQ = name + '=';
	var ca = document.cookie.split(';');
	for(i = 0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
}

function toggleLayer(l) {
	if (document.getElementById) {
		var style = document.getElementById(l).style;
		style.display = style.display? "":"block";
	} else if (document.all) {
		var style = document.all[l].style;
		style.display = style.display? "":"block";
	} else if (document.layers) {
		var style = document.layers[l].style;
		style.display = style.display? "":"block";
	}
}

function contactSubmit() {
	dF = document.form;
	eC = '#C00';
	dC = '#FFF';
	var eName = 0;
	var eMail = 0;
	var eMsg = 0;
	var eChk = 0;
	
	if (dF.mailName.value) {
		dF.mailName.style.borderColor = dC;
	} else {
		dF.mailName.style.borderColor = eC;
		eName = 1;
	}
	if (dF.mailEmail.value) {
		dF.mailEmail.style.borderColor = dC;
	} else {
		dF.mailEmail.style.borderColor = eC;
		eMail = 1;
	}
	if (dF.mailMsg.value) {
		dF.mailMsg.style.borderColor = dC;
	} else {
		dF.mailMsg.style.borderColor = eC;
		eMsg = 1;
	}
	if (dF.mailCheck.value == 5) {
		dF.mailCheck.style.borderColor = dC;
	} else {
		dF.mailCheck.style.borderColor = eC;
		eChk = 1;
	}

	if (eName || eMail || eMsg || eChk) {
		document.getElementById('ContactError').style.display = 'block';		
	} else {
		dF.method = 'post';
		dF.action = 'SendMail.m20';
		dF.submit();
	}
}