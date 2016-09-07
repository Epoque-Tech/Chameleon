<!doctype html>
<head>
</head>
<body>
    <style>
    #table {
        position:absolute;
        top: 10%;
        left: 10%;
        width: 600px;
        height: 400px;
        background-color: green;
    }
    .card {
        width: 40px;
        height: 70px;
        border: 2px solid black;
        float: left;
        margin: 5px 15px 5px 5px;
    }
    </style>
    <div id="table">
        <div id="pArea">
            <span id="p1" class="card"></span>
            <span id="p2" class="card"></span>
        </div>
        <div id="dArea">
            <span id="d1" class="card"></span>
            <span id="d2" class="card"></span>
        </div>
    </div>

    <script>
    var  d = document;
    var p1 = d.getElementById('p1');

    p1.onclick = function () {
        this.innerHTML = 'A &spades';
    }
    </script>
</body>
</html>
