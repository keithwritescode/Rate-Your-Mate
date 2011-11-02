/**
* Constructor of the Ajax (Asynchronous JavaScript + XML) object
* Object realize communication between web page and server using JavaScript
* and browser abilities.
* Works in Mozilla 1.0, Safari 1.2, Opera 8.0 and Internet Explorer 5.0
*
* @author	Dmitry Baranovskiy	<Dmitry.Baranovskiy@optus.com.au>
*
* @return object
* @access public
*/

TAjax = function()
{

	this.isIE = false;
	this.responseXML = null;
	this.temp = null;

	this.pool = Array();
	this.inProcess = false;

/**
* sends request and loads content by URL using method
* content should have type "application/xml"
* @param	url				URL
* @param	parameters		parameters of the request ['var1=value1&var2=value2&var3=...']
* @param	method			'POST' or 'GET'
*
* @return void
* @access public
*/
	this.send = function(url, parameters, method, func)
	{
		if (typeof parameters == "undefined" || parameters == "") parameters = null;
		if (typeof func == "undefined" || func == "") func = null;
		if (typeof method == "undefined" || method == "") method = "GET";
		else method = method.toUpperCase();

		if (method == "GET" && parameters != null) {
			url += "?" + parameters;
			parameters = null;
		}

		if (this.inProcess) {
			var request = new Object();
			request.url = url;
			request.parameters = parameters;
			request.method = method;
			request.func = func;
			this.pool.push(request);
			return false;
		}

		this.inProcess = true;

		if (func != null) {
			this.temp = this.process;
			this.process = func;
		}

		if (window.XMLHttpRequest) {
			Global_XMLHttp_Request = new XMLHttpRequest();
			Global_XMLHttp_Request.onreadystatechange = processReqChange;
			Global_XMLHttp_Request.open(method, url, true);
			if (method == "POST") {
				Global_XMLHttp_Request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			}
			Global_XMLHttp_Request.send(parameters);
		} else if (window.ActiveXObject) {
			this.isIE = true;
			Global_XMLHttp_Request = new ActiveXObject("Microsoft.XMLHTTP");
			if (Global_XMLHttp_Request) {
				Global_XMLHttp_Request.onreadystatechange = processReqChange;
				Global_XMLHttp_Request.open(method, url, true);
				if (method == "POST") {
					Global_XMLHttp_Request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				}
				if (parameters == null) {
					Global_XMLHttp_Request.send();
				}
				else {
					Global_XMLHttp_Request.send(parameters);
				}
			}
		}
		this.onsend();
		return true;

	}


/**
* check is browser supports XMLHttp object
*
* @return boolean
* @access public
*/
	this.isBrowserOk = function()
	{
		try {
			if (window.XMLHttpRequest) return true;
			if (window.ActiveXObject) return true;
			return false;
		}
		catch(e) {
			return false;
		}

	}//end isBrowserOk


/**
* return XMLHttpRequest object
*
* @return object
* @access public
*/
	this.request = function()
	{
		return Global_XMLHttp_Request;

	}//end request


/**
* process XML receiving
*
* @return void
* @access public
*/
	this.process = function()
	{
		//do nothing

	}//end process


/**
* returns content of the response
*
* @return String
* @access public
*/
	this.getXML = function()
	{
		return Global_XMLHttp_Request.responseText;

	}//end getXML


/**
* returns content of the response
*
* @return String
* @access public
*/
	this.getXMLobject = function()
	{
		return Global_XMLHttp_Request.responseXML;

	}//end getXML


/**
* will be called on error in processing (could be overwriten)
*
* @param	message		error message
*
* @return String
* @access public
*/
	this.processError = function(message)
	{
		//do nothing;
		alert(message);
	}//end processError


/**
* will be called on error in receiving (could be overwriten)
*
* @param	message		error message
* @param	status		status code
*
* @return String
* @access public
*/
	this.receiveError = function(message, status)
	{
		//do nothing;
		alert(message + "|" + status)
	}//end receiveError


/**
* will be called on send (could be overwriten)
*
* @return String
* @access public
*/
	this.onsend = function()
	{
		//do nothing;
	}//end receiveError


/**
* will be called on load (could be overwriten)
*
* @return String
* @access public
*/
	this.onload = function()
	{
		//do nothing;
	}//end receiveError


/**
* sends form data via XMLHttp
*
* @param	formid		form id
* @param	func		handler
*
* @return void
* @access public
*/
	this.submitForm = function(formid, func)
	{
		if (typeof formid == "object") {
			var form = formid;
		} else {
			var form = document.getElementById(formid);
		}
		var post = "";
		for (var i = 0; i < form.length; i++) {
			post += ((form.elements[i].id == "")?(form.elements[i].name):(form.elements[i].id)) + "=" + form.elements[i].value + "&";
		}

		this.send(form.action, post, form.method, func);

	}


/**
* sends form data via XMLHttp
*
* @param	divid		div id
* @param	url			content URL
*
* @return void
* @access public
*/
	this.loadContent = function(divid, url)
	{
		if (document.getElementById(divid) == null) {
			return false;
		}
		var func = function()
		{
			document.getElementById(divid).innerHTML = this.getXML();
		}
		this.send(url, "", "", func);
		return true;

	}
}


/**
* handle onreadystatechange event of request object
*
* @return void
* @access public
*/
function processReqChange() {
		// only if req shows "loaded"
		if (Global_XMLHttp_Request.readyState == 4) {
			// only if "OK"
			if (Global_XMLHttp_Request.status == 200) {
				Ajax.responseXML = Global_XMLHttp_Request.responseXML;
				try {
					Ajax.inProcess = false;
					Ajax.onload();
					Ajax.process();
					if (Ajax.temp != null) {
						Ajax.process	= Ajax.temp;
						Ajax.temp		= null;
					}
					if (Ajax.pool.length > 0) {
						var request = Ajax.pool.shift();
						Ajax.send(request.url, request.parameters, request.method, request.func);
					}
				}
				catch (e) {
					Ajax.processError(e.message);
				}
			 } else {
				 Ajax.receiveError(Global_XMLHttp_Request.statusText, Global_XMLHttp_Request.status);
			 }
		}

	}


// global request and XML document objects
var Global_XMLHttp_Request = null;

// if no XMLHttp variable created, create it.
if (typeof Ajax == "undefined") Ajax = new TAjax();
