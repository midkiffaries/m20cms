var http = getHTTPObject();
var isWorking = false;
var tableOffset = 20;
var dF;
var d;

function handleHttpResponse() {
	dF = document.form;
	d = document;
	if (http.readyState == 4 || http.readyState == 'complete') {
		if (http.responseText.indexOf('invalid') == -1) {
			results = http.responseText.split('|||');
			dF.numRows.value = results[0];
			d.getElementById('entryNum').innerHTML = results[0];
			d.getElementById('listTable').innerHTML = results[1];
			d.getElementById('errorReport').innerHTML = '<ul>' + results[2] + '</ul>';
			dF.item0.value = results[3];
			dF.item1.value = results[4];
			dF.item2.value = results[5];
			dF.item3.value = results[6];
			dF.item4.value = results[7];
			dF.item5.value = results[8];
			dF.item6.value = results[9];
			dF.item7.value = results[10];
			dF.item8.value = results[11];
			
			//if (checkPage()) {
			//	document.getElementById('wysiwygtextBox').contentWindow.document.body.innerHTML = results[12];
			//} else {
				dF.textBox.value = results[12];
			//}
			
			if (dF.Page.value == 'calendar') {
				if (results[11] == 1) dF.item8.checked = 1;
				whenFrom = results[6].split(' ',3);
				whenTo = results[8].split(' ',3);
				dF.item3a.value = whenFrom[0];
				dF.item3b.value = whenFrom[1];
				dF.item5a.value = whenTo[0];
				dF.item5b.value = whenTo[1];
			}
			if (dF.Page.value == 'blog') {	
				if (results[8] == 1) dF.item5.checked = 1;
				if (results[9] == 1) dF.item6.checked = 1;
			}

			if (!results[2] && !dF.Filter.value && d.getElementById('overlay').style.visibility == 'visible' && dF.itemFunction.value == 0) {				
				clearForm();
				overlay();
			}
			
			d.getElementById('Processing').style.display = 'none';
			isWorking = false;
		}
	} else {
		d.getElementById('Processing').innerHTML = '<img src="template/graphics/throbber.gif"/> Loading, please wait...';
		d.getElementById('Processing').style.display = 'block';
	}
}

function Ajax() {
	dF = document.form;
	
	if (dF.Page.value == 'blog') {
		checkBox('item5');
		checkBox('item6');
	}
	if (dF.Page.value == 'calendar') {
		dF.item3.value = dF.item3a.value + ' ' + dF.item3b.value;
		dF.item5.value = dF.item5a.value + ' ' + dF.item5b.value;
		checkBox('item8');
	}
	//if (checkPage()) {
	//	var frameDoc = cleanGet(document.getElementById('wysiwygtextBox').contentWindow.document.body.innerHTML);
	//} else {
		//var frameDoc = cleanGet(dF.textBox.value);
	//}
	
	if (!isWorking && http) {
		var url = "include/process.ajax.php";
		var vars = "p=" + dF.Page.value +
			"&itemFunction=" + dF.itemFunction.value +
			"&id=" + dF.item0.value +
			"&item1=" + cleanGet(dF.item1.value) +
			"&item2=" + cleanGet(dF.item2.value) +
			"&item3=" + cleanGet(dF.item3.value) +
			"&item4=" + cleanGet(dF.item4.value) +
			"&item5=" + cleanGet(dF.item5.value) +
			"&item6=" + cleanGet(dF.item6.value) +
			"&item7=" + cleanGet(dF.item7.value) +
			"&item8=" + cleanGet(dF.item8.value) +
			"&textBox=" + cleanGet(dF.textBox.value) +
			//"&textBox=" + frameDoc +
			"&monthOffset=" + dF.monthOffset.value +
			"&tableIndex=" + dF.tableIndex.value +
			"&Filter=" + dF.Filter.value +
			"&listOrder=" + dF.listOrder.value;
		http.open('post', url, true);
		http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		http.setRequestHeader("Content-length",vars.length);
		http.setRequestHeader("Connection","close");
		http.onreadystatechange = handleHttpResponse;
		isWorking = true;
		http.send(vars);

		if (dF.numRows.value < tableOffset) {
			document.getElementById('tableNav').style.visibility = 'hidden';
		}
		
		if (document.getElementById('errorReport').innerHTML) {
			clearForm();
		}
	}
	
	if (!http) {
		alert("Your browser is not supported by this application.");
	}
}

function getHTTPObject() {
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

function displayLayer(layerId, displayType) {
	if (document.getElementById) {
		document.getElementById(layerId).style.display = displayType;
	} else if (document.all) {
		document.all[layerId].style.display = displayType;
	} else if (document.layers) {
		document.layers[layerId].style.display = displayType;
	}
}

function flipInput(selectBox, inputBox) {
	dF = document.form;
	if (dF.inputBox.style.display == 'none') {
		dF.selectBox.style.display = 'none';
		dF.inputBox.style.display = 'inline';
	} else {
		dF.selectBox.style.display = 'inline';
		dF.inputBox.style.display = 'none';
	}
}

function changeFontSize(fsize) {
	dF = document.form;
	document.getElementById('Content').style.fontSize = fsize + '%';
	if (dF.largeFont.disabled == '') {
		dFlargeFont.disabled = 'disabled';
		dF.smallFont.disabled = '';
	} else {
		dF.largeFont.disabled = '';
		dF.smallFont.disabled = 'disabled';
	}
}

function loadJS() {
	//if (checkPage()) document.getElementById('textBox').style.display = 'none';
	addListItems();
	Ajax();
}

function overlay() {
	el = document.getElementById('overlay');
	el.style.visibility = (el.style.visibility == 'visible') ? 'hidden' : 'visible';
	sel = document.form.listOrder;
	sel.style.visibility = (sel.style.visibility == 'hidden') ? 'visible' : 'hidden';
	if (checkPage()) { 
		//ifr = document.getElementById('wysiwygtextBox');
		//ifr.style.display = (ifr.style.display == 'none') ? 'block' : 'none';
	}
}

function openWindow(url) {
	var width = 640;
	var height = 480;
	var left = screen.availWidth / 2 - width / 2;
	var top = screen.availHeight / 2 - height / 2;
	openWin = window.open(url,'Window','left=' + left + ',top=' + top + ',width=' + width + ',height=' + height + ',resizable=yes,scrollbars=yes,toolbar=no,location=yes');
}

function deleteEntry(id) {
	if (confirm("Are you sure you want to delete this entry?")) {
		getID(id);
		itemFunc(3);
		Ajax();
	}
}

function createEntry() {
	overlay();
	clearForm();
	itemFunc(2);
	document.form.item1.focus();
}

function createEvent(d) {
	overlay();
	clearForm();
	itemFunc(2);
	document.form.item3a.value = d;
	document.form.item5a.value = d;
	document.form.item1.focus();
}

function editEntry(id) {
	overlay();
	clearForm();
	getID(id);
	Ajax();
	itemFunc(1);
}

function saveBtn() {
	dF = document.form;
	var frmError = 1;
	if (dF.Page.value == 'users' && dF.item1.value && dF.item2.value && dF.item3.value && dF.item4.value && dF.item5.value && dF.item6.value) frmError = 0;
	if (dF.Page.value == 'blog' && dF.item1.value && dF.item2.value) frmError = 0;
	if (dF.Page.value == 'calendar' && dF.item1.value && dF.item2.value && dF.item3a.value && dF.item3b.value && dF.item5a.value && dF.item5b.value && dF.item6.value) frmError = 0;
	if (dF.Page.value == 'poll' && dF.item1.value && dF.item2.value) frmError = 0;
	if (dF.Page.value == 'page' && dF.item1.value && dF.item2.value) frmError = 0;
	if (dF.Page.value == 'gallery' && dF.item1.value && dF.item2.value && dF.item3.value && dF.item5.value) frmError = 0;
	if (dF.Page.value == 'comments' && dF.item1.value && dF.item2.value && dF.item3.value) frmError = 0;
		
	if (frmError) {
		alert("The entire form must be completed to create this item.");
	} else {
		Ajax();
	}
}

function cancelBtn() {
	overlay();
	clearForm();
}
/*
function previewBtn() {
	if (document.getElementById('previewBox').style.display == 'none') {
		document.getElementById('previewBox').style.display = 'block';
		document.form.item4.style.height = '160px';
		previewText(document.form.item4.value);
	} else {
		document.getElementById('previewBox').style.display = 'none';
		document.form.item4.style.height = '280px';
		previewText(document.form.item4.value);
	}
}

function previewText(v) {
	document.getElementById('previewBox').innerHTML = v;
}
*/
function Logout() {
	if (confirm("Are you sure you want to log out?")) { 
		location.href = '?p=logout';
	}
}

function getID(id) {
	document.form.item0.value = id;
}

function itemFunc(n) {
	document.form.itemFunction.value = n;
}

function tablePlus() {
	dF = document.form;
	if (parseInt(dF.tableIndex.value) <= dF.numRows.value) {
		dF.tableIndex.value = parseInt(dF.tableIndex.value) + tableOffset;
	}
	Ajax();
}

function tableMinus() {
	dF = document.form;
	if (parseInt(dF.tableIndex.value) > 0) {
		dF.tableIndex.value = parseInt(dF.tableIndex.value) - tableOffset;
	}
	Ajax();
}

function textboxFocus(el) {
	dF = document.form.el.value;
	if (dF == 'Search') {
		dF = '';
	} else if (dF == '') {
		dF = 'Search';
	}
}

function clearForm() {
	itemFunc(0);
	getID(0);
	dF = document.form;
	dF.item0.value = '';
	dF.item1.value = '';
	dF.item2.value = '';
	dF.item3.value = '';
	dF.item4.value = '';
	dF.item5.value = '';
	dF.item6.value = '';
	dF.item7.value = '';
	dF.item8.value = '';
	dF.item5.checked = 0;
	dF.item6.checked = 0;
	dF.textBox.value = '';
	//if (checkPage()) document.getElementById('wysiwygtextBox').contentWindow.document.body.innerHTML = '';
	
	if (dF.Page.value == 'calendar') {
		dF.item3a.value = '';
		dF.item3b.value = '9:00am';
		dF.item5a.value = '';
		dF.item5b.value = '10:00am';
		dF.item7.value = 0;
		dF.item8.checked = 0;
	}
}

function checkBox(chk) {
	dF = document.form;
	if (dF[chk].checked == 1) {
		dF[chk].value = 1;
	} else {
		dF[chk].value = 0;
	}
}

function changeMonth(n) {
	dF = document.form;
	var offset = parseInt(dF.monthOffset.value);
	offset += n;
	dF.monthOffset.value = offset;
	Ajax();
}

function cleanGet(str) {
	str = str.replace(/#/g, "%23");
	str = str.replace(/&/g, "%26");
	str = str.replace(/=/g, "%3D");
	str = str.replace(/\?/g, "%3F");
	str = str.replace(/</g, "%3C");
	str = str.replace(/>/g, "%3E");
	return str;
}

function checkPage() {
	dF = document.form;
	if (dF.Page.value == 'blog' || dF.Page.value == 'page' || dF.Page.value == 'calendar') {
		return 1;
	} else {
		return 0;
	}
}

function viewImage(url) {
	var newImg = new Image();
	newImg.src = url;
	document.getElementById('imageBox').style.width = newImg.width + 'px';
	document.getElementById('imageBox').style.height = newImg.height + 'px';
	document.getElementById('imageBox').style.background = '#FFFFFF url(' + url + ') no-repeat 10px 10px';
	document.getElementById('imageBox').style.display = 'block';
}

function addCatagories(n) {
	dF = document.form;
	if (dF.catagorySelect.value) {
		document.form[n].value += dF.catagorySelect.value + ',';
	}
}

function setAllDay() {
	document.form.item3b.value = '12:00am';
	document.form.item5b.value = '12:00am';
}

function addListItems() {
	dF = document.form;
	if ((dF.Page.value == 'blog') || (dF.Page.value == 'page') || (dF.Page.value == 'gallery')) {
		dF.catagorySelect.options[2] = new Option('Arts', 'arts');
		dF.catagorySelect.options[3] = new Option('Business', 'business');
		dF.catagorySelect.options[4] = new Option('Entertainment', 'entertainment');
		dF.catagorySelect.options[5] = new Option('Gaming', 'gaming');
		dF.catagorySelect.options[6] = new Option('Holiday', 'holiday');
		dF.catagorySelect.options[7] = new Option('Humor', 'humor');
		dF.catagorySelect.options[8] = new Option('Interent', 'internet');
		dF.catagorySelect.options[9] = new Option('Media', 'media');
		dF.catagorySelect.options[10] = new Option('Programming', 'programming');
		dF.catagorySelect.options[11] = new Option('Shopping', 'shopping');
		dF.catagorySelect.options[12] = new Option('Technology', 'technology');
		dF.catagorySelect.options[13] = new Option('Website', 'website');
		dF.catagorySelect.options[14] = new Option('World', 'world');
	}
	if (dF.Page.value == 'calendar') {
		dF.catagorySelect.options[2] = new Option('Appointment', 'appointment');
		dF.catagorySelect.options[3] = new Option('Birthday', 'birthday');
		dF.catagorySelect.options[4] = new Option('Business', 'business');
		dF.catagorySelect.options[5] = new Option('Family', 'family');
		dF.catagorySelect.options[6] = new Option('Holiday', 'holiday');
		dF.catagorySelect.options[7] = new Option('Meeting', 'meeting');
		dF.catagorySelect.options[8] = new Option('Personal', 'personal');
		dF.catagorySelect.options[9] = new Option('School', 'school');
		dF.catagorySelect.options[10] = new Option('Vacation', 'vacation');
	}
}

prog = new Image(16,16);
prog.src = 'template/graphics/throbber.gif';

bg = new Image(10,10); 
bg.src = 'template/layout/overlay.png';

bg_ie = new Image(50,50); 
bg_ie.src = 'template/layout/overlay_ie.png';