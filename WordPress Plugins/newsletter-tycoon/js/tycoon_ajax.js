// Note: most of the functions here should be removed in version 2.0 and replaced either with CSS3 or jQuery

// global variables
var newsletterRequest = false;
var newsletterURL = '';
var loadingDiv = '';
var formDiv = '';
var alpha = 1;

//submit the form via ajax
function makeRequest(parameters) {
	createRequestObject();
	newsletterRequest.setVar('email', parameters['email']);
	newsletterRequest.setVar('newsletter', parameters['newsletter']);
	newsletterRequest.method = 'GET';
	newsletterRequest.element = formDiv;
	newsletterRequest.onCompletion = alertContents;
	newsletterRequest.runAJAX();
}

//create the communication object
function createRequestObject() {
	newsletterRequest = new sack(newsletterURL);
}

//act on the server response
function alertContents() {
	FadeIn();           
}

//prints the server response
function printResponse(){
	alert(http_request.responseText);
	var response = http_request.responseXML.documentElement;
	var n = response.getElementsByTagName('result')[0].firstChild.nodeValue;

	message= response.getElementsByTagName('message')[0].firstChild.nodeValue;
	document.getElementById(formDiv).innerHTML = message;
}

//fade out the form
function StartFade(url,fdiv,ldiv) {
	newsletterURL = url;
	formDiv = fdiv;
	loadingDiv = ldiv;
	tStart   = new Date();
	showDiv();
	timerID  = setTimeout("FadeOut()", 100);
}

//handles the fadeout of the formDiv element
function FadeOut(){
	alpha -= 0.1;
	if(alpha < 0) {
		alpha = 0;
		get();
	}
	else {
		obj = document.getElementById(formDiv);
		setOpacity(obj, alpha);
		setTimeout("FadeOut()", 100);
	}
}

//handles the fadein of the formDiv element
function FadeIn(){
	alpha += 0.1;
	if(alpha > 1) {
		hideDiv();
		alpha = 1;
	}
	else {
		obj = document.getElementById(formDiv);
		setOpacity(obj, alpha);
		setTimeout("FadeIn()", 100);
	}
}

//gets the values inserted in the newsletterFormDiv
function get() {
	var obj = document.getElementById('newsletterFormDiv');
	var getstr = '?';
	var params = new Array();
	for(i=0; i<obj.childNodes.length; i++) {
		if(obj.childNodes[i].tagName == 'INPUT') {
			if(obj.childNodes[i].type == 'text')
				params[obj.childNodes[i].name] = obj.childNodes[i].value;

			// added for HTML5 compatibility
			if(obj.childNodes[i].type == 'email')
				params[obj.childNodes[i].name] = obj.childNodes[i].value;

			if(obj.childNodes[i].type == 'checkbox') {
				if(obj.childNodes[i].checked)
					params[obj.childNodes[i].name] = obj.childNodes[i].value;
				else
					params[obj.childNodes[i].name] = "";
			}

			if(obj.childNodes[i].type == 'radio') {
				if(obj.childNodes[i].checked)
					params[obj.childNodes[i].name] = obj.childNodes[i].value;
			}

			if(obj.childNodes[i].type == 'hidden')
				params[obj.childNodes[i].name] = obj.childNodes[i].value;
		}   

		if(obj.childNodes[i].tagName == 'SELECT') {
			var sel = obj.childNodes[i];
			params[sel.name] = sel.options[sel.selectedIndex].value;
		}
	}
	makeRequest(params);
}

// shows a DIV element for progress information
function showDiv() {
	document.getElementById(loadingDiv).style.display = 'block';
}

// hides a DIV with the progress information
function hideDiv() {
	document.getElementById(loadingDiv).style.display = 'none';
}

// put the new input in the document
function setOuterHTML(element, toValue) {
	if(typeof(element.outerHTML) != 'undefined')
		element.outerHTML = toValue;
	else {
		var range = document.createRange();
		range.setStartBefore(element);
		element.parentNode.replaceChild(range.createContextualFragment(toValue), element);
	}
}		

// set the opacity of an element
// to be removed in version 2.0 and replaced either with CSS3 or jQuery
function setOpacity(aElm, aOpac) {
	var object = aElm.style;
	object.opacity = (aOpac);
	object.MozOpacity = (aOpac);
	object.KhtmlOpacity = (aOpac);
	object.filter = 'alpha(opacity=' + aOpac * 100 + ')';
}
