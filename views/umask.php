<br>
<br>
<div class="col-md-6 col-md-offset-2">
    <h1>Umask</h1>
    
    <style>
    .perm, .mask {
        width: 40px;
        height: 40px;
        font-family: sans;
        font-size: 16pt;
        text-align: center;
    }
    </style>

    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-2">
                <p>Enter desired permissions in first set of boxes</p>
                <input class="perm" type="text" value=7>
                <input class="perm" type="text" value=5>
                <input class="perm" type="text" value=5>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-md-offset-2">
                <input class="mask" type="text" value=0 disabled>
                <input class="mask" type="text" value=2 disabled>
                <input class="mask" type="text" value=2 disabled>
            </div>
        </div>
    </div>

    <script>
    var perm = document.getElementsByClassName('perm');
    var mask = document.getElementsByClassName('mask');

    var umask = function() {
        for (var i = 0; i < mask.length; i++) {
            if (perm[i].value > 7) {
                perm[i].value = 7;
            }
            else if (perm[i].value < 0) {
                perm[i].value = 0;
            }

            mask[i].value = 7 - (parseInt(perm[i].value) || 0);
        }
    }

    umask();
    
    for (var i = 0; i < perm.length; i++) {
        perm[i].addEventListener('keyup', umask)
    }
    </script>
</div>
