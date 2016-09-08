(function () {
    var GRAY   = 'rgb(129, 127, 130)';
    var BLACK  = 'rgb(0, 0, 0)';
    var RED    = 'rgb(135, 8, 6)';
    var BLUE   = 'rgb(8, 6, 135)';

    var X      = 0;
    var Y      = 1;
    var ORIGIN = [150, 150];
    var UNITS  = 150/15;


    var draw = function () {
        var pt1 = $('#pt1').val().split(',');
        var pt2 = $('#pt2').val().split(',');

        drawLine(pt1, pt2, BLACK);
    };

    var clear = function () {
        var canvas = document.getElementById('line-draw-canvas');
        var c2d = canvas.getContext('2d');

        c2d.clearRect(0, 0, ORIGIN[X]*2, ORIGIN[Y]*2);
        drawPlane();
    };


    var drawPlane = function() {
        var canvas = document.getElementById('line-draw-canvas');
        var c2d = canvas.getContext('2d');

        c2d.strokeStyle = BLACK;

        c2d.beginPath();
        c2d.moveTo(ORIGIN[X], ORIGIN[Y]);
        c2d.lineTo(0, 150);
        c2d.stroke();

        c2d.beginPath();
        c2d.moveTo(ORIGIN[X], ORIGIN[Y]);
        c2d.lineTo(ORIGIN[X], 0);
        c2d.stroke();

        c2d.beginPath();
        c2d.moveTo(ORIGIN[X], ORIGIN[Y]);
        c2d.lineTo(ORIGIN[X]+ORIGIN[Y], ORIGIN[Y]);
        c2d.stroke();

        c2d.beginPath();
        c2d.moveTo(ORIGIN[X], ORIGIN[Y]);
        c2d.lineTo(ORIGIN[X], ORIGIN[X]+ORIGIN[Y]);
        c2d.stroke();
    };


    var drawLine = function(startPoint, endPoint, color) {
        var canvas = document.getElementById('line-draw-canvas');
        var c2d = canvas.getContext('2d');
        var lineColor = color;

        var a = [ORIGIN[X]+(startPoint[X]*UNITS), ORIGIN[Y]-(startPoint[Y]*UNITS)];
        var b = [ORIGIN[X]+(endPoint[X]*UNITS), ORIGIN[Y]-(endPoint[Y]*UNITS)];

        c2d.strokeStyle = lineColor;
        c2d.beginPath();
        c2d.moveTo(a[X], a[Y]);
        c2d.lineTo(b[X], b[Y]);

        console.log('Drawing line (' + startPoint[X] + ', ' + startPoint[Y] + '), ' +
            '(' + endPoint[X] + ', ' + endPoint[Y] + ')');
        c2d.stroke();
    };

    drawPlane();
    $('#draw-btn').click(draw);
    $('#clear-btn').click(clear);
}());

console.log('drawLine.js loaded');
