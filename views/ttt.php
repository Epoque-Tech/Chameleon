<!doctype.html>
<head>
    <title>Tic-Hack-Toe</title>
    <style>
    table {
        position: absolute;
        top: 100px;
        left:350px;;
    }
    p {
        position: absolute;
        left: 390px;
    }
    button {
        position: absolute;
        left: 400px;
        top: 50px;
    }
    #declareVictory {
        position: absolute;
        top:260px;
        left:350px;
    }
    td {
        width: 50px;
        height: 50px;
    }
    .vert {
        border-right: 1px solid black;
    }
    .bot {
        border-bottom: 1px solid black;
    }
    </style>
</head>
<body>
    <table>
        <p>Tic-Tac-Toe</p>
        <tr>
            <td id="tl" class="vert bot"></td>
            <td id="tc" class="vert bot"></td>
            <td id="tr" class="bot"></td>
        </tr>
        <tr>
            <td id="ml" class="vert bot"></td>
            <td id="mc" class="vert bot"></td>
            <td id="mr" class="bot"></td>
        </tr>
        <tr>
            <td id="bl" class="vert"></td>
            <td id="bc" class="vert"></td>
            <td id="br" ></td>
        </tr>
    </table>
    <button id="reset">Reset</button>
    <p id='declareVictory'></p>

    <script>
    var tl = document.getElementById('tl');
    var tc = document.getElementById('tc');
    var tr = document.getElementById('tr');

    var ml = document.getElementById('ml');
    var mc = document.getElementById('mc');
    var mr = document.getElementById('mr');

    var bl = document.getElementById('bl');
    var bc = document.getElementById('bc');
    var br = document.getElementById('br');

    var triumph = document.getElementById('declareVictory');
    var reset   = document.getElementById('reset');
    
    var spaces = [ tl, tc, tr,
                   ml, mc, mr,
                   bl, bc, br ];

    var winning_path = [
      [tl, tc, tr], 
      [tl, ml, bl], 
      [ml, mc, mr],
      [tc, mc, bc],
      [bl, bc, br],
      [tr, mr, br],
      [tl, mc, br],
      [tr, mc, bl]
   ];

    var users_path = [];
    var comps_path = [];

    var main = function () {
        var win  = false;

        if (spaces.length > 0 && spaces.indexOf(this) !== -1) {

          // User picks a square.
          if (spaces.indexOf(this) !== -1) {
              this.style.backgroundColor = "red";
              spaces.splice(spaces.indexOf(this), 1)
          }
          users_path.push(this);

          if (users_path.length >= 3) {
            win = lookForWinner(users_path);
            if (win) {
              triumph.style.color = "red";
              triumph.innerHTML = 'You Win!';
            }
          }

          // Computer picks a square.
          var randomly = function () {
            return spaces[Math.floor(Math.random() * spaces.length)];
          };

          var odds = function () {
            if (!win) {
              var prob = [
                [mc],
                [tl, tr, bl, br],
                [tc, ml, mr, bc]
              ];

              for (i = 0; i < prob.length; i++) {
                for (j = 0; j < prob[i].length; j++) {

                  if (spaces.indexOf(prob[i][j]) !== -1) {
                    return prob[i][j];
                  }
                }
              }
            }
            else {
                return false;
            }
          };

          var lookAhead = function() {
            var c   = 0;
            var p       = false;
            var winpath = winning_path[0];
            var test    = false;

            console.log('comps_path.length: '+comps_path.length);
            if (comps_path.length === 0) {
              p = randomly();
            }
            else {
              while (c < winning_path.length && p === false) {
                console.log('c = '+c);
                for (i = 0; i < comps_path.length; i++) {
                  console.log('checking: '+ winpath[i].id);
                  console.log('against: '+ comps_path[i].id);
                  if (winpath[i] === comps_path[i] && spaces.indexOf(winpath[i]) !== -1) {
                    test = true;
                    console.log('the test: '+test);
                  }
                }
                if (test)
                  p = winpath[comps_path.length];
                else
                  winpath = winning_path[c++];
              }
            }
            if (p === false) {
              p = odds();
            }
            return p;
          }

          var strats = [randomly, odds, lookAhead];
          var func   = strats[parseInt((Math.random() * 10) % strats.length)];
          var pick   = lookAhead();

          if (pick) {
            console.log(func);
            console.log('computer picks: '+pick.id);

            pick.style.backgroundColor = "blue";
            comps_path.push(pick);

            if (comps_path.length >= 3) {
              win = lookForWinner(comps_path);
              if (win) {
                triumph.style.color = "blue";
                triumph.innerHTML = 'Computer Wins!'
              }
            }
          spaces.splice(spaces.indexOf(pick), 1);
        }
      }
    };


    var lookForWinner = function(path) {
      var winner   = true;
      var win_path = [];

      for (i = 0; i < winning_path.length; i++) {
        winner = true;
        win_path = winning_path[i];
        for (j = 0; j < winning_path[i].length; j++) {
          if (path.indexOf(winning_path[i][j]) === -1) {
            winner = false;
          }
        }

        if (winner === true) {
          for (i = 0; i < win_path.length; i++) {
            win_path[i].style.backgroundColor = "yellow";
          }
          spaces = [];
          break;
        }
      }

      return winner;
    }

    var resetGame = function() {
        spaces = [ tl, tc, tr,
                   ml, mc, mr,
                   bl, bc, br ];        

        users_path        = [];
        comps_path        = [];
        triumph.innerHTML = '';

        spaces.forEach(function(e, i, a) {
            e.style.backgroundColor = "white";
        });
    }


    for (i = 0; i < spaces.length; i++) {
        spaces[i].onclick = main;
    }
    reset.onclick = resetGame;
    </script>
</body>
</html>
