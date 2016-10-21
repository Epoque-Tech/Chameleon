/* global APP */

// Golbal APP
var APP = {};

// The PHP Script that handles AJAX requests.
APP.requestURL = '/RequestHandler.php';


/**
 * validateEmail
 * 
 * Takes a given email and return true if valid, and false otherwise.
 * 
 * @param {string} email
 * @returns {Boolean}
 */

APP.validateEmail = function(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
};


/**
 * validatePhoneNumber
 * 
 * Validates a given phone number, either 7 or 10 digits.
 * 
 * @param {string} phone
 * @returns {Boolean} True if phone is valid false otherwise.
 */

APP.validatePhoneNumber = function (phone) {
    var re1 = /^\(?(\d{3})\)?[- ]?(\d{3})[- ]?(\d{4})$/;
    var re2 = /^[0-9]{3}[\s-]?\d{4}$/;
    if (re1.test(phone)) {
        return true;
    }
    else if (re2.test(phone)) {
        return true;
    }
    else {
        return false;
    }
};


/**
 * processHtmlSimpleContactForm
 *
 * @param {type} id
 * @param {function} 
 * @returns {undefined}
 */

APP.processHtmlSimpleContactForm = function(id, callback) {
    var valid = true;
    
    var form = {
        "name" : document.getElementById(id + "-nameField").value,
        "contactInfo" : document.getElementById(id + "-contactInfo").value,
        "message" : document.getElementById(id + "-message").value
    };
    
    var errorDiv = document.getElementById(id + '-error');
    errorDiv.innerHTML = "";
    
    if (form.name === "") {
        valid = false;
        console.log("no name error");
        errorDiv.innerHTML += '<div class="alert alert-danger" role="alert">\
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>\
        <span class="sr-only">Error:</span>Enter a name.</div>';
    }
    if (form.contactInfo === "" ||
        (!APP.validateEmail(form.contactInfo) &&
        !APP.validatePhoneNumber(form.contactInfo)))
    {
        valid = false;
        console.log("no contact info error");
        errorDiv.innerHTML += '<div class="alert alert-danger" role="alert">\
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>\
        <span class="sr-only">Error:</span>Enter a valid email address or phone number.</div>';
    }
    if (form.message === "") {
        valid = false;
        console.log("no message error");
        errorDiv.innerHTML += '<div class="alert alert-danger" role="alert">\
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>\
        <span class="sr-only">Error:</span>A message is required.</div>';
    }
    
    if (valid) {
        console.log("sending form to " + APP.requestURL);
        $.ajax({
            url: APP.requestURL,
            method: 'GET',
            data : { 'HtmlSimpleContactForm' : form },
            success: function (data, textStatus, jqXHR) {
                callback(data);
                document.getElementById(id + "-nameField").value = '';
                document.getElementById(id + "-contactInfo").value = '';
                document.getElementById(id + "-message").value = '';
                console.log(data);
            }
        });
    }
    else {
        console.log("not sending form to " + APP.requestURL);
    }
    console.log(form);
};


/**
 * sqlSelectQuery
 * 
 * @returns {undefined}
 */

APP.sqlSelectQuery = function (spec) {
    (typeof spec === 'undefined') ? spec = {} : spec;

    $.ajax({
        url: APP.requestURL,
        method: APP.method,
        data: {'select': spec.query ? spec.query : ''},
        success: spec.success ? spec.success : function (data, textStatus, jqXHR) {
            console.log(data);
        }
    });
};

console.log('chameleon.js loaded');

