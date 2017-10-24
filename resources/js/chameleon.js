/* @var The global APP object **/
var APP = {};


/**
 * Extending the String type to add ucfirst method.
 * Makes first character of string upper case.
 */

String.prototype.ucfirst = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
};


/**
 * Extending the String type to add lcfirst method.
 * Makes first character of string lower case.
 */

String.prototype.lcfirst = function() {
    return this.charAt(0).toLowerCase() + this.slice(1);
};


/**
 * request
 *
 * Parses the location object and sets the path
 * (eg /path/to/method) as method, and the param argument
 * pairs into an object set as args (ie .
 *
 * @return {object} {method:location.pathname, args:{}}
 */

APP.request = () => {
    let req = {};

    req.method = location.pathname;

    if (location.search) {
        req.args = {};
        args = location.search.replace(/^\?/, '');

        args.split('&').forEach( (arg) => {
            tmp = arg.split('=');
            req.args[tmp[0]] = decodeURI(tmp[1]).replace(/(^"|"$)?/g, '');
        });
    }

    return req;
};


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

console.log('chameleon.js loaded');
