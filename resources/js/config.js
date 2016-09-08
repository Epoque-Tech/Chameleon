
/**
 * config.js
 * 
 * The JavaScript configuration for Chameleon contained in the APP
 * global object.
 */


String.prototype.hashCode = function() {
  var hash = 0, i, chr, len;
  if (this.length === 0) return hash;
  for (i = 0, len = this.length; i < len; i++) {
    chr   = this.charCodeAt(i);
    hash  = ((hash << 5) - hash) + chr;
    hash |= 0; // Convert to 32bit integer
  }
  return hash;
};


// Golbal APP
var APP = {};

// The PHP Script that handles AJAX requests.
APP.requestURL = 'RequestHandler.php';


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
