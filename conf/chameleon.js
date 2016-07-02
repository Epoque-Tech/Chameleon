/* global APP */

/**
 * processHtmlSimpleContactForm
 * @param {type} id
 * @returns {undefined}
 */

APP.processHtmlSimpleContactForm = function(id) {
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
    if (form.contactInfo === "") {
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
