
/**
 * config.js
 * 
 * The JavaScript configuration for Chameleon contained in the APP
 * global object.
 */


// Golbal APP
var APP = {};

// The PHP Script that handles AJAX requests.
APP.requestURL = '|REQUEST_URL|';


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


console.log('config.js loaded');
