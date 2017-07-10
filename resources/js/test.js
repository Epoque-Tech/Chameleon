
(function () {
    var
    requestUrl = '/resources/requests.php',
    testDropdown = $('#test-dropdown').find('li');
    requestedTest = window.location.pathname.replace('/test/', ''),
    tests = [];

    // Valid tests are in the dropdown.
    for (let i = 0; i < testDropdown.length; i++) {
        tests.push(testDropdown[i].innerText)
    }


    if (tests.includes(requestedTest)) {
        $.ajax({
            url: requestUrl,
            data: {"test": requestedTest},
            success: data => {
                $('#output').html(data);
            }
        });
    }
    else {
        window.location = '/';
    }

}());

console.log('test.js loaded');

