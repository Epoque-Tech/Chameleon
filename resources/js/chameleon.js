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
        errorDiv.innerHTML += "Please provide a name.<br>";
    }
    if (form.contactInfo === "") {
        valid = false;
        console.log("no contact info error");
        errorDiv.innerHTML += "Please provide a phone number or valid email address.<br>";
    }
    if (form.contactInfo === "") {
        valid = false;
        console.log("no message error");
        errorDiv.innerHTML += "Please write a message.<br>";
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
